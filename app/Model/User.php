<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    const TABLE = 'users';
    //columns
    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const TOKEN = 'remember_token';
    const IS_ME = 'is_me';  //the field not store in the table

    //relation
    public function profiles()
    {
        return $this->hasMany(UserProfile::class);
    }
    public function profile()
    {
        return $this->hasOne(UserProfile::class, UserProfile::USER_ID, self::ID);
    }
    
    protected function organizations()
    {
        /*return $this->belongsToMany(Organization::class, 
            OrganizationHasUser::TABLE, 
            OrganizationHasUser::ORG_ID, OrganizationHasUser::USER_ID);//*/
        return $this->belongsToMany(Organization::class, 
            OrganizationHasUser::TABLE, 
            OrganizationHasUser::USER_ID, OrganizationHasUser::ORG_ID);
    }
    public function getOrganizationAttribute()
    {
        //return $this->organizations->first();
        return $this->organizations->first();
    }
    
    public function mobiles()
    {
        return $this->belongsToMany(Mobile::class, 
            UserHasMobile::TABLE, 
            UserHasMobile::USER_ID, UserHasMobile::TOKEN);
    }
    
    public function consoles()
    {
        return $this->belongsToMany(Console::class, 
            UserHasConsole::TABLE, 
            UserHasConsole::USER_ID, UserHasConsole::SERIAL_NO)->withTimestamps();
    }
    
    /**
     * @return ComplianceApp array format
     */
    public function complianceApps()
    {
        //return $this->hasMany(ComplianceApp::class)->withTimestamps();
        //return $this->hasMany(ComplianceApp::class);
        return $this->hasMany(ComplianceApp::class)->orderBy(ComplianceApp::ARCHIVE_DATE);
        //return $this->hasMany(ComplianceApp::class)->orderBy(ComplianceApp::ARCHIVE_DATE, 'desc');
    }
    
    /**
     * @param string $archiveDate
     * @return ComplianceApp array format
     */
    public function complianceAppsByData($archiveDate)
    {
        return $this->complianceApps->where(ComplianceApp::ARCHIVE_DATE, '=', $archiveDate);
    }
    
    /**
     * @return ComplianceConsole array format
     */
    public function complianceConsoles()
    {
        return $this->hasMany(ComplianceConsole::class);
    }
    
    /*protected function cares()
    {
        return $this->hasMany(Care::class)->where(Care::APPROVAL, '=', 1);
    }//*/
    /**
     * @return User array format
     */
    public function getCaresAttribute()
    {
        $beCares = collect();
        $this->isMe = true;
        $beCares->push($this);
        
        $cares = UserCareUsers::where(UserCareUsers::USER_ID, '=', $this->id)->get();
        foreach( $cares as $care )
        {
            $careId = $care->beCareId;
            $user = User::where(User::ID, '=', $careId)->first();
            $user->isMe = false;
            $beCares->push($user);
        }
        
        $children = $this->allChildren;
        foreach( $children as $child )
        {
            $child->isMe = false;
            $beCares->push($child);
        }
        
        if( $beCares->count() == 1 )
        {
            $beCares->pop();
        }
        return $beCares;
        
        /*return $this->belongsToMany(User::class, 
            UserCareUsers::TABLE,
            UserCareUsers::USER_ID, UserCareUsers::BE_CARED_ID);//*/
        //return $beCares;
        /*$array = collect();
        $cares = $this->hasMany(Care::class)->where(Care::APPROVAL, '=', 1);
        
        foreach( $cares as $care )
        {
            $array->push($care);
        }
        
        $children = $this->allChildren;
        foreach( $children as $child )
        {
            $care = new Care();
            $care->id = $child->id;
            $care->userId = $child->id;
            $array->push($care);
        }
        
        return $array;//*/
    }
    
    /*public function children()
    {
        return $this->hasManyThrough(Organization::class, User::class, User::ID, Organization::PARENT_ID, User::ID);
    }//*/
    //utility for organization and operations
    public function getChildrenAttribute()
    {
        $orgChildren = $this->organization->children;
        if( $orgChildren->count() == 0 )
        {
            return collect();
        }
        
        $result = collect();
        foreach( $orgChildren as $org )
        {
            $this->collectUsersInOrganization($org, $result);
        }
        return $result;
    }
    
    public function getAllChildrenAttribute()
    {
        $orgChildren = $this->organization->children;
        $result = collect();
        foreach( $orgChildren as $org )
        {
            $this->recursiveIteratorUsers($org, $result);
        }
        return $result;
    }
    
    private function recursiveIteratorUsers($org, $array)
    {
        $this->collectUsersInOrganization($org, $array);
        
        if( $org->children->count() == 0 )
        {
            return;
        }
        
        foreach( $org->children as $org )
        {
            $this->recursiveIteratorUsers($org, $array);
        }
    }


    /**
     * @return User array format
     */
    public function getParentAttribute()
    {
        $orgParent = $this->organization->parent;
        return $this->collectUsersInOrganization($orgParent);
    }
    
    public function getSiblingAttribute()
    {
        $orgCurrent = $this->organization;
        return $this->collectUsersInOrganization($orgCurrent, null);
    }
    
    /**
     * @return Operation array format
     */
    public function getOperationsAttribute()
    {
        return $this->organization->operations;
    }
    
    //utility function
    public static function getUsersByEmail($email)
    {
        return User::where(self::EMAIL, '=', strtoupper($email))->get();
    }
    
    public static function getUserByEmail($email)
    {
        $users = User::where(self::EMAIL, '=', strtoupper($email))->get();
        if( $users->count() != 0x01 )
        {
            return null;
        }
        return $users->first();
    }
    
    public static function getUserByUserIdAndEmail($userId, $email)
    {
        $users = User::where([
            [self::ID, '=', $userId], 
            [self::EMAIL, '=', strtoupper($email)]
        ])->get();
        if( ($users == null) || ($users->count() != 1) )
        {
            return null;
        }
        return $users->first();
    }
    
    public static function getUserByEmailAndPassword($email, $password)
    {
        $users = self::getUsersByEmail($email);
        if( $users->count() != 1 )
        {
            return null;
        }
        
        $user = $users->first();
        if( $user->isPasswordCorrect($password) )
        {
            return $user;
        }
        return null;
    }

    public function isPasswordCorrect($password)
    {
        return \Hash::check($password, $this->password);
    }
    
    public function getLanguageAttribute()
    {
        return UserProfile::profile($this, UserProfile::LANGUAGE, UserProfile::DEFAULT_LANGUAGE);
    }
    
    public function getPrivilegeAttribute()
    {
        return UserProfile::profile($this, UserProfile::PRIVILEGE, 1);
    }
    
    public function newProfile($kvo)
    {
        if( $kvo == null )
        {
            return false;
        }
        if( !is_array($kvo) )
        {
            return false;
        }
        if( count($kvo) < 2 )  //2: [0]: key, [1]: value
        {
            return false;
        }
        
        $profile = new UserProfile();
        $profile->key = $kvo[0];
        $profile->value = $kvo[1];
        return $this->profiles()->save($profile);
    }
    
    /**
     * @param \App\Model\Organization $org
     * @param \Illuminate\Support\Collection $array
     */
    private function collectUsersInOrganization(Organization $org, $array=null)
    {
        if( !isset($array) )
        {
            $array = collect();
        }
        
        foreach($org->users as $user )
        {
            /*if( $user->id == $this->id && $includeMe )
            {
                $user->isMe = true;
                $array->push($user);
                continue;
            }
            else 
            {
                $array->push($user);
            }//*/
            if( $user->id != $this->id )
            {
                $array->push($user);
            }
        }
        
        return $array;
    }
    
    //column getter and setter
    public function getIdAttribute()
    {
        return $this->attributes[self::ID];
    }
    public function setIdAttribute($id)
    {
        $this->attributes[self::ID] = $id;
    }

    public function getNameAttribute()
    {
        $name = $this->attributes[self::NAME];
        if( isset($name) )
        {
            return $name;
        }
        return $this->attributes[self::EMAIL];
    }
    public function setNameAttribute($name)
    {
        $this->attributes[self::NAME] = $name;
    }

    public function getEmailAttribute()
    {
        return $this->attributes[self::EMAIL];
    }
    public function setEmailAttribute($email)
    {
        $this->attributes[self::EMAIL] = strtoupper($email);
    }

    public function getPasswordAttribute()
    {
        return $this->attributes[self::PASSWORD];
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes[self::PASSWORD] = \Hash::make($password);
    }
    
    public function getTokenAttribute()
    {
        return $this->attributes[self::TOKEN];
    }
    public function setTokenAttribute($token)
    {
        $this->attributes[self::TOKEN] = $token;
    }
    
    public function getIsMeAttribute()
    {
        return $this->attributes[self::IS_ME];
    }
    public function setIsMeAttribute($isMe)
    {
        $this->attributes[self::IS_ME] = $isMe;
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::NAME, self::EMAIL, self::PASSWORD,
        //'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::PASSWORD, self::TOKEN,
        //'password', 'remember_token',
    ];
}
