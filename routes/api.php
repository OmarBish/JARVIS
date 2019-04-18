<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('client/register', 'API\RegisterController@clientRegister');
Route::post('tester/register', 'API\RegisterController@testerRegister');


Route::middleware('auth:api')->group( function () {

    Route::resource('tests', 'API\TestController');
    
    //TODO
    Route::resource('testResults', 'API\TestResultsController');
    Route::resource('testCaseAnswer', 'API\TestCaseAnswer');
    Route::resource('testCase', 'API\TestCaseController');
    Route::resource('testCaseReview', 'API\TestCaseReviewController');
});
