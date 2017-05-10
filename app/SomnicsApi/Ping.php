<?php
namespace App\SomnicsApi;

use App\Utility\JSONObject;
use App\Utility\TErrorCode;

//use Symfony\Component\HttpFoundation\Session\Session;

class Ping implements ITask
{
    public function report(JSONObject $json)
    {
        return JSONObject::makeReport(TErrorCode::SUCCESS);
    }
}
