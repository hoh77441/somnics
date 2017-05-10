<?php
namespace App\Helper;

use App\Utility\TErrorCode;
use App\Utility\TConstant;
use App\Utility\JSONObject;

class THelper
{
    public function __construct() 
    {
        $this->initHelper();
    }
    
    public function __set($name, $value) 
    {
        if( $name == 'why' && $value != null )
        {
            $trace = debug_backtrace();
            //$caller = array_shift($trace);
            //$caller = end($trace);
            //$caller = current($trace);
            $caller = reset($trace);
            $msg = sprintf('(class: %s, line: %d), message(%s)', $caller['class'], $caller['line'], $value);
            
            if( TErrorCode::isWarning($this->lastError) )
            {
                \Log::warning($msg);
            }
            else if( TErrorCode::isError($this->lastError) )
            {
                \Log::error($msg);
            }
            else
            {
                \Log::info($msg);
            }
            
            $this->why = $value;
        }
    }
    
    public function getLastError()
    {
        return $this->lastError;
    }
    
    public function getWhy($force=false)
    {
        if( $force )
        {
            return $this->why;
        }
        if( !TConstant::isLogDetail() )
        {
            return null;
        }
        return $this->why;
    }
    
    public function hasError()
    {
        return !TErrorCode::isSuccess($this->lastError);
    }
    
    public function getJson(JSONObject $json, $keys)
    {
        $this->initHelper();
        foreach( $keys as $key )
        {
            if( $json->has($key) )
            {
                return $json->getJson($key);
            }
        }
        
        $this->lastError = TErrorCode::NOT_FOUND;
        return null;
    }
    
    public function getJsonArray(JSONObject $json, $keys)
    {
        $this->initHelper();
        foreach( $keys as $key )
        {
            if( $json->has($key) )
            {
                return $json->getJsonArray($key);
            }
        }
        
        $this->lastError = TErrorCode::NOT_FOUND;
        return null;
    }
    
    public function getValue(JSONObject $json, $keys, $default=null)
    {
        $this->initHelper();
        foreach( $keys as $key )
        {
            if( $json->has($key) )
            {
                return $json->get($key);
            }
        }
        
        $this->lastError = TErrorCode::NOT_FOUND;
        return $default;
    }

    protected function initHelper()
    {
        $this->lastError = TErrorCode::SUCCESS;
        $this->why = null;
    }
    
    protected $lastError;
    //protected $why;
    private $why;
}
