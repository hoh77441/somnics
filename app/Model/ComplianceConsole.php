<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Utility\TDateUtility;

//URL: http://stackoverflow.com/questions/36371796/laravel-eloquent-where-field-is-x-or-null
class ComplianceConsole extends Model
{
    const TABLE = 'compliance_consoles';
    //columns
    const ID = 'id';
    const USER_ID = 'user_id';
    const APP_ID = 'app_id';
    const SERIAL_NO = 'serial_no';
    const START = 'start';
    const END = 'end';
    const TREATMENT = 'treatment';
    const LEAKAGE = 'leakage';
    const TIME_ZONE = 'time_zone';
    const ARCHIVE_DATE = 'archive_date';  //for display 12:00:00PM ~ 11:59:59AM
    const APP_OR_CONSOLE = 'app_or_console';  //0 is console createed, 1: is app created
    const MATCH_APP_TIME = 'match_app_time';  //0: not match, maybe turn on console during no app to support, 1: matched
    
    //relation
    /*public function apps()
    {
        return $this->belongsToMany(ComplianceApp::class, AppHasRecord::TABLE, AppHasRecord::RECORD_ID, AppHasRecord::APP_ID);
    }//*/
    public function user()
    {
        return $this->belongsTo(User::class, self::USER_ID);
    }
    
    public function complianceApp()
    {
        //return $this->belongsTo(ComplianceApp::class);
        return $this->belongsTo(ComplianceApp::class, self::APP_ID);
    }
    
    //utility function
    public static function getNonMatches($userId, $serialNo)
    {
        $records = ComplianceConsole::where([
            [self::USER_ID, '=', $userId],
            [self::SERIAL_NO, '=', $serialNo]
        ])->whereNull(self::APP_ID)->get();
        if( $records->count() == 0 )
        {
            return null;
        }
        return $records;
    }
    
    public static function getRecords($userId, $serialNo, $appId=null)
    {
        if( $appId === null )
        {
            $records = ComplianceConsole::where([
                [self::USER_ID, '=', $userId],
                [self::SERIAL_NO, '=', $serialNo]
            ])->get();
        }
        else
        {
            $records = ComplianceConsole::where([
                [self::USER_ID, '=', $userId],
                [self::SERIAL_NO, '=', $serialNo],
                [self::APP_ID, '=', $appId]
            ])->get();
        }
        
        if( $records->count() == 0 )
        {
            return null;
        }
        return $records;
    }

    public static function getRecordsByAppId($appId)
    {
        $records = ComplianceConsole::where([
            [self::APP_ID, '=', $appId]
        ])->get();
        if( $records->count() == 0 )
        {
            return null;
        }
        
        return $records;
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
    
    public function getUserIdAttribute()
    {
        return $this->attributes[self::USER_ID];
    }
    public function setUserIdAttribute($userId)
    {
        $this->attributes[self::USER_ID] = $userId;
    }
    
    public function getAppIdAttribute()
    {
        return $this->attributes[self::APP_ID];
    }
    public function setAppIdAttribute($appId)
    {
        $this->attributes[self::APP_ID] = $appId;
    }
    
    public function getSerialNoAttribute()
    {
        return $this->attributes[self::SERIAL_NO];
    }
    public function setSerialNoAttribute($serialNo)
    {
        $this->attributes[self::SERIAL_NO] = $serialNo;
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
    
    public function getTimeZoneAttribute()
    {
        return $this->attributes[self::TIME_ZONE];
    }
    public function setTimeZoneAttribute($timeZone)
    {
        $this->attributes[self::TIME_ZONE] = $timeZone;
    }
    
    public function getArchiveDateAttribute()
    {
        return $this->attributes[self::ARCHIVE_DATE];
    }
    public function setArchiveDateAttribute($archiveDate)
    {
        $this->attributes[self::ARCHIVE_DATE] = $archiveDate;
    }
    
    public function getAppOrConsoleAttribute()
    {
        return $this->attributes[self::APP_OR_CONSOLE];
    }
    public function setAppOrConsoleAttribute($appOrConsole)
    {
        $this->attributes[self::APP_OR_CONSOLE] = $appOrConsole;
    }
    
    public function getMatchAppTimeAttribute()
    {
        return $this->attributes[self::MATCH_APP_TIME];
    }
    public function setMatchAppTimeAttribute($matchAppTime)
    {
        $this->attributes[self::MATCH_APP_TIME] = $matchAppTime;
    }
}
