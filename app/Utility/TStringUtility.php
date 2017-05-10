<?php
namespace App\Utility;

use Carbon\Carbon;
use App\Utility\TDateUtility;

class TStringUtility
{
    const FORMAT_APP_DATE_TIME = 'Y/m/d H:i:s';  //YYYY/MM/DD hh:mm:ss
    const FORMAT_MYSQL_DATE_TIME = 'Y-m-d H:i:s';  //YYYY-MM-DD hh:mm:ss
    const FORMAT_TIME = '%02d:%02d:%02d';
    
    public static function now($format = self::FORMAT_APP_DATE_TIME)
    {
        return TDateUtility::now()->format($format);
    }
    
    public static function toDateTime($dateTime)
    {
        return $dateTime->format(self::FORMAT_APP_DATE_TIME);
    }
    
    public static function toMySql($dateTime)
    {
        return $dateTime->format(self::FORMAT_MYSQL_DATE_TIME);
    }
    
    public static function toTime($seconds)
    {
        $second = $seconds % 60;
        $minute = ($seconds / 60) % 60;
        $hour = $seconds / 3600;
        return sprintf(self::FORMAT_TIME, $hour, $minute, $second);
    }

    public static function isEmpty($str)
    {
        if( !isset($str) )
        {
            return true;
        }
        if( $str == '' )
        {
            return true;
        }
        
        return false;
    }
    
    public static function trimTimeFidld($dateTime)
    {
        list($year, $month, $day, $hour, $minute, $second) = sscanf($dateTime, '%d-%d-%d %d:%d:%d');
        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }
    
    public static function startWith($string, $needle)
    {
        return substr_compare($string, $needle, 0, strlen($needle)) === 0;
    }
    
    public static function endWith($string, $needle)
    {
        return substr_compare($string, $needle, -strlen($needle)) === 0;
    }
    
    public static function toBoolean($str)
    {
        if( self::isEmpty($str) )
        {
            return false;
        }
        
        $isFalses = ['0', 'false', 'no'];
        foreach( $isFalses as $false )
        {
            $len = max(strlen($false), strlen($str));
            if( strncasecmp($str, $false, $len) == 0x00 )
            {
                return false;
            }
        }
        return true;
    }
}
