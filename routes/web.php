<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// //i removed the  Auth::routes(); and echanged it with the values it point to 

// // Matches The "/tester/*" URL
// Route::resource('/tester', 'Tester\TesterController', ['except' => ['show']]);
// Route::prefix('tester')->group(function () {
//     /**
//      * login/logout
//      */
//     Route::get('login', 'Tester\Auth\LoginController@showLoginForm')->name('testerLogin');
//     Route::post('login', 'Tester\Auth\LoginController@login');
//     Route::post('logout', 'Tester\Auth\LoginController@logout')->name('testerLogout');
//     /**
//      * register
//      */
//     if ($options['register'] ?? true) {
//         Route::get('register', 'Tester\Auth\RegisterController@showRegistrationForm')->name('testerRegister');
//         Route::post('register', 'Tester\Auth\RegisterController@register');
//     }
//     /**
//      * resetPassword
//      */
//     if ($options['reset'] ?? true) {
//         //TODO
//         // Route::get('password/reset', 'Tester\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//         // Route::post('password/email', 'Tester\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//         // Route::get('password/reset/{token}', 'Tester\Auth\ResetPasswordController@showResetForm')->name('password.reset');
//         // Route::post('password/reset', 'Tester\Auth\ResetPasswordController@reset')->name('password.update');
//     }
//     /**
//      * Email verfiy 
//      */
//     if ($options['verify'] ?? false) {
//         //TODO
//         // Route::get('email/verify', 'Tester\Auth\VerificationController@show')->name('verification.notice');
//         // Route::get('email/verify/{id}', 'Tester\Auth\VerificationController@verify')->name('verification.verify');
//         // Route::get('email/resend', 'Tester\Auth\VerificationController@resend')->name('verification.resend');
//     }
//     /**
//      * 
//      */
    

//     Route::group(['middleware' => 'auth:tester'], function () {
//         Route::get('profile', ['as' => 'profile.edit', 'uses' => 'Tester\ProfileController@edit']);
//         Route::put('profile', ['as' => 'profile.update', 'uses' => 'Tester\ProfileController@update']);
//         Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'Tester\ProfileController@password']);
//         Route::get('/home', 'HomeController@index')->name('testerHome');
       
//         Route::resource('/client', 'Client\ClientController', ['except' => ['delete','']]);
//     });
// });

// //client
// Route::resource('/client', 'Client\ClientController', ['except' => ['show']]);
// Route::prefix('client')->group(function () {
//     // Matches The "/client/*" URL

//     /**
//      * login
//      */
//     Route::get('login', 'Client\Auth\LoginController@showLoginForm')->name('clientLogin');
//     Route::post('login', 'Client\Auth\LoginController@login');

//     Route::post('logout', 'Client\Auth\LoginController@logout')->name('clientLogout');

//     /**
//      * register
//      */
//     if ($options['register'] ?? true) {
//         Route::get('register', 'Client\Auth\RegisterController@showRegistrationForm')->name('clientRegister');
        
//     }


//     // Password Reset Routes...
//     if ($options['reset'] ?? true) {
//         //TODO
//         // Route::get('password/reset', 'Client\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//         // Route::post('password/email', 'Client\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//         // Route::get('password/reset/{token}', 'Client\Auth\ResetPasswordController@showResetForm')->name('password.reset');
//         // Route::post('password/reset', 'Client\Auth\ResetPasswordController@reset')->name('password.update');
//     }
//     // Email Verification Routes...
//     if ($options['verify'] ?? false) {
//         //TODO
//         // Route::get('email/verify', 'Client\Auth\VerificationController@show')->name('verification.notice');
//         // Route::get('email/verify/{id}', 'Client\Auth\VerificationController@verify')->name('verification.verify');
//         // Route::get('email/resend', 'Client\Auth\VerificationController@resend')->name('verification.resend');
//     }

//     Route::group(['middleware' => 'auth'], function () {
//         Route::get('profile', ['as' => 'tester.profile.edit', 'uses' => 'Client\ProfileController@edit']);
//         Route::put('profile', ['as' => 'profile.update', 'uses' => 'Client\ProfileController@update']);
//         Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'Client\ProfileController@password']);
//         Route::get('/home', 'HomeController@index')->name('clientHome');
//         Route::resource('/test', 'Client\ClientController');
        
//     });
    
// });

// Route::get('/home', 'HomeController@setPath')->name('home');

// Route::resource('test', 'Tester\TestController');
Route::prefix('client')->group(function () {
    /**
     * auth
     */
    Route::post('login', 'Client\AuthController@login')->name('Client-Login');
    Route::post('logout', 'Client\AuthController@logout')->name('Client-Logout');
    Route::post('register', 'Client\AuthController@register')->name('Client-Logout');

});

Route::prefix('tester')->group(function () {
    /**
     * auth
     */
    Route::post('login', 'Tester\AuthController@login')->name('Tester-Login');
    Route::post('/register', 'Tester\AuthController@register')->name('Tester-Register');
    Route::post('logout', 'Tester\AuthController@logout')->name('Tester-Logout');
});











