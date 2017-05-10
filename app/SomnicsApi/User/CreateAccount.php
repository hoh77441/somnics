<?php
namespace App\SomnicsApi\User;

use App\SomnicsApi\ITask;

use App\Utility\JSONObject;
use App\Utility\TErrorCode;
use App\Utility\TStringUtility;
use App\Helper\TAppHelper;
use App\Helper\TUserHelper;

use App\Model\Organization;

class CreateAccount implements ITask
{
    public function __construct() 
    {
        $this->helper = new TAppHelper();
    }
    
    public function report(JSONObject $json) 
    {
        if( ($check=$this->checkParameters($json)) != TErrorCode::SUCCESS )
        {
            return JSONObject::makeReport($check, 'lack parameter');
        }
        if( ($check=$this->processUserInfo()) != TErrorCode::SUCCESS )
        {
            return JSONObject::makeReport($check);
        }
        
        return JSONObject::makeReport(TErrorCode::SUCCESS);
    }
    
    protected function checkParameters($json)
    {
        if( ($check=$this->checkUserInfo($json)) != TErrorCode::SUCCESS )
        {
            return $check;
        }
        if( ($check=$this->checkOrganizationInfo($json)) != TErrorCode::SUCCESS )
        {
            return $check;
        }
        
        return TErrorCode::SUCCESS;
    }
    
    protected function checkUserInfo($json)
    {
        $jsonUser = $this->helper->getUserJson($json);
        if( $this->helper->hasError() )
        {
            return $this->helper->getLastError();
        }
        
        $this->email = $this->helper->getEmail($jsonUser);
        $this->password = $this->helper->getPassword($jsonUser);
        $this->userId = $this->helper->getUserId($jsonUser);
        $this->name = $this->helper->getUserName($jsonUser);
        
        return TErrorCode::SUCCESS;
    }
    
    protected function checkOrganizationInfo($json)
    {
        $jsonOrganization = $this->helper->getJsonOrganization($json);
        if( $this->helper->hasError() )
        {
            return $this->helper->getLastError();
        }
        
        $this->asOrg = $this->helper->getAsOrganization($json);
        $this->orgName = $this->helper->getName($jsonOrganization);
        if( TStringUtility::isEmpty($this->asOrg) || TStringUtility::isEmpty($this->orgName) )
        {
            return TErrorCode::ERROR_NULL_POINTER;
        }
        
        return TErrorCode::SUCCESS;
    }

    protected function processUserInfo()
    {
        $this->userHelper = new TUserHelper($this->helper);
        $this->user = $this->userHelper->getUserInfoByEmailAndPassword($this->email, $this->password);
        if( $this->user != null )
        {
            return TErrorCode::SUCCESS;
        }
        
        return $this->createUser();
    }
    
    protected function createUser()
    {
        $org = new Organization();
        $org->name = $this->orgName;
        $user = $this->userHelper->createNewUser($this->name, $this->email, $this->password, $this->asOrg, $org);
        if( $user == null )
        {
            return $$this->userHelper->getLastError();
        }
        return TErrorCode::SUCCESS;
    }
    
    private $helper;  //TAppHelper
    private $userHelper;  //TUserHelper
    
    private $user;
    private $name;
    private $email;
    private $password;
    private $userId;
    
    private $asOrg;
    private $orgName;
}