<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConsoleAssignToOrganization extends Model
{
    const TABLE = 'console_assign_to_organizations';
    //columns
    const ORG_ID = 'org_id';
    const SERIAL_NO = 'console_serial_no';
    const HAS_ASSIGNED = 'has_assigned';
    
    public static function findOrganizationBySerialNo($serialNo)
    {
        $assign = ConsoleAssignToOrganization::where(
            self::SERIAL_NO, '=', $serialNo
        )->get();
        
        if( $assign->count() == 0 )
        {
            return null;
        }
        
        return Organization::find($assign->first()->orgId);
    }
    
    public function getOrgIdAttribute()
    {
        return $this->attributes[self::ORG_ID];
    }
    public function setOrgIdAttribute($orgId)
    {
        $this->attributes[self::ORG_ID] = $orgId;
    }
    
    public function getSerialNoAttribute()
    {
        return $this->attributes[self::SERIAL_NO];
    }
    public function setSerialNoAttribute($serialNo)
    {
        $this->attributes[self::SERIAL_NO] = $serialNo;
    }
    
    public function getHasAssignedAttribute()
    {
        return $this->attributes[self::HAS_ASSIGNED];
    }
    public function setHasAssignedAttribute($hasAssigned)
    {
        $this->attributes[self::HAS_ASSIGNED] = $hasAssigned;
    }
}
