<?php
namespace App\SomnicsApi\User;

use App\SomnicsApi\ITask;
use App\Utility\JSONObject;
use App\Utility\TErrorCode;
use App\Utility\TStringUtility;
use App\Utility\TDateUtility;
use App\Helper\TAppHelper;
use App\Helper\TUserHelper;
use App\Helper\TConsoleHelper;
use App\Helper\TConsoleAssignHelper;

class SignIn implements ITask
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
        
        $dateTime = $this->helper->getAssignTime($json);
        if( TStringUtility::isEmpty($dateTime) )
        {
            return TErrorCode::ERROR_EMPTY_DATA;
        }
        $this->assignTime = TDateUtility::from($dateTime);
        if( !isset($this->assignTime) )
        {
            return TErrorCode::ERROR_DATE_FORMAT;
        }
        
        return TErrorCode::SUCCESS;
    }
    
    protected function checkUserInfo()
    {
        $this->userHelper = new TUserHelper($this->helper);
        $serialNo = $this->helper->getSerialNo($this->jsonConsole);
        $this->user = $this->userHelper->getUserInfoByJson($this->jsonUser, true, $serialNo);
        if( $this->user == null )
        {
            return $this->userHelper->getLastError();
        }
        return TErrorCode::SUCCESS;
    }
    
    protected function checkConsoleInfo()
    {
        $this->consoleHelper = new TConsoleHelper($this->helper);
        $this->console =  $this->consoleHelper->getConsoleInfo($this->jsonConsole, true);
        if( $this->console == null )
        {
            return $this->consoleHelper->getLastError();
        }
        return TErrorCode::SUCCESS;
    }

    protected function checkConsoleAssign()
    {
        $this->assignHelper = new TConsoleAssignHelper($this->helper);
        
        return $this->assignHelper->assign($this->user, $this->console, $this->assignTime, true);
    }

    protected function makeReport()
    {
        //return $this->userHelper->responseToApp($this->user);
        $report = JSONObject::makeReport(TErrorCode::SUCCESS);
        $user = TUserHelper::transferUserToLegacy($this->user);
        $console = TConsoleHelper::transferConsoleToLegacy($this->console);
        $report->put('userInfo', $user);
        $report->put('deviceInfo', $console);
        
        return $report;
    }

    private $helper;
    
    private $jsonUser;
    private $jsonConsole;
    private $assignTime;
    
    private $userHelper;
    private $consoleHelper;
    private $assignHelper;
    
    private $user;
    private $console;
}
