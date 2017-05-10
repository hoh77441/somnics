<?php
namespace App\Utility;

class TArrayUtility
{
    public static function getValue($array, $key, $defaultValue)
    {
        if( array_key_exists($key, $array) )
        {
            return $array[$key];
        }
        return $defaultValue;
    }
}
