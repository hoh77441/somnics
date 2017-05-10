<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserHasConsole extends Model
{
    const TABLE = 'user_has_consoles';
    //columns
    const USER_ID = 'user_id';
    const SERIAL_NO = 'console_serial_no';
    const APP_TIME = 'app_time';
    
    public function getUserIdAttribute()
    {
        return $this->attributes[self::USER_ID];
    }
    public function setUserIdAttribute($userId)
    {
        $this->attributes[self::USER_ID] = $userId;
    }
    
    public function getSerialNoAttribute()
    {
        return $this->attributes[self::SERIAL_NO];
    }
    public function setSerialNoAttribute($serialNo)
    {
        $this->attributes[self::SERIAL_NO] = $serialNo;
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
