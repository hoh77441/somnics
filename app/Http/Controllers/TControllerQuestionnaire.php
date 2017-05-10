<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Utility\TStringUtility;
use App\Utility\TDateUtility;
use App\Model\UI\QuestionnaireItem;
use App\Model\UI\MenuItem;

use App\Http\Controllers\TControllerLogin;

class TControllerQuestionnaire extends Controller
{
    const URL_SHOW_IN_CALENDAR = '/qcalendar';
    const ACTION_SHOW_IN_CALENDAR = 'TControllerQuestionnaire@showQuestionnaireInCalendar';
    const URL_SHOW_IN_DETAIL = '/qdetail';
    const ACTION_SHOW_IN_DETAIL = 'TControllerQuestionnaire@showQuestionnaireInDetail';
    const URL_GET_QUESTIONNAIRES_BY_DATE = '/qdate';
    const ACTION_GET_QUESTIONNAIRES_BY_DATE = 'TControllerQuestionnaire@getQuestionnairesByDate';
    const PARAMETER_USER = 'userId';
    const PARAMETER_DATE = 'date';
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function showQuestionnaireInCalendar($userId=0)
    {
        $user = TControllerLogin::getUser($userId);
        if( $user == null )
        {
            return view(TControllerLogin::FORM_LOGIN);
        }
        
        $events = array();
        $lang = $user->language;
        $questions = QuestionnaireItem::getQuestionnaires($user, true);
        foreach( $questions as $key => $questionnaire )
        {
            $date = TStringUtility::trimTimeFidld($key);
            $events[$key] = QuestionnaireItem::makeCalendarEvent($date, $lang, $questionnaire);
        }
        $data = array(
            'user' => $user,
            'selected'=> MenuItem::INDEX_QUESTIONNAIRE_CALENDAR,  //zero base
            'menuItems' => MenuItem::getMenuItemsByUser(Auth::user()),  //side menu items
            'events' => $events,
            'eventUrl' => action(TControllerQuestionnaire::ACTION_GET_QUESTIONNAIRES_BY_DATE, [TControllerQuestionnaire::PARAMETER_USER=>null, TControllerQuestionnaire::PARAMETER_DATE=>null]),
            'isMe' => TControllerLogin::isMe($user),
        );
        
        return view('questionnaire.calendar')->with($data);
    }
    
    public function showQuestionnaireInDetail($userId=0)
    {
        $user = TControllerLogin::getUser($userId);
        if( $user == null )
        {
            return view(TControllerLogin::FORM_LOGIN);
        }
        
        $lang = $user->language;
        $detail = array();
        $index = 0;
        $firstDate = '';
        $serialNo = '';
        $questions = QuestionnaireItem::getQuestionnaires($user, false);
        foreach( $questions as $questionnaire )
        {
            if( $index++ == 0 )  //first day
            {
                //$firstDate = $questionnaire->complianceApp->start;
                $firstDate = $questionnaire->complianceApp->archiveDate;
                $serialNo = $questionnaire->complianceApp->serialNo;
            }
            
            //check if user change console
            if( $serialNo == $questionnaire->complianceApp->serialNo )
            {
                $change = false;
            }
            else
            {
                $change = true;
                $serialNo = $questionnaire->complianceApp->serialNo;
            }
            
            //$nighNo = TDateUtility::diffInDays($firstDate, $questionnaire->complianceApp->start);
            $nighNo = TDateUtility::diffInDays($firstDate, $questionnaire->complianceApp->archiveDate);
            $appId = $questionnaire->complianceApp->id;
            $detail[$appId] = QuestionnaireItem::makeReportDetail($nighNo, $lang, $questionnaire, $change);
        }
        
        $data = array(
            'user' => $user,
            'selected'=> MenuItem::INDEX_QUESTIONNAIRE_DETAIL,  //zero base
            'menuItems' => MenuItem::getMenuItemsByUser(Auth::user()),  //side menu items
            'detail' => $detail,
            'url_compliance' => action(TControllerCompliance::ACTION_GET_RECORDS_BY_ID, [TControllerCompliance::PARAMETER_APP=>null]),
            'isMe' => TControllerLogin::isMe($user),
        );
        
        return view('questionnaire.usage')->with($data);
    }
    
    public function getQuestionnairesByDate($userId, $date)
    {
        $user = TControllerLogin::getUser($userId);
        if( $user == null )
        {
            return view(TControllerLogin::FORM_LOGIN);
        }
        
        $lang = $user->language;
        $index = 0;
        $serialNo = '';
        $detail = array();
        $questions = QuestionnaireItem::getQuestionnairesByDate($user, $date);
        if( $questions == null )
        {
            return response()->json(null);  //isEmpty will detect true
        }
        foreach( $questions as $questionnaire )
        {
            if( $index++ == 0 )  //first day
            {
                $serialNo = $questionnaire->complianceApp->serialNo;
            }
            
            //check if user change console
            if( $serialNo == $questionnaire->complianceApp->serialNo )
            {
                $change = false;
            }
            else
            {
                $change = true;
                $serialNo = $questionnaire->complianceApp->serialNo;
            }
            
            array_push($detail, QuestionnaireItem::makeReportDetail(0, $lang, $questionnaire, $change));
        }
        
        return response()->json($detail);
    }
}
