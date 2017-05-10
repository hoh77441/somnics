<?php
namespace App\Helper;

use App\Utility\TErrorCode;
use App\Utility\JSONObject;
use App\Helper\TAppHelper;

use App\Model\Console;

class TConsoleHelper extends THelper
{
    public function __construct(TAppHelper $helper) 
    {
        parent::__construct();
        
        $this->helper = $helper;
        if( $helper == null )
        {
            $this->helper = new TAppHelper();
        }
    }
    
    public static function transferConsoleToLegacy(Console $console)
    {
        $deviceInfo = array(
            'serialNo' => $console->serialNo,
            'mac' => $console->address,
            'model' => $console->model,
        );
        return $deviceInfo;
    }


    /**
     * 
     * @param JSONObject $jConsole
     * @param bool $addConsoleIfNotExist
     * @return Console null indicate error occure during the process, $lastError will indicate what happen
     */
    public function getConsoleInfo(JSONObject $jConsole, $addConsoleIfNotExist=false)
    {
        //$this->initHelper();
        
        $this->serialNo = $this->helper->getSerialNo($jConsole);  //$this->getSerialNo($jConsole);
        if( $this->serialNo == null )
        {
            $this->lastError = TErrorCode::ERROR_NULL_POINTER;
            $this->why = 'serial no is null';
            return null;
        }
        
        $console = Console::find($this->serialNo);
        if( $console != null )
        {
            return $console;
        }
        
        if( !$addConsoleIfNotExist )
        {
            $this->lastError = TErrorCode::NOT_FOUND;
            $this->why = sprintf('serial no: \'%s\' not found', $this->serialNo);
            return null;
        }
        
        $console = new Console();
        $console->serialNo = $this->serialNo;
        $console->address = $this->helper->getAddress($jConsole);  //$this->getAddress($jConsole);
        $console->model = $this->helper->getModel($jConsole);  //$this->getModel($jConsole);
        if( !$console->save() )
        {
            $this->lastError = TErrorCode::ERROR_DB_SAVE;
            $this->why = 'console save fail';
            return null;
        }
        return $console;
    }
    
    protected $serialNo;
    protected $helper;
}
