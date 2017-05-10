<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserHasMobile extends Model
{
    const TABLE = 'user_has_mobiles';
    //columns
    const USER_ID = 'user_id';
    const TOKEN = 'mobile_token';
    const APP_TIME = 'app_time';
    
    public function getUserIdAttribute()
    {
        return $this->attributes[self::USER_ID];
    }
    public function setUserIdAttribute($userId)
    {
        $this->attributes[self::USER_ID] = $userId;
    }
    
    public function getTokenAttribute()
    {
        return $this->attributes[self::TOKEN];
    }
    public function setTokenAttribute($token)
    {
        $this->attributes[self::TOKEN] = $token;
    }
    
    public function getAppTimeAttribute()
    {
        return $this->attributes[self::APP_TIME];
    }
    public function setAppTimeAtAttribute($appTime)
    {
        $this->attributes[self::APP_TIME] = $appTime;
    }
}
