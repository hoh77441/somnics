<?php
namespace App\Helper;

use App\Utility\TErrorCode;
use App\Utility\JSONObject;
use App\Utility\JSONArray;
use App\Helper\THelper;
use App\Helper\TAppHelper;

class TComplianceChecker extends THelper
{
    public function __construct(JSONObject $json, TAppHelper $helper)
    {
        parent::__construct();
        
        $this->json = $json;
        $this->helper = $helper;
        
        $this->jsonMaster = $this->helper->getComplianceMasterJson($json);
    }
    
    public function check()
    {
        $this->initHelper();
        
        if( ($checker=$this->checkUser()) != TErrorCode::SUCCESS )
        {
            return $checker;
        }
        if( ($checker=$this->checkConsole()) != TErrorCode::SUCCESS )
        {
            return $checker;
        }
        if( ($checker=$this->checkMaster()) != TErrorCode::SUCCESS )
        {
            return $checker;
        }
        if( ($checker=$this->checkQuestionnaire()) != TErrorCode::SUCCESS )
        {
            return $checker;
        }
        if( ($checker=$this->checkConsoleStart()) != TErrorCode::SUCCESS )
        {
            return $checker;
        }
        if( ($checker=$this->checkRecords()) != TErrorCode::SUCCESS )
        {
            return $checker;
        }
        return TErrorCode::SUCCESS;
    }
    
    public function getJsonUser()
    {
        return $this->user;
    }
    
    public function getJsonConsole()
    {
        return $this->console;
    }
    
    public function getJsonMaster()
    {
        return $this->master;
    }
    
    public function getJsonQuestionnaire()
    {
        return $this->questionnaire;
    }
    
    public function getJsonRecords()
    {
        return $this->records;
    }

    protected function checkUser()
    {
        $this->user = $this->helper->getUserJson($this->jsonMaster);
        $this->lastError = $this->helper->getLastError();
        return $this->helper->getLastError();
    }

    protected function checkConsole()
    {
        $this->console = $this->helper->getConsoleJson($this->jsonMaster);
        $this->lastError = $this->helper->getLastError();
        return $this->helper->getLastError();
    }

    protected function checkMaster()
    {
        $this->master = $this->helper->getComplianceMasterJson($this->jsonMaster);
        $this->lastError = $this->helper->getLastError();
        return $this->helper->getLastError();
    }

    protected function checkQuestionnaire()
    {
        $this->questionnaire = $this->helper->getQuestionnaireJson($this->json);
        $this->lastError = $this->helper->getLastError();
        return $this->helper->getLastError();
    }

    protected function checkConsoleStart()
    {
        $jTime = $this->helper->getConsoleJson($this->json);
        if( !$this->helper->hasError() )
        {
            $this->master->put('console_start', $this->helper->getStartTime($jTime));
        }
        //$this->lastError = $this->helper->getLastError();
        //return $this->helper->getLastError();
        
        //for legacy no the parameter of console start time
        $this->lastError = TErrorCode::SUCCESS;
        return $this->lastError;
    }

    protected function checkRecords()
    {
        $this->records = $this->helper->getRecordsJson($this->json);
        $this->lastError = $this->helper->getLastError();
        if( $this->lastError == TErrorCode::SUCCESS )
        {
            if( $this->records->count() == 0 )  //refill questionnaire will generate empty record if app was crash
            {
                $data = new JSONObject([
                    'STime'=> $this->helper->getStartTime($this->master),
                    'ETime'=> $this->helper->getEndTime($this->master), 
                    'Dr_TR'=>0, 'Dr_LK'=>0, 'Time_Zone'=>0]);
                $this->records = new JSONArray([$data]);
                return TErrorCode::SUCCESS;
            }
            
            $this->records->sort('STime');
        }
        return $this->helper->getLastError();
    }
    
    protected $json;
    protected $helper;
    protected $jsonMaster;

    //json object
    protected $user;
    protected $console;
    protected $master;
    protected $questionnaire;
    protected $records;
}
