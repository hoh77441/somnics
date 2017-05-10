<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserCareUsers extends Model
{
    const TABLE = 'user_care_users';
    //columns
    const USER_ID = 'user_id';
    const BE_CARED_ID = 'be_cared_user_id';
    const APPROVAL = 'approval';
    
    public function getUserIdAttribute()
    {
        return $this->attributes[self::USER_ID];
    }
    public function setUserIdAttribute($userId)
    {
        $this->attributes[self::USER_ID] = $userId;
    }
    
    public function getBeCareIdAttribute()
    {
        return $this->attributes[self::BE_CARED_ID];
    }
    public function setBeCareIdAttribute($userId)
    {
        $this->attributes[self::BE_CARED_ID] = $userId;
    }
    
    public function getApprovalAttribute()
    {
        return $this->attributes[self::APPROVAL];
    }
    public function setApprovalAttribute($approval)
    {
        $this->attributes[self::APPROVAL] = $approval;
    }
}
