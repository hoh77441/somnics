<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrganizationHasUser extends Model
{
    const TABLE = 'organization_has_users';
    //columns
    const ORG_ID = 'org_id';
    const USER_ID = 'user_id';
    
    public function getOrgIdAttribute()
    {
        return $this->attributes[self::ORG_ID];
    }
    public function setOrgIdAttribute($orgId)
    {
        $this->attributes[self::ORG_ID] = $orgId;
    }
    
    public function getUserIdAttribute()
    {
        return $this->attributes[self::USER_ID];
    }
    public function setUserIdAttribute($userId)
    {
        $this->attributes[self::USER_ID] = $userId;
    }
}
