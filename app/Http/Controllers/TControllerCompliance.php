<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ComplianceConsole;
use App\Utility\TStringUtility;

class TControllerCompliance extends Controller
{
    const URL_GET_RECORDS_BY_ID = '/crinfo';
    const ACTION_GET_RECORDS_BY_ID = 'TControllerCompliance@getRecordsById';
    const PARAMETER_APP = 'appId';
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getRecordsById($appId)
    {
        $records = ComplianceConsole::getRecordsByAppId($appId);
        if( $records == null )
        {
            return response()->json(null);
        }
        
        $c1 = ['label'=>'Start', 'type'=>'string'];
        $c2 = ['label'=>'End', 'type'=>'string'];
        $c3 = ['label'=>'Treatment', 'type'=>'string'];
        $c4 = ['label'=>'Sealing', 'type'=>'string'];
        $c5 = ['label'=>'TimeZone', 'type'=>'string'];
        $cols = [$c1, $c2, $c3, $c4, $c5];
        $rows = array();
        foreach( $records as $record )
        {
            $start = ['v' => $record->start, 'f'=>null];
            $end = ['v' => $record->end, 'f'=>null];
            if( $start == $end )
            {
                continue;
            }
            if( !$record->matchAppTime )
            {
                continue;
            }//*/
            
            $treat = $record->treatment;
            $leak = $record->leakage;
            $treatment = ['v' => TStringUtility::toTime($treat), 'f'=>null];
            $sealing = ['v' => TStringUtility::toTime($treat - $leak), 'f'=>null];
            $timezone = ['v' => sprintf('%02dh', $record->timeZone), 'f'=>null];
            $row = ['c'=>[$start, $end, $treatment, $sealing, $timezone]];
            array_push($rows, $row);
        }
        
        $json['cols'] = $cols;
        $json['rows'] = $rows;
        return response()->json($json);
    }
}
