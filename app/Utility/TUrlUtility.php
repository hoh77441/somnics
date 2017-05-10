<?php
namespace App\Utility;

class TUrlUtility
{
    const DIR = '';
    const ROOT = '/' . self::DIR;
    const HOME = '/home' . self::DIR;
    const LOGIN = '/login' . self::DIR;
    const LOGIN_FORM = 'login_form';
    const LOGOUT = '/logout' . self::DIR;
    
    const QUESTIONNAIRE_EVENT = '/qcalendar' . self::DIR;
    const QUESTIONNAIRE_DETAIL = '/qdetail' . self::DIR;
    const AJAX_QUESTIONNAIRE_BY_DATE = '/qdate' . self::DIR;
    
    const DASHBOARD = '/dashboard' . self::DIR;
    const AJAX_MONITOR = '/monitor' . self::DIR;
}