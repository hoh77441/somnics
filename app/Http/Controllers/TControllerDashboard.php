<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Utility\TStringUtility;
use App\Utility\TDateUtility;
use App\Utility\TUrlUtility;

use App\Model\User;
use App\Model\ComplianceApp;
use App\Model\UI\MenuItem;
use App\Model\UI\IconItem;
use App\Model\UI\QuestionnaireItem;
use App\Model\UI\TreatmentItem;

use App\Http\Controllers\TControllerLogin;
use App\Http\Controllers\TControllerMonitor;

class TControllerDashboard extends Controller
{
    const URL_SHOW_DASHBOARD = '/dashboard';
    const ACTION_SHOW_DASHBOARD = 'TControllerDashboard@showDashboard';
    
    public function showDashboard($userId=0)
    {
        $user = TControllerLogin::getUser($userId);
        if( $user == null )
        {
            return view(TControllerLogin::FORM_LOGIN);
        }
        
        $data = array(
            'user' => $user,
            'selected'=> MenuItem::INDEX_DASHBOARD_USER,  //zero base
            'menuItems' => MenuItem::getMenuItemsByUser(Auth::user()),  //side menu items
            'statistics' => IconItem::getAppStatistics($user),
            'treatments' => TreatmentItem::getComplianceApp($user),  //$treatments
            'monitor' => action(TControllerMonitor::ACTION_GET_MONITORS, [TControllerMonitor::PARAMETER_USER=>null, TControllerMonitor::PARAMETER_DATE=>null]),
        );
        
        return view('dashboard.user')->with($data);
    }
}
