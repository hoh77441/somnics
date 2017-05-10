<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    const TABLE = 'operations';
    //columns
    const NAME = 'name';
    const DISPLAY = 'display';
    
    //for column of model 
    protected $primaryKey = self::NAME;
    protected $keyType = 'string';
    public $incrementing = false;
    
    //relation
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 
            OrganizationHasOperation::TABLE, 
            OrganizationHasOperation::OP_NAME, OrganizationHasOperation::ORG_ID);
    }//*/
    
    //utility
    public static function getOperationByName($name)
    {
        $ops = Operation::where([
            [self::NAME, '=', $name]
        ])->get();
        
        if( $ops->count() == 0 )
        {
            return null;
        }
        return $ops->first();
    }
    
    //column getter and setter
    public function getNameAttribute()
    {
        return $this->attributes[self::NAME];
    }
    public function setNameAttribute($name)
    {
        $this->attributes[self::NAME] = $name;
    }
    
    public function getDisplayAttribute()
    {
        return $this->attributes[self::DISPLAY];
    }
    public function setDisplayAttribute($display)
    {
        $this->attributes[self::DISPLAY] = $display;
    }
    
    /*const ROLE_ID = 'role_id';
    public function getRoleIdAttribute()
    {
        return $this->attributes[self::ROLE_ID];
    }
    public function setRoleIdAttribute($roleId)
    {
        $this->attributes[self::ROLE_ID] = $roleId;
    }//*/
}
