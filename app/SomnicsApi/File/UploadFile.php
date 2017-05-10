<?php
namespace App\SomnicsApi\File;

use App\SomnicsApi\ITask;
use App\Model\FileWaitForParse;

use App\Utility\JSONObject;
use App\Utility\TErrorCode;
use App\Utility\TConstant;

use App\Helper\TAppHelper;

class UploadFile implements ITask
{
    const CATEGORY_CSV = 0;
    const CATEGORY_ZIP = 1;
    const KEY = 'monitor';
    const FILE_NAME = 'name';
    const ERROR = 'error';
    const SOURCE = 'tmp_name';
    
    public function __construct($categpry = self::CATEGORY_CSV) 
    {
        $this->categpry = $categpry;
        $this->helper = new TAppHelper();
    }

    public function report(JSONObject $json)
    {
        $carry = $this->helper->getCarryFile($json);
        if( $carry )
        {
            $errorCode = $this->processHasCarryFile($json);
        }
        else
        {
            $errorCode = $this->processNonCarryFile($json);
        }
        if( !TErrorCode::isSuccess($errorCode) )
        {
            return JSONObject::makeReport($errorCode, $this->filename);
        }
        
        $parse = new FileWaitForParse();
        $parse->filename = $this->filename;
        $parse->serialNo = $this->helper->getSerialNo($json);
        $parse->username = $this->helper->getFileOwner($json);
        $parse->done = false;
        if( $parse->save() )
        {
            return JSONObject::makeReport(TErrorCode::SUCCESS);
        }
        return JSONObject::makeReport(TErrorCode::ERROR_DB_SAVE);
    }
    
    private function processHasCarryFile($json)
    {
        //TODO: add user info to protocol
        if( $_FILES[self::KEY][self::ERROR] != UPLOAD_ERR_OK )
        {
            return TErrorCode::ERROR_FILE_UPLOAD;
        }
        
        $name = basename($_FILES[self::KEY][self::FILE_NAME]);
        //$extension = pathinfo($fileName, PATHINFO_EXTENSION);
        /* do hereunder will store to storage/app/public, but we want to store a common directory, so use move_uploaded_file
        $file = request()->file(self::KEY);
        $file->storeAs('/Users/admin/Documents/php/upload', $fileName);//*/
        $this->filename = TConstant::uploadPath() . $name;
        if( move_uploaded_file($_FILES[self::KEY][self::SOURCE], $this->filename) )
        {
            return TErrorCode::SUCCESS;
        }
        return TErrorCode::ERROR_FILE_MOVE;
    }
    
    private function processNonCarryFile()
    {
        $name = $this->helper->getUploadFileName($json);
        if( !isset($name) )
        {
            return JSONObject::makeReport(TErrorCode::ERROR_NULL_POINTER);
        }
        
        $this->filename = TConstant::uploadPath() . $name;
        if( !file_exists($this->filename) )
        {
            return JSONObject::makeReport(TErrorCode::ERROR_FILE_NOT_EXIST, $this->filename);
        }
        return TErrorCode::SUCCESS;
    }
    
    private $categpry;
    private $helper;
    private $filename;
}
