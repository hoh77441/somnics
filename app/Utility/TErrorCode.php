<?php
namespace App\Utility;

class TErrorCode
{
    const SUCCESS = 0;
    const NOT_FOUND = -1;
    
    //for error code
    const ERROR_NOT_FOUND = -1;
    const ERROR_NULL_POINTER = -100;
    
    const ERROR_TASK_NOT_FOUND = -200;
    const ERROR_SUB_TASK_NOT_FOUND = -201;
    const ERROR_NOT_TASK = -202;
    const ERROR_DATE_FORMAT = -203;
    const ERROR_EMPTY_DATA = -204;
    const ERROR_EMAIL_OR_PIN = -205;
    const ERROR_TOO_MANY_OPTION = -206;
    const ERROR_NO_CANDIDATE = -207;
    
    const ERROR_FILE_NOT_EXIST = -300;
    const ERROR_FILE_UPLOAD = -301;
    const ERROR_FILE_MOVE = -302;
    
    const ERROR_DB_SAVE = -400;
    
    const ERROR_EXCEPTION = -1000;
    
    //for warning code
    const WARNING_DUPLICATE_DATA = 400;
    
    public static function toString($errorCode)
    {
        switch ($errorCode)
        {
            case self::SUCCESS:
            return 'success';
                
            case self::NOT_FOUND:
            return 'not found';
                
            case self::ERROR_NOT_FOUND:
            return 'not found';
                
            case self::ERROR_NULL_POINTER:
            return 'null pointer';
                
            case self::ERROR_TASK_NOT_FOUND:
            return 'task not found';
            case self::ERROR_SUB_TASK_NOT_FOUND:
            return 'sub task not found';
            case self::ERROR_NOT_TASK:
            return 'no such task';
            case self::ERROR_DATE_FORMAT:
            return 'date format is wrong';
            case self::ERROR_EMPTY_DATA:
            return 'empty data';
            case self::ERROR_EMAIL_OR_PIN:
            return 'ID or Password is wrong';
            case self::ERROR_TOO_MANY_OPTION:
            return 'too many option';
            case self::ERROR_NO_CANDIDATE:
            return 'no candidate';
                
            case self::ERROR_FILE_NOT_EXIST:
            return 'file not exist';
            case self::ERROR_FILE_UPLOAD:
            return 'file upload via http(s) fail';
            case self::ERROR_FILE_MOVE:
            return 'file move fail';
                
            case self::ERROR_DB_SAVE:
            return 'db save fail';
                
            case self::ERROR_EXCEPTION:
            return 'exception';
                
            case self::WARNING_DUPLICATE_DATA:
            return 'duplicate data';
        }
        return '';
    }
    
    public static function toResult($errorCode)
    {
        if( $errorCode == self::SUCCESS )
        {
            return 'ok';
        }
        if( $errorCode > 0 )
        {
            return 'wrong';
        }
        return 'error';
    }
    
    public static function isSuccess($errorCode)
    {
        return $errorCode == self::SUCCESS;
    }
    
    public static function isWarning($errorCode)
    {
        return $errorCode > self::SUCCESS;
    }
    
    public static function isError($errorCode)
    {
        return $errorCode < self::SUCCESS;
    }
}