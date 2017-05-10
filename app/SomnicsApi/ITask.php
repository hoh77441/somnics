<?php
namespace App\SomnicsApi;

use App\Utility\JSONObject;

interface ITask 
{
    const TASK = 'task';
    const SUB_TASK = 'subTask';
    
    public function report(JSONObject $json);
}
