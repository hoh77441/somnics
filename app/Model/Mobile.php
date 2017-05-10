<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mobile extends Model
{
    const TABLE = 'mobiles';
    //columns
    const TOKEN = 'token';
    const OS = 'os';
    const OS_VERSION = 'osVersion';
    
    //for column of model 
    protected $primaryKey = self::TOKEN;
    protected $keyType = 'string';
    public $incrementing = false;
    
    //relation
    public function users()
    {
        return $this->belongsToMany(User::class, 
            UserHasMobile::TABLE, 
            UserHasMobile::TOKEN, UserHasMobile::USER_ID)->withTimestamps();
    }
    
    //column getter and setter
    public function getTokenAttribute()
    {
        return $this->attributes[self::TOKEN];
    }
    public function setTokenAttribute($token)
    {
        $this->attributes[self::TOKEN] = $token;
    }
    
    public function getOsAttribute()
    {
        return $this->attributes[self::OS];
    }
    public function setOsAttribute($os)
    {
        $this->attributes[self::OS] = $os;
    }
    
    public function getOsVersionAttribute()
    {
        return $this->attributes[self::OS_VERSION];
    }
    public function setOsVersionAttribute($version)
    {
        $this->attributes[self::OS_VERSION] = $version;
    }
}
