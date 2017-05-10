<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Utility\TUrlUtility;

class HomeController extends Controller
{
    const ACTION_INDEX = 'HomeController@index';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::guest() )
        {
            return view(TControllerLogin::FORM_LOGIN);
        }
        
        $questionnaire = new TControllerQuestionnaire();
        return $questionnaire->showQuestionnaireInCalendar(0);
    }
}
