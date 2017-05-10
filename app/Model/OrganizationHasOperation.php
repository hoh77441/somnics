<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrganizationHasOperation extends Model
{
    const TABLE = 'organization_has_operations';
    //columns
    const ORG_ID = 'org_id';
    const OP_NAME = 'op_name';
    
    public function getOrgIdAttribute()
    {
        return $this->attributes[self::ORG_ID];
    }
    public function setOrgIdAttribute($orgId)
    {
        $this->attributes[self::ORG_ID] = $orgId;
    }
    
    public function getOpNameAttribute()
    {
        return $this->attributes[self::OP_NAME];
    }
    public function setOpNameAttribute($opName)
    {
        $this->attributes[self::OP_NAME] = $opName;
    }
}
