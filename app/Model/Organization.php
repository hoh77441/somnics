<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Utility\JSONArray;

class Organization extends Model
{
    const TABLE = 'organizations';
    //columns
    const ID = 'id';
    const PARENT_ID = 'parent_id';
    const NAME = 'name';
    const DISPLAY = 'display';
    
    //default organization
    const SOMNICS = 'somnics';
    const EMPLOYEE = 'employee';
    const AGENT = 'agent';
    const HOSPITAL = 'hospital';
    const PATIENT = 'patient';
    
    //relation
    public function parent()
    {
        return $this->hasOne(Organization::class, 
            Organization::ID, 
            Organization::PARENT_ID);
    }
    
    public function children()
    {
        return $this->hasMany(Organization::class, 
            Organization::PARENT_ID, 
            Organization::ID);
    }
    
    public function getSiblingsAttribute()
    {
        $siblings = $this->parent->children;
        $result = array();
        foreach( $siblings as $sibling )
        {
            if( $sibling->id != $this->id )
            {
                array_push($result, $sibling);
            }
        }
        if( count($result) == 0 )
        {
            return null;
        }
        return new JSONArray($result);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 
            OrganizationHasUser::TABLE, 
            OrganizationHasUser::ORG_ID, OrganizationHasUser::USER_ID)->withTimestamps();
    }
    
    public function operations()
    {
        return $this->belongsToMany(Operation::class, 
            OrganizationHasOperation::TABLE, 
            OrganizationHasOperation::ORG_ID, OrganizationHasOperation::OP_NAME)->withTimestamps();
    }
    
    public function unassignConsoles()
    {
        return $this->belongsToMany(Console::class, 
            ConsoleAssignToOrganization::TABLE, 
            ConsoleAssignToOrganization::ORG_ID, ConsoleAssignToOrganization::SERIAL_NO)
            ->where(ConsoleAssignToOrganization::HAS_ASSIGNED, '=', 0)
            ->withTimestamps();
    }
    
    public static function findOrganizationByName($name)
    {
        $orgs = Organization::where(
            self::NAME, '=', $name
        )->get();
        
        if( $orgs->count() == 0 )
        {
            return null;
        }
        return $orgs->first();
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
    
    public function getParentIdAttribute()
    {
        return $this->attributes[self::PARENT_ID];
    }
    public function setParentIdAttribute($parentId)
    {
        $this->attributes[self::PARENT_ID] = $parentId;
    }
    
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
    
    /*public function user()
    {
        return $this->belongsTo(User::class);
    }//*/
    
    /*public function role()
    {
        return $this->belongsTo(Role::class);
    }//*/
    
    /*public function child()
    {
        return $this->hasOne(Organization::class, Organization::PARENT_ID, Organization::ID);
    }//*/
}
