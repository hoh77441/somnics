<?php
namespace App\Helper;

use App\Utility\JSONObject;
use App\Helper\THelper;
use App\SomnicsApi\ITask;

class TTaskUtility
{
    public static function getSubTask(JSONObject $json)
    {
        $helper = new THelper();
        $task = $helper->getValue($json, [ITask::SUB_TASK]);
        if( !isset($task) )
        {
            return null;
        }
        return strtolower($task);
    }
}