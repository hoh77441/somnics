<?php
namespace App\SomnicsApi;

use App\Utility\JSONObject;
use App\Utility\TErrorCode;
use App\Helper\TTaskUtility;
use App\SomnicsApi\ITask;
use App\SomnicsApi\Compliance\ComplianceMaster;

class MonitorDevice implements ITask
{
    public function report(JSONObject $json)
    {
        $subTask = TTaskUtility::getSubTask($json);  //$json->get(ITask::SUB_TASK);
        if( !isset($subTask) )
        {
            return JSONObject::makeReport(TErrorCode::NOT_FOUND);
        }
        
        $task = null;
        switch ($subTask)
        {
            case 'master':
                $task = new ComplianceMaster();
            break;
        }
        if( isset($task) )
        {
            return $task->report($json);
        }
        return JSONObject::makeReport(TErrorCode::NOT_FOUND);
    }
}
