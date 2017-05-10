<?php
namespace App\Utility;

use Symfony\Component\HttpFoundation\ParameterBag;
use App\Utility\TErrorCode;
use App\Utility\TStringUtility;
use App\Utility\JSONArray;

//URL: http://stackoverflow.com/questions/1712161/calling-another-constructor-from-a-constructor-in-php
class JSONObject extends ParameterBag
{
    public function __construct($json=null)
    {
        if( !isset($json) )
        {
            parent::__construct();
        }
        else
        {
            if( $json instanceof ParameterBag )
            {
                parent::__construct($json->all());
            }
            else if( is_array($json) )
            {
                parent::__construct($json);
            }
            else
            {
                parent::__construct();
            }
        }
    }
    
    public function put($key, $value)
    {
        $this->set($key, $value);
    }
    
    public function getJson($key, $default=null)
    {
        $array = $this->get($key, $default);
        if( isset($array) )
        {
            return new JSONObject($array);
        }
        return new $default;
    }
    
    public function getJsonArray($key, $default=array())
    {
        $array = $this->get($key, $default);
        if( isset($array) )
        {
            return new JSONArray($array);
        }
        return new JSONArray($default);
    }

    public function isEmpty()
    {
        if( $this->count() == 0 )
        {
            return true;
        }
        return false;
    }
    
    public function __toString() 
    {
        return json_encode($this->parameters);
    }
    
    public static function makeReport($errorCode, $why=null)
    {
        $json = new JSONObject();
        $json->put('result', TErrorCode::toResult($errorCode));
        $json->put('errorCode', $errorCode);
        $json->put('message', TErrorCode::toString($errorCode));
        $json->put('occurAt', TStringUtility::now());
        if( isset($why) )
        {
            $json->put('why', $why);
        }
        return $json;
    }
}
