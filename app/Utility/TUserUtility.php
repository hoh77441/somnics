<?php
namespace App\Utility;

use App\Model\User;

class TUserUtility
{
    /**
     * detect the uset if a patient
     * @param User $user
     * @return boolean true is patient, false is not patient
     */
    public static function isPatient($user)
    {
        if( $user->consoles->count() == 0 )
        {
            return false;
        }
        return true;
    }
}