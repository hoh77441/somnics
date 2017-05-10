<?php
namespace App\Utility;

use Carbon\Carbon;

class TDateUtility
{
    const FORMAT_APP = 'Y/m/d H:i:s';
    const FORMAT_MYSQL = 'Y-m-d H:i:s';
    
    /**
     * transfer string to Carbon date time
     * @param string $dateTime
     * @return Carbon
     */
    public static function fromApp($dateTime)
    {
        list($year, $month, $day, $hour, $minute, $second) = sscanf($dateTime, '%d/%d/%d %d:%d:%d');
        if( ($year===null) || ($month===null) || ($day===null) || ($hour===null) || ($minute===null) || ($second===null) )
        {
            return null;
        }
        
        return Carbon::create($year, $month, $day, $hour, $minute, $second);
    }
    
    /**
     * transfer string to Carbon date time
     * @param string $dateTime
     * @return Carbon
     */
    public static function fromMySql($dateTime)
    {
        list($year, $month, $day, $hour, $minute, $second) = sscanf($dateTime, '%d-%d-%d %d:%d:%d');
        if( ($year===null) || ($month===null) || ($day===null) || ($hour===null) || ($minute===null) || ($second===null) )
        {
            return null;
        }
        
        return Carbon::create($year, $month, $day, $hour, $minute, $second);
    }
    
    public static function fromJavascript($dateTime)
    {
        list($year, $month, $day, $hour, $minute, $second) = sscanf($dateTime, '%d-%d-%d %d:%d:%d');
        if( ($year===null) || ($month===null) || ($day===null) )
        {
            return null;
        }
        if( ($hour===null) || ($minute===null) || ($second===null) )
        {
            $hour = 0;
            $minute = 0;
            $second = 0;
        }
        
        return Carbon::create($year, $month, $day, $hour, $minute, $second);
    }
    
    public static function from($dateTime)
    {
        $dt = self::fromApp($dateTime);
        if( $dt != null )
        {
            return $dt;
        }
        
        $dt = self::fromMySql($dateTime);
        if( $dt != null )
        {
            return $dt;
        }
        
        return self::fromJavascript($dateTime);
    }

    /**
     * transfer string to Carbon date time
     * @param string $date
     * @return Carbon
     */
    public static function archiveDate($date)
    {
        $dt = self::fromApp($date);
        if( $dt->hour < 12 )  //less than 12PM, archive to yesterday
        {
            $dt->subDay();
        }
        
        $dt->hour = 0x00;
        $dt->minute = 0x00;
        $dt->second = 0x00;
        return $dt;
    }
    
    /**
     * transfer string to Carbon date time
     * @param string $dateTime
     * @return string
     */
    public static function appTimeToArchive($dateTime)
    {
        $dt = self::archiveDate($dateTime);
        return TStringUtility::toDateTime($dt);
    }
    
    public static function now()
    {
        return Carbon::now();
    }
    
    public static function diffInSeconds($start, $end)
    {
        return self::getTimestamp($end) - self::getTimestamp($start);
    }
    
    public static function diffInDays($start, $end)
    {
        $diffInSecond = self::diffInSeconds($start, $end);
        return intval($diffInSecond / (24 * 60 * 60));
    }

    public static function getTimestamp($dateTime)
    {
        if( $dateTime instanceof Carbon )
        {
            return $dateTime->getTimestamp();
        }
        else 
        {
            $app = self::fromApp($dateTime);
            if( $app != null )
            {
                return $app->getTimestamp();
            }
            $db = self::fromMySql($dateTime);
            if( $db != null )
            {
                return $db->getTimestamp();
            }
            return self::from($dateTime)->getTimestamp();
        }
    }
    
    public static function between($dateTime, $start, $end, $equal=true)
    {
        $s = self::getTimestamp($start);
        $e = self::getTimestamp($end);
        if( $s > $e )  //swap
        {
            $temp = $s;
            $s = $e;
            $e = $temp;
        }
        
        $d = self::getTimestamp($dateTime);
        if( $equal )
        {
            return ($d >= $s && $d <= $e);
        }
        return ($d > $s && $d < $e);
    }
    
    public static function overlapping($start1, $end1, $start2, $end2)
    {
        if( self::between($start1, $start2, $end2) )
        {
            return true;
        }
        if( self::between($end1, $start2, $end2) )
        {
            return true;
        }
        if( self::between($start2, $start1, $end1) )
        {
            return true;
        }
        if( self::between($end2, $start1, $end1) )
        {
            return true;
        }
        return false;
    }
}
