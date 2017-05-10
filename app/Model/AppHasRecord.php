<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AppHasRecord extends Model
{
    const TABLE = 'app_has_records';
    //columns
    const APP_ID = 'app_id';
    const RECORD_ID = 'record_id';  //->compliance_consoles::id
    const ASSIGN_AT = 'assign_at';
    
    public function getAppIdAttribute()
    {
        return $this->attributes[self::APP_ID];
    }
    public function setAppIdAttribute($id)
    {
        $this->attributes[self::APP_ID] = $id;
    }
    
    public function getRecordIdAttribute()
    {
        return $this->attributes[self::RECORD_ID];
    }
    public function setRecordIdAttribute($id)
    {
        $this->attributes[self::RECORD_ID] = $id;
    }
    
    public function getAssignAtAttribute()
    {
        return $this->attributes[self::ASSIGN_AT];
    }
    public function setAssignAtAttribute($assignAt)
    {
        $this->attributes[self::ASSIGN_AT] = $assignAt;
    }
}
