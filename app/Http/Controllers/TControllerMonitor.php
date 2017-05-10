<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utility\JSONObject;
use App\Utility\JSONArray;

class TControllerMonitor extends Controller
{
    const URL_GET_MONITORS = '/monitor';
    const ACTION_GET_MONITORS = 'TControllerMonitor@getMonitors';
    const PARAMETER_USER = 'userId';
    const PARAMETER_DATE = 'date';
    
    public function getMonitors($userId, $date)
    {
        //return 'user: ' . $userId . ', date: ' . $date;
        //$json = new JSONObject();
        $c1 = ['label'=>'Time', 'type'=>'string'];
        $c2 = ['label'=>'Treatment', 'type'=>'number'];
        $c3 = ['label'=>'Leakage', 'type'=>'number'];
        $cols = [$c1, $c2, $c3];
        //$json->set('cols', $cols);
        
        $t1 = ['v'=>'12:00', 'f'=>null];
        $s1 = ['v'=>-40, 'f'=>'1000'];
        $l1 = ['v'=>-0, 'f'=>'2000'];
        $r1 = ['c'=>[$t1, $s1, $l1]];
        $t2 = ['v'=>'12:10', 'f'=>null];
        $s2 = ['v'=>-42, 'f'=>'3000'];
        $l2 = ['v'=>-10, 'f'=>'4000'];
        $r2 = ['c'=>[$t2, $s2, $l2]];
        $rows = [$r1, $r2];
        
        //$json->set('rows', $rows);
        $json['cols'] = $cols;
        $json['rows'] = $rows;
        return response()->json($json);  //['userId'=>$userId, 'date'=>$date]);
        //return (String)$json;
        //return response()->json(null);  //ok
    }
}
