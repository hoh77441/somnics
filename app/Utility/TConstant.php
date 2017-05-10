<?php
namespace App\Utility;

class TConstant
{
    public static function version()
    {
        return env('SOMNICS_VER', '0.0.0');
    }
    
    public static function isLogRequest()
    {
        return env('SOMNICS_LOG_REQUEST', false);
    }
    
    public static function isLogDetail()
    {
        return env('SOMNICS_LOG_DETAIL', false);
    }
    
    public static function uploadPath()
    {
        $path = env('SOMNICS_UPLOAD_PATH', '/');
        if( !TStringUtility::endWith($path, '/') )
        {
            $path .= '/';
        }
        return $path;
    }
    
    public static function archivePath()
    {
        return env('SOMNICS_ARCHIVE_PATH', '/');
    }
    
    public static function defaultPrivilege()
    {
        return env('SOMNICS_DEFAULT_PRIVILEGE', 1);
    }
    
    const FILE_CONNECTION = 'filebase';
    public static function fileConnection()
    {
        return self::FILE_CONNECTION;  //'filebase';
    }
    
    public static function fileDbHost()
    {
        return env('SOMNICS_DB_HOST', 'localhost');
    }
    
    public static function fileDbPort()
    {
        return env('SOMNICS_DB_PORT', 3306);
    }
    
    public static function fileDbScheme()
    {
        return env('SOMNICS_DB_DATABASE', 'filebase');
    }
    
    public static function fileDbUsername()
    {
        return env('SOMNICS_DB_USERNAME', '');
    }
    
    public static function fileDbPassword()
    {
        return env('SOMNICS_DB_PASSWORD', '');
    }
    
    public static function privilege()
    {
        return env('SOMNICS_PATIENT_VALUE', 1);
    }
}
