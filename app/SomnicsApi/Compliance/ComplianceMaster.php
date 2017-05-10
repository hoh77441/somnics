<?php
namespace App\SomnicsApi\Compliance;

use App\SomnicsApi\ITask;
use App\Utility\JSONObject;
use App\Utility\TErrorCode;
use App\Helper\TAppHelper;
use App\Helper\TComplianceChecker;
use App\Helper\TComplianceTranslate;

class ComplianceMaster implements ITask
{
    public function __construct() 
    {
        $this->helper = new TAppHelper();
    }
    
    public function report(JSONObject $json)
    {
        if( !TErrorCode::isSuccess($this->checkParameters($json)) )
        {
            return JSONObject::makeReport($this->checker->getLastError(), 'lack parameter');
        }
        if( !TErrorCode::isSuccess($this->translateParameter()) )
        {
            return JSONObject::makeReport($this->translate->getLastError(), 'translate error');
        }
        
        return JSONObject::makeReport(TErrorCode::SUCCESS);
    }
    
    protected function checkParameters(JSONObject $json)
    {
        $this->checker = new TComplianceChecker($json, $this->helper);
        return $this->checker->check();
    }
    
    protected function translateParameter()
    {
        $this->translate = new TComplianceTranslate($this->checker, $this->helper);
        return $this->translate->translate();
    }
    
    private $helper;
    private $checker;
    private $translate;
}
