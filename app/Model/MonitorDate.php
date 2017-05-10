<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

//use App\Utility\TDateUtility;
use App\Utility\TConstant;

class MonitorDate extends Model
{
    const TABLE = 'monitor_dates';
    //columns
    const ID = 'id';
    const SERIAL_NO = 'serial_no';
    const ARCHIVE_DATE = 'archive_date';  //for display 12:00:00PM ~ 11:59:59AM
    const END = 'end';
    const AVERAGE_PRESSURE = 'avg_pressure';
    const MIN_PRESSURE = 'min_pressure';
    const MAX_PRESSURE = 'max_pressure';
    const AVERAGE_BATTERY = 'avg_battery';
    const MIN_BATTERY = 'min_battery';
    const MAX_BATTERY = 'max_battery';
    const TREATMENT = 'treatment';
    const LEAKAGE = 'leakage';
    const SEALING = 'sealing';
    //const AVERAGE_SEAL = 'avg_seal';
    
    protected $connection = TConstant::FILE_CONNECTION;
    
    //relation
    public function details()
    {
        return $this->hasMany(MonitorSecond::class, MonitorSecond::MONITOR_ID, self::ID);
    }
    
    public function getIdAttribute()
    {
        return $this->attributes[self::ID];
    }
    public function setIdAttribute($id)
    {
        $this->attributes[self::ID] = $id;
    }
    
    public function getSerialNoAttribute()
    {
        return $this->attributes[self::SERIAL_NO];
    }
    public function setSerialNoAttribute($serialNo)
    {
        $this->attributes[self::SERIAL_NO] = $serialNo;
    }
    
    public function getArchiveDateAttribute()
    {
        return $this->attributes[self::ARCHIVE_DATE];
    }
    public function setArchiveDateAttribute($archiveDate)
    {
        $this->attributes[self::ARCHIVE_DATE] = $archiveDate;
    }
    
    /*public function getStartAttribute()
    {
        return $this->MD_Start;
    }
    public function setStartAttribute($start)
    {
        $this->attributes[self::START] = $start;
        $this->attributes[self::ARCHIVE_DATE] = TDateUtility::appTimeToArchive($start);
    }//*/
    
    public function getEndAttribute()
    {
        return $this->attributes[self::END];
    }
    public function setEndAttribute($end)
    {
        $this->attributes[self::END] = $end;
    }
    
    public function getAveragePressureAttribute()
    {
        return $this->attributes[self::AVERAGE_PRESSURE];
    }
    public function setAveragePressureAttribute($averagePressure)
    {
        $this->attributes[self::AVERAGE_PRESSURE] = $averagePressure;
    }
    
    public function getAverageBatteryAttribute()
    {
        return $this->attributes[self::AVERAGE_BATTERY];
    }
    public function setAverageBatteryAttribute($averageBattery)
    {
        $this->attributes[self::AVERAGE_BATTERY] = $averageBattery;
    }
    
    /*public function getAverageSealAttribute()
    {
        return $this->attributes[self::AVERAGE_SEAL];
    }
    public function setAverageSealAttribute($averageSeal)
    {
        $this->attributes[self::AVERAGE_SEAL] = $averageSeal;
    }//*/
    
    public function getMinPressureAttribute()
    {
        return $this->attributes[self::MIN_PRESSURE];
    }
    public function setMinPressureAttribute($minPressure)
    {
        $this->attributes[self::MIN_PRESSURE] = $minPressure;
    }
    
    public function getMaxPressureAttribute()
    {
        return $this->attributes[self::MAX_PRESSURE];
    }
    public function setMaxPressureAttribute($maxPressure)
    {
        $this->attributes[self::MAX_PRESSURE] = $maxPressure;
    }
    
    public function getMinBatteryAttribute()
    {
        return $this->attributes[self::MIN_BATTERY];
    }
    public function setMinBatteryAttribute($minBattery)
    {
        $this->attributes[self::MIN_BATTERY] = $minBattery;
    }
    
    public function getMaxBatteryAttribute()
    {
        return $this->attributes[self::MAX_BATTERY];
    }
    public function setMaxBatteryAttribute($maxBattery)
    {
        $this->attributes[self::MAX_BATTERY] = $maxBattery;
    }
    
    public function getTreatmentAttribute()
    {
        return $this->attributes[self::TREATMENT];
    }
    public function setTreatmentAttribute($treatment)
    {
        $this->attributes[self::TREATMENT] = $treatment;
    }
    
    public function getLeakageAttribute()
    {
        return $this->attributes[self::LEAKAGE];
    }
    public function setLeakageAttribute($leakage)
    {
        $this->attributes[self::LEAKAGE] = $leakage;
    }
    
    public function getSealingAttribute()
    {
        return $this->attributes[self::SEALING];
    }
    public function setSealingAttribute($sealing)
    {
        $this->attributes[self::SEALING] = $sealing;
    }
}
