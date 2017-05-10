<?php
namespace App\SomnicsApi;

use App\Utility\JSONObject;
use App\Utility\TErrorCode;
use App\Helper\TTaskUtility;

class ComplianceRecord implements ITask
{
    public function report(JSONObject $json)
    {
        $subTask = TTaskUtility::getSubTask($json);  //$json->get(ITask::SUB_TASK);
        if( !isset($subTask) )
        {
            return JSONObject::makeReport(TErrorCode::NOT_FOUND);
        }
        
        //$subTask = strtolower($subTask);
        $task = null;
        switch ($subTask)
        {
        }
        if( isset($task) )
        {
            return $task->report($json);
        }
        return JSONObject::makeReport(TErrorCode::NOT_FOUND);
    }
}
