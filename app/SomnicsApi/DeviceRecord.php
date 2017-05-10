<?php
namespace App\SomnicsApi;

use App\Utility\JSONObject;
use App\Utility\TErrorCode;
use App\Helper\TTaskUtility;
use App\SomnicsApi\File\UploadFile;
use App\SomnicsApi\User\GetProfile;

class DeviceRecord implements ITask
{
    public function report(JSONObject $json)
    {
        $subTask = TTaskUtility::getSubTask($json);  //$json->get(ITask::SUB_TASK);
        if( !isset($subTask) )
        {
            return JSONObject::makeReport(TErrorCode::ERROR_NULL_POINTER);
        }
        
        $task = null;
        switch ($subTask)
        {
            case 'pasingzip':
                $task = new UploadFile(UploadFile::CATEGORY_ZIP);
            break;
        
            case 'pasingcsv':
                $task = new UploadFile(UploadFile::CATEGORY_CSV);
            break;
        
            case 'reader':
                $task = new GetProfile();
            break;
        }
        if( isset($task) )
        {
            return $task->report($json);
        }
        return JSONObject::makeReport(TErrorCode::NOT_FOUND);
    }
}

