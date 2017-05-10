<?php
namespace App\Helper;

use Illuminate\Support\Facades\DB;

use App\Utility\TErrorCode;
use App\Utility\TStringUtility;
use App\Utility\JSONObject;
use App\Utility\TConstant;
use App\Helper\TAppHelper;

use App\Model\User;
use App\Model\UserProfile;
use App\Model\Organization;
use App\Model\ConsoleAssignToOrganization;

//URL: https://laracasts.com/discuss/channels/eloquent/do-you-use-database-transactions-for-your-eloquent-queries
//URL: http://fideloper.com/laravel-database-transactions
class TUserHelper extends THelper
{
    //for response
    const APP_RESPONSE_USER = 'userInfo';
    const AUTO_SEARCH_APPROPRIATE_PARENT = -1;
    
    public function __construct(TAppHelper $helper=null) 
    {
        parent::__construct();
        
        $this->helper = $helper;
        if( $helper == null )
        {
            $this->helper = new TAppHelper();
        }
    }
    
    public static function transferUserToLegacy(User $user)
    {
        $userInfo = array(
            'userId' => $user->id,
            'userName' => $user->email,
            'display' => $user->name,
            'privilege' => $user->privilege->value
        );
        return $userInfo;
    }

    /**
     * 
     * @param JSONObject $json
     * @param bool $addUserIfNotExist true will auto insert a record to database if the user was not exist
     * @return User null indicate error occure during the process, $lastError will indicate what happen
     */
    public function getUserInfoByJson(JSONObject $json, $addUserIfNotExist=false, $serialNo="")
    {
        $email = $this->helper->getEmail($json);
        $password = $this->helper->getPassword($json);
        $name = $this->helper->getUserName($json);
        
        $user = $this->getUserInfoByEmailAndPassword($email, $password, $name);
        if( $user != null )
        {
            return $user;
        }
        if( $this->lastError == TErrorCode::NOT_FOUND && $addUserIfNotExist )
        {
            $org = ConsoleAssignToOrganization::findOrganizationBySerialNo($serialNo);
            if( $org == null )
            {
                return $this->createNewUser($name, $email, $password);
            }
            else
            {
                return $this->createNewUser($name, $email, $password, $org->name);
            }
        }
        
        return null;
    }
    
    public function getUserInfoByEmailAndPassword($email, $password, $name=null, $addUserIfNotExist=false)
    {
        if( $email == null || $password == null )
        {
            $this->lastError = TErrorCode::ERROR_NULL_POINTER;
            $this->why = 'email or password is null';
            return null;
        }
        
        $users = User::getUsersByEmail($email);
        if( $users->count() == 0 )  //no such user
        {
            /*if( !$addUserIfNotExist )
            {
                $this->lastError = TErrorCode::NOT_FOUND;
                $this->why = 'no such user: ' . $email;
                return null;
            }
            
            //insert a new record
            return $this->createNewUser($name, $email, $password);//*/
            $this->lastError = TErrorCode::NOT_FOUND;
            $this->why = 'no such user: ' . $email;
            return null;
        }
        
        if( $users->count() > 1 )
        {
            $this->lastError = TErrorCode::ERROR_TOO_MANY_OPTION;
            $this->why = sprintf('found the same email(\'%s\'), count: %d', $email, $users->count());
            return null;
        }
        
        //process exist user, must to check the password
        $user = $users->first();  //because the email is unique
        if( !$user->isPasswordCorrect($password) )
        {
            $this->lastError = TErrorCode::ERROR_EMAIL_OR_PIN;
            $this->why = 'password is wrong';
            return null;
        }
        $this->lastError = TErrorCode::SUCCESS;
        $this->why = null;
        return $user;
    }
    
    public function getUserInfoById(JSONObject $json)
    {
        $id = $this->helper->getUserId($json); 
        if( $id === null )
        {
            $this->lastError = TErrorCode::ERROR_NULL_POINTER;
            $this->why = 'user id is null';
            return null;
        }
        
        $user = User::find($id);
        if( $user == null )
        {
            $this->lastError = TErrorCode::NOT_FOUND;
            $this->why = sprintf('user id: %d was not been found', $id);
            return null;
        }
        
        $password = $this->helper->getPassword($json);  //$this->getPassword($jUser);
        if( !$user->isPasswordCorrect($password) )
        {
            $this->lastError = TErrorCode::ERROR_EMAIL_OR_PIN;
            $this->why = 'passwrod not match';
            return null;
        }
        return $user;
    }
    
