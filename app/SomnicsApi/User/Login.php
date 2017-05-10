<?php
namespace App\SomnicsApi\User;

use App\SomnicsApi\ITask;
use App\Utility\JSONObject;
use App\Utility\TErrorCode;
use App\Helper\TAppHelper;
use App\Helper\TUserHelper;
use App\Helper\TConsoleHelper;
use App\Helper\TConsoleAssignHelper;

class Login implements ITask
{
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
        
        if( ($check=$this->checkConsoleInfo()) != TErrorCode::SUCCESS )
        {
            return JSONObject::makeReport($check, $this->consoleHelper->getWhy());
        }
        
        if( ($check=$this->checkConsoleAssign()) != TErrorCode::SUCCESS )
        {
            return JSONObject::makeReport($check, $this->assignHelper->getWhy());
        }
        
        return $this->makeReport();
    }
    
    protected function checkParameters($json)
    {
        $this->jsonUser = $this->helper->getUserJson($json);
        if( $this->helper->hasError() )
        {
            return $this->helper->getLastError();
        }
        
        $this->jsonConsole = $this->helper->getConsoleJson($json);
        if( $this->helper->hasError() )
        {
            return $this->helper->getLastError();
        }
        
        return TErrorCode::SUCCESS;
    }
    
    protected function checkUserInfo()
    {
        $this->userHelper = new TUserHelper($this->helper);
        $this->user = $this->userHelper->getUserInfoById($this->jsonUser);
        if( $this->user == null )
        {
            $this->user = $this->userHelper->getUserInfoByJson($this->jsonUser, false);  //for exist user
            if( $this->user == null )
            {
                return $this->userHelper->getLastError();
            }
        }
        return TErrorCode::SUCCESS;
    }
    
    protected function checkConsoleInfo()
    {
        $this->consoleHelper = new TConsoleHelper($this->helper);
        $this->console =  $this->consoleHelper->getConsoleInfo($this->jsonConsole, false);
        if( $this->console == null )
        {
            return $this->consoleHelper->getLastError();
        }
        return TErrorCode::SUCCESS;
    }
    
    protected function checkConsoleAssign()
    {
        $this->assignHelper = new TConsoleAssignHelper($this->helper);
        
        return $this->assignHelper->assign($this->user, $this->console, null, false);
    }
    
    protected function makeReport()
    {
        $report = JSONObject::makeReport(TErrorCode::SUCCESS);
        $report->put('userInfo', TUserHelper::transferUserToLegacy($this->user));
        $report->put('deviceInfo', TConsoleHelper::transferConsoleToLegacy($this->console));
        return $report;
    }
    
    private $helper;
    
    private $jsonUser;
    private $jsonConsole;

    private $userHelper;
    private $consoleHelper;
    private $assignHelper;
    
    private $user;
    private $console;
}
