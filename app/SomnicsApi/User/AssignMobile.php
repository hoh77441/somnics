<?php
namespace App\SomnicsApi\User;

use App\SomnicsApi\ITask;
use App\Utility\JSONObject;
use App\Utility\TErrorCode;

class AssignMobile implements ITask
{
    public function report(JSONObject $json)
    {
        return JSONObject::makeReport(TErrorCode::NOT_FOUND, 'to do in the future');
    }
}
