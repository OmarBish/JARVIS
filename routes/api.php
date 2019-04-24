<?php

use Illuminate\Http\Request;
header('Access-Control-Allow-Origin:  *');
   header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
   header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:client')->get('/user', function (Request $request) {
    return $request->user()->token();
});


Route::resource('test', 'API\TestController',['except' => ['create']]);
Route::resource('testResult', 'API\TestResultsController',['except' => ['create']]);

Route::middleware('auth:api')->group( function () {

    //TODO
    Route::resource('testCaseAnswer', 'API\TestCaseAnswer');
    Route::resource('testCase', 'API\TestCaseController');
    Route::resource('testCaseReview', 'API\TestCaseReviewController');
});
Route::resource('client', 'API\ClientController',['except' => ['create']]);
Route::resource('tester', 'API\TesterController',['except' => ['create']]);




