<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TControllerLogin;
use App\Http\Controllers\TControllerQuestionnaire;
use App\Http\Controllers\TControllerDashboard;
use App\Http\Controllers\TControllerMonitor;
use App\Http\Controllers\TControllerCompliance;

//restful controller route
// php artisan route:list
// methode      uri                     closure
// get|head     account                 TControllerAccount.index
// post         account                 TControllerAccount.store
// get|head     account/create          TControllerAccount.create
// delete       account/{account}       TControllerAccount.destroy
// put|patch    account/{account}       TControllerAccount.update
// get|head     account/{account}       TControllerAccount.show
// get|head     account/{account}/edit  TControllerAccount.edit
//Route::resource('account', 'TControllerAccount');
//Route::get('login', ['as'=>'login', 'uses'=>  'TControllerAccount::class@login']);
//Auth::routes();

//for account access
//Route::get(TControllerLogin::URL_LOGIN, TControllerLogin::ACTION_LOGIN);
Route::post(TControllerLogin::URL_LOGIN, TControllerLogin::ACTION_LOGIN);
Route::get(TControllerLogin::URL_LOGOUT, TControllerLogin::ACTION_LOGOUT);
Route::get(TControllerLogin::URL_HOME, HomeController::ACTION_INDEX);
Route::get(TControllerLogin::URL_ROOT, function() {
    return view(TControllerLogin::FORM_LOGIN);//->with('error', 'expire');
});

//for questionnaire
Route::get(TControllerQuestionnaire::URL_SHOW_IN_CALENDAR.'/{userId?}', ['uses' => TControllerQuestionnaire::ACTION_SHOW_IN_CALENDAR]);
Route::get(TControllerQuestionnaire::URL_SHOW_IN_DETAIL.'/{userId?}', ['uses' => TControllerQuestionnaire::ACTION_SHOW_IN_DETAIL]);
Route::get(TControllerQuestionnaire::URL_GET_QUESTIONNAIRES_BY_DATE.'/{userId?}/{date?}', ['uses' => TControllerQuestionnaire::ACTION_GET_QUESTIONNAIRES_BY_DATE]);
Route::get(TControllerCompliance::URL_GET_RECORDS_BY_ID.'/{appId}', ['uses' => TControllerCompliance::ACTION_GET_RECORDS_BY_ID]);

//for dashboard
Route::get(TControllerDashboard::URL_SHOW_DASHBOARD.'/{userId?}', ['uses' => TControllerDashboard::ACTION_SHOW_DASHBOARD]);
Route::get(TControllerMonitor::URL_GET_MONITORS.'/{userId?}/{date?}', ['uses' => TControllerMonitor::ACTION_GET_MONITORS]);
