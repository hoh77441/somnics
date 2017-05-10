<?php
namespace App\SomnicsApi;

use App\Utility\JSONObject;
use App\Utility\TErrorCode;
use App\Helper\TTaskUtility;
use App\SomnicsApi\User\SignIn;
use App\SomnicsApi\User\Login;
use App\SomnicsApi\User\AssignMobile;
use App\SomnicsApi\User\CreateAccount;

class UserInfo implements ITask
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
            case 'signin':
                $task = new SignIn();
            break;
            
            case 'login':
                $task = new Login();
            break;
        
            case 'assignmobile':
                $task = new AssignMobile();
            break;
            
            case 'createaccount':
                $task = new CreateAccount();
            break;
        }
        if( isset($task) )
        {
            return $task->report($json);
        }
        return JSONObject::makeReport(TErrorCode::NOT_FOUND);
    }
}
