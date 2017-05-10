<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Utility\TDateUtility;
use App\Utility\TStringUtility;

//URL: http://stackoverflow.com/questions/23073214/laravel-query-builder-where-max-id
//URL: http://stackoverflow.com/questions/31501950/laravel-eloquent-select-max-with-other-columns
class ComplianceApp extends Model
{
    const TABLE = 'compliance_apps';
    //columns
    const ID = 'id';
    const USER_ID = 'user_id';
    const SERIAL_NO = 'serial_no';
    const APP_VERSION = 'version';
    const START = 'start';
    const END = 'end';
    
    const TREATMENT = 'treatment';  //for app's time
    const LEAKAGE = 'leakage';
    const TIME_ZONE = 'time_zone';
    const CONSOLE_TREATMENT = 'console_treatment';  //for console's time
    const CONSOLE_LEAKAGE = 'console_leakage';
    const LATITUDE = 'latitude';
    const LONGITUDE = 'longitude';
    
    const IS_NEW_ASSIGN = 'is_new_assign';
    const CONSOLE_START = 'console_start';
    const ARCHIVE_DATE = 'archive_date';  //for display 12:00:00PM ~ 11:59:59AM
    
    //relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function questionnaire()
    {
        return $this->hasOne(Questionnaire::class, Questionnaire::APP_ID, self::ID);
    }
    
    public function records()
    {
        //return $this->belongsToMany(ComplianceConsole::class, AppHasRecord::TABLE, AppHasRecord::APP_ID, AppHasRecord::RECORD_ID);
        return $this->hasMany(ComplianceConsole::class, ComplianceConsole::APP_ID, self::ID);
    }
    
    public function console()
    {
        return $this->hasOne(Console::class, Console::SERIAL_NO, self::SERIAL_NO);
    }
    
    //utility function
    public static function getLatestCompliance($userId, $serialNo=null)
    {
        if( TStringUtility::isEmpty($serialNo) )
        {
            $sql = sprintf('`%s` = (select max(`%s`) from %s where `%s`=%d)', 
                self::START, self::START,
                self::TABLE,
                self::USER_ID, $userId);
        }
        else
        {
            $sql = sprintf('`%s` = (select max(`%s`) from %s where `%s`=%d and `%s`="%s")', 
                self::START, self::START, 
                self::TABLE,
                self::USER_ID, $userId,
                self::SERIAL_NO, $serialNo);
        }
        
        $records = ComplianceApp::whereRaw($sql)->get();
        if( $records->count() == 0 )
        {
            return null;
        }
        return $records->first();
    }

    public static function getCompliance($userId, $serialNo, $startTime)
    {
        $records = ComplianceApp::where([
            [self::USER_ID, '=', $userId],
            [self::SERIAL_NO, '=', $serialNo],
            [self::START, '=', $startTime]
        ])->get();
        if( $records->count() == 0 )
        {
            return null;
        }
        return $records->first();
    }
    
    public static function getUsageDays(User $user)
    {
        $sql = sprintf('select count(distinct(%s)) as "usage" from %s where %s=%d',
            self::ARCHIVE_DATE, 
            self::TABLE,
            self::USER_ID, $user->id);
        $usage = DB::select($sql)[0]->usage;
        
        return $usage;
    }
    
    public static function getUsageTimes(User $user)
    {
        $sql = sprintf('select count(*) as "usage" from %s where %s=%d',
            self::TABLE,
            self::USER_ID, $user->id);
        $usage = DB::select($sql)[0]->usage;
        
        return $usage;
    }
    
    public function getIdAttribute()
    {
        return $this->attributes[self::ID];
    }
    public function setIdAttribute($id)
    {
        $this->attributes[self::ID] = $id;
    }
    
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
    
    public function getAppVersionAttribute()
    {
        return $this->attributes[self::APP_VERSION];
    }
    public function setAppVersionAttribute($version)
    {
        $this->attributes[self::APP_VERSION] = $version;
    }
    
    public function getStartAttribute()
    {
        return $this->attributes[self::START];
    }
    public function setStartAttribute($start)
    {
        $this->attributes[self::START] = $start;
        $this->attributes[self::ARCHIVE_DATE] = TDateUtility::appTimeToArchive($start);
    }
    
    public function getEndAttribute()
    {
        return $this->attributes[self::END];
    }
    public function setEndAttribute($end)
    {
        $this->attributes[self::END] = $end;
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
    
    public function getConsoleTreatmentAttribute()
    {
        return $this->attributes[self::CONSOLE_TREATMENT];
    }
    public function setConsoleTreatmentAttribute($treatment)
    {
        $this->attributes[self::CONSOLE_TREATMENT] = $treatment;
    }
    
    public function getConsoleLeakageAttribute()
    {
        return $this->attributes[self::CONSOLE_LEAKAGE];
    }
    public function setConsoleLeakageAttribute($leakage)
    {
        $this->attributes[self::CONSOLE_LEAKAGE] = $leakage;
    }
    
    public function getSealingAttribute()
    {
        return intval($this->treatment) - intval($this->leakage);
    }
    
    public function getTimeZoneAttribute()
    {
        return $this->attributes[self::TIME_ZONE];
    }
    public function setTimeZoneAttribute($timeZone)
    {
        $this->attributes[self::TIME_ZONE] = $timeZone;
    }
    
    public function getLatitudeAttribute()
    {
        return $this->attributes[self::LATITUDE];
    }
    public function setLatitudeAttribute($latitude)
    {
        $this->attributes[self::LATITUDE] = $latitude;
    }
    
    public function getLongitudeAttribute()
    {
        return $this->attributes[self::LONGITUDE];
    }
    public function setLongitudeAttribute($longitude)
    {
        $this->attributes[self::LONGITUDE] = $longitude;
    }
    
    public function getIsNewAssignAttribute()
    {
        return $this->attributes[self::IS_NEW_ASSIGN];
    }
    public function setIsNewAssignAttribute($isNewAssign)
    {
        $this->attributes[self::IS_NEW_ASSIGN] = $isNewAssign;
    }
    
    public function getConsoleStartAttribute()
    {
        return $this->attributes[self::CONSOLE_START];
    }
    public function setConsoleStartAttribute($consoleStart)
    {
        $this->attributes[self::CONSOLE_START] = $consoleStart;
    }
    
    public function getArchiveDateAttribute()
    {
        return $this->attributes[self::ARCHIVE_DATE];
    }
    public function setArchiveDateAttribute($archiveDate)
    {
        $this->attributes[self::ARCHIVE_DATE] = $archiveDate;
    }
}