    public function responseToApp(User $user, $key=null)
    {
        $userInfo = self::transferUserToLegacy($user);
        
        $report = JSONObject::makeReport(TErrorCode::SUCCESS);
        if( TStringUtility::isEmpty($key) )
        {
            $key = self::APP_RESPONSE_USER;
        }
        $report->put($key, $userInfo);
        return $report;
    }

        /**
     * create a new user
     * @param string $name user display name
     * @param string $email email
     * @param string $password 
     * @param string $orgName organization name
     * @param \App\Model\Organization $organization null for auto detect by $orgName
     * @return User success will be return current user, failure will return null
     */
    public function createNewUser($name, $email, $password, $orgName=Organization::PATIENT, $organization=null)
    {
        $this->initHelper();
        DB::beginTransaction();
        
        do
        {
            $user = new User();
            if( $this->saveUser($user, $name, $email, $password) != TErrorCode::SUCCESS )
            {
                break;
            }
            if( $this->addProfiles($user) != TErrorCode::SUCCESS )
            {
                break;
            }
            if( $this->setupUserToOrganization($user, $orgName, $organization) != TErrorCode::SUCCESS )
            {
                break;
            }
        } while( false );
        
        if( !TErrorCode::isSuccess($this->lastError) )
        {
            DB::rollback();
            return null;
        }
        DB::commit();
        return $user;
    }
    
    protected function saveUser(User $user, $name, $email, $password)
    {
        if( TStringUtility::isEmpty($email) || TStringUtility::isEmpty($password) )
        {
            return TErrorCode::ERROR_EMPTY_DATA;
        }
        
        if( TStringUtility::isEmpty($name) )
        {
            $name = $email;
        }
        
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        if( !$user->save() )  //insert failed
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = sprintf('user save fail (%s,%s)', $email, $password);
            return $this->lastError;
        }
        
        return TErrorCode::SUCCESS;
    }
        
    /**
     * 1. add questionnaire_count_in_page (30) to user
     * 2. add language (en) to user
     * 3. add theme (default) to user
     * @param User $user the user will be add profile
     * @return error code
     */
    protected function addProfiles(User $user)
    {
        if( !$user->newProfile([UserProfile::QUESTIONNAIRE_COUNT_IN_PAGE, UserProfile::DEFAULT_QUESTIONNAIRE_COUNT]) )
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = 'profile save fail for page count';
            return $this->lastError;
        }
        if( !$user->newProfile([UserProfile::LANGUAGE, UserProfile::DEFAULT_LANGUAGE]) )
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = 'profile save fail for language';
            return $this->lastError;
        }
        if( !$user->newProfile([UserProfile::THEME, UserProfile::DEFAULT_THEME]) )
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = 'profile save fail for theme';
            return $this->lastError;
        }
        if( !$user->newProfile([UserProfile::PRIVILEGE, TConstant::privilege()]) )
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = 'profile save fail for privilege';
            return $this->lastError;
        }
        
        return TErrorCode::SUCCESS;
    }
    
    public function setupUserToOrganization(User $user, $name, $organization)
    {
        $org = Organization::findOrganizationByName($name);
        if( $organization == null )
        {
            if( $org == null )
            {
                $this->lastError = TErrorCode::ERROR_NO_CANDIDATE;
                $this->why = 'no appropriate organization';
                return $this->lastError;
            }
            $organization = $org;  //use searched target to save data
        }
        
        if( $org->name != $organization->name )
        {
            $organization->parentId = $org->parentId;
            if( !$organization->save() )
            {
                $this->lastError = TErrorCode::ERROR_DB_SAVE;
                $this->why = 'save organization fail';
                return $this->lastError;
            }
        }
        if( !$organization->users()->save($user) )
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = 'save user to the organization fail';
            return $this->lastError;
        }
        return TErrorCode::SUCCESS;
    }
    
    protected $helper;
}