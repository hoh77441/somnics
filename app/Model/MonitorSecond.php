<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Utility\TArrayUtility;
use App\Utility\TConstant;

class MonitorSecond extends Model
{
    const TABLE = 'monitor_seconds';
    //columns
    const ID = 'id';
    const MONITOR_ID = 'monitor_id';
    //const SERIAL_NO = 'serial_no';
    const TIME = 'time_at';
    
    const PRESSURE = 'pressure';
    const BATTERY = 'battery';
    const STATUS = 'status';
    
    const IS_BATTERY_OK = 'is_battery_ok';
    const IS_TREATING = 'is_treating';
    const IS_LEAKING = 'is_leaking';
    const IS_FULL = 'is_full';
    const IS_WRONG = 'is_wrong';
    
    protected $connection = TConstant::FILE_CONNECTION;
    
    //relation
    public function master()
    {
        return $this->belongsTo(MonitorDate::class, self::MONITOR_ID, MonitorDate::ID);
    }
    
    public function getMonitorIdAttribute()
    {
        return $this->attributes[self::MONITOR_ID];
    }
    public function setMonitorIdAttribute($monitor)
    {
        $this->attributes[self::MONITOR_ID] = $monitor;
    }

    /*public function getSerialNoAttribute()
    {
        return $this->attributes[self::SERIAL_NO];
    }
    public function setSerialNoAttribute($serialNo)
    {
        $this->attributes[self::SERIAL_NO] = $serialNo;
    }//*/
    
    public function getTimeAttribute()
    {
        return $this->attributes[self::TIME];
    }
    public function setTimeAttribute($time)
    {
        $this->attributes[self::TIME] = $time;
    }
    
    public function getPressureAttribute()
    {
        return $this->attributes[self::PRESSURE];
    }
    public function setPressureAttribute($pressure)
    {
        $this->attributes[self::PRESSURE] = $pressure;
    }
    
    public function getBatteryAttribute()
    {
        return $this->attributes[self::BATTERY];
    }
    public function setBatteryAttribute($battery)
    {
        $this->attributes[self::BATTERY] = $battery;
    }
    
    public function getStatusAttribute()
    {
        return $this->attributes[self::STATUS];
    }
    public function setStatusAttribute($status)
    {
        $this->attributes[self::STATUS] = $status;
    }
    
    public function getIsBatteryOkAttribute()
    {
        return TArrayUtility::getValue($this->attributes, self::IS_BATTERY_OK, false);
    }
    public function setIsBatteryOkAttribute($isBatteryOk)
    {
        $this->attributes[self::IS_BATTERY_OK] = $isBatteryOk;
    }
    
    public function getIsTreatingAttribute()
    {
        return TArrayUtility::getValue($this->attributes, self::IS_TREATING, false);
    }
    public function setIsTreatingAttribute($isTreating)
    {
        $this->attributes[self::IS_TREATING] = $isTreating;
    }
    
    public function getIsLeakingAttribute()
    {
        return TArrayUtility::getValue($this->attributes, self::IS_LEAKING, false);
    }
    public function setIsLeakingAttribute($isLeaking)
    {
        $this->attributes[self::IS_LEAKING] = $isLeaking;
    }
    
    public function getIsFullAttribute()
    {
        return TArrayUtility::getValue($this->attributes, self::IS_FULL, false);
    }
    public function setIsFullAttribute($isFull)
    {
        $this->attributes[self::IS_FULL] = $isFull;
    }
    
    public function getIsWrongAttribute()
    {
        return TArrayUtility::getValue($this->attributes, self::IS_WRONG, false);
    }
    public function setIsWrongAttribute($isWrong)
    {
        $this->attributes[self::IS_WRONG] = $isWrong;
    }
}
