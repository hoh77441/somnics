<?php
namespace App\SomnicsApi\Exception;

use App\Utility\JSONObject;
use App\Utility\TErrorCode;

class TExceptionHandler
{
    public function __construct($app) 
    {
        $this->app = $app;
        
        //set_error_handler([$this, 'onError']);
        set_exception_handler([$this, 'onException']);
    }
    
    public function onException($exception)
    {
        $str = (string)$exception;
        
        $json = JSONObject::makeReport(TErrorCode::ERROR_EXCEPTION, $str);
        echo (string)$json;
        \Log::error($str);
    }
    
    protected $app;
}
