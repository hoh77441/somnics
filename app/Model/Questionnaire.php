<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Questionnaire extends Model
{
    const TABLE = 'questionnaires';
    //columns
    const APP_ID = 'app_id';
    const EVENING1 = 'evening1';
    const EVENING2 = 'evening2';
    const EVENING_TIME = 'evening_time';
    const MORNING1 = 'morning1';
    const MORNING2 = 'morning2';
    const MORNING_TIME = 'morning_time';
    const IS_RE_FILL = 'is_re_fill';
    //for ui display
    const COUNT = 'count';
    const SERIAL_NO = 'serial_no';
    
    //for column of model 
    protected $primaryKey = self::APP_ID;
    protected $keyType = 'int';
    public $incrementing = false;
    
    //relation
    public function complianceApp()
    {
        //return $this->belongsTo(ComplianceApp::class);
        return $this->belongsTo(ComplianceApp::class, self::APP_ID);
    }
    
    //utility function
    public static function getCountOfQuestionnaireLevel(User $user, $level)
    {
        if( $user == null )
        {
            return 0;
        }
        
        $count = 0;
        foreach( $user->complianceApps as $app )
        {
            $sql = sprintf('select count(*) as "count" from %s where (%s=%d or %s=%d or %s=%d or %s=%d) and %s=%d',
            self::TABLE,
            self::EVENING1, $level, self::EVENING2, $level, 
            self::MORNING1, $level, self::MORNING2, $level,
            self::APP_ID, $app->id);
            $count += DB::select($sql)[0]->count;
        }
        return $count;
    }
    
    public function getAppIdAttribute()
    {
        return $this->attributes[self::APP_ID];
    }
    public function setAppIdAttribute($id)
    {
        $this->attributes[self::APP_ID] = $id;
    }
    
    public function getEvening1Attribute()
    {
        return $this->attributes[self::EVENING1];
    }
    public function setEvening1Attribute($answer)
    {
        $this->attributes[self::EVENING1] = $answer;
    }
    
    public function getEvening2Attribute()
    {
        return $this->attributes[self::EVENING2];
    }
    public function setEvening2Attribute($answer)
    {
        $this->attributes[self::EVENING2] = $answer;
    }
    
    public function getEveningTimeAttribute()
    {
        return $this->attributes[self::EVENING_TIME];
    }
    public function setEveningTimeAttribute($time)
    {
        $this->attributes[self::EVENING_TIME] = $time;
    }
    
    public function getMorning1Attribute()
    {
        return $this->attributes[self::MORNING1];
    }
    public function setMorning1Attribute($answer)
    {
        $this->attributes[self::MORNING1] = $answer;
    }
    
    public function getMorning2Attribute()
    {
        return $this->attributes[self::MORNING2];
    }
    public function setMorning2Attribute($answer)
    {
        $this->attributes[self::MORNING2] = $answer;
    }
    
    public function getMorningTimeAttribute()
    {
        return $this->attributes[self::MORNING_TIME];
    }
    public function setMorningTimeAttribute($time)
    {
        $this->attributes[self::MORNING_TIME] = $time;
    }
    
    public function getIsReFillAttribute()
    {
        return $this->attributes[self::IS_RE_FILL];
    }
    public function setIsReFillAttribute($time)
    {
        $this->attributes[self::IS_RE_FILL] = $time;
    }
    
    public function getCounterAttribute()
    {
        return $this->attributes[self::COUNT];
    }
    public function setCounterAttribute($count)
    {
        $this->attributes[self::COUNT] = $count;
    }
    
    public function getSerialNoAttribute()
    {
        return $this->attributes[self::SERIAL_NO];
    }
    public function setSerialNoAttribute($serialNo)
    {
        $this->attributes[self::SERIAL_NO] = $serialNo;
    }
}
