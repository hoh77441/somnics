<?php
namespace App\Utility;

use App\Model\User;
use App\Model\Operation;

//URL: https://laravel.io/forum/05-21-2015-try-catch-not-working
class TAuthorization
{
    /**
     * detect the use if authorized
     * @param User $user
     * @param \App\Model\Operation $operation
     * @return bool true: can do that operation, false: can not 
     */
    public static function can(User $user, $operation)
    {
        if( $operation instanceof Operation )
        {
            $op = $operation;
        }
        else
        {
            $op = Operation::getOperationByName($operation);
        }
        
        if( $op == null )
        {
            return false;
        }
        return self::authorized($user->organization, $op->name);
    }
    
    private static function authorized($organization, $operation)
    {
        while( $organization != null )
        {
            $ops = $organization->role->operations;
            if( self::matched($ops, $operation) )
            {
                return true;
            }
            
            try
            {
                $organization = $organization->child;
            } 
            catch (\Exception $ex) 
            {
                return false;
            }
        }
        
        return false;
    }
    
    private static function matched($operations, $name)
    {
        foreach( $operations as $op )
        {
            if( $op->name == $name )
            {
                return true;
            }
        }
        return false;
    }
}