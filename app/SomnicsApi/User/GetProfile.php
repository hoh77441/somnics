<?php
namespace App\SomnicsApi\User;

use App\SomnicsApi\ITask;
use App\Utility\JSONObject;
use App\Utility\TErrorCode;
use App\Helper\TAppHelper;
use App\Helper\TUserHelper;

class GetProfile implements ITask
{
    const APP_PARAMETER_USER = 'userInfo';
    const APP_RESPONSE = 'record';
    
    public function __construct() 
    {
        $this->helper = new TAppHelper();
    }
    
    public function report(JSONObject $json)
    {
        if( ($check=$this->checkParameters($json)) != TErrorCode::SUCCESS )
        {
            return JSONObject::makeReport($check, 'lack parameter');
        }
        
        if( ($check=$this->checkUserInfo()) != TErrorCode::SUCCESS )
        {
            return JSONObject::makeReport($check, $this->userHelper->getWhy());
        }
        
        return $this->makeReport();
    }
    
    protected function checkParameters($json)
    {
        $this->jsonUser = $this->helper->getUserJson($json);  //$json->getJson(self::APP_PARAMETER_USER);
        if( !isset($this->jsonUser) )
        {
            return TErrorCode::ERROR_NULL_POINTER;
        }
        
        return TErrorCode::SUCCESS;
    }
    
    protected function checkUserInfo()
    {
        $this->userHelper = new TUserHelper($this->helper);
        $this->user = $this->userHelper->getUserInfoByJson($this->jsonUser, false);
        if( $this->user == null )
        {
            return $this->userHelper->getLastError();
        }
        return TErrorCode::SUCCESS;
    }
    
    protected function makeReport()
    {
        return $this->userHelper->responseToApp($this->user, self::APP_RESPONSE);
    }
    
    private $helper;
    private $jsonUser;
    private $userHelper;
    private $user;
}

