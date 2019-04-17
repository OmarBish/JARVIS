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

Route::get('/', function () {
    return view('welcome');
});

//i removed the  Auth::routes(); and echanged it with the values it point to 

//tester
Route::prefix('tester')->group(function () {
    // Matches The "/tester/*" URL
    Route::get('login', 'Tester\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Tester\Auth\LoginController@login');
    Route::post('logout', 'Tester\Auth\LoginController@logout')->name('logout');
    if ($options['register'] ?? true) {
        Route::get('register', 'Tester\Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'Tester\Auth\RegisterController@clientRegister');
    }
    // Password Reset Routes...
    if ($options['reset'] ?? true) {
        Route::get('password/reset', 'Tester\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Tester\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Tester\Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Tester\Auth\ResetPasswordController@reset')->name('password.update');
    }
    // Email Verification Routes...
    if ($options['verify'] ?? false) {
        Route::get('email/verify', 'Tester\Auth\VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}', 'Tester\Auth\VerificationController@verify')->name('verification.verify');
        Route::get('email/resend', 'Tester\Auth\VerificationController@resend')->name('verification.resend');
    }
});

//client
Route::prefix('client')->group(function () {
    // Matches The "/tester/*" URL
    Route::get('login', 'Client\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Client\Auth\LoginController@login');
    Route::post('logout', 'Client\Auth\LoginController@logout')->name('logout');
    if ($options['register'] ?? true) {
        Route::get('register', 'Client\Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'Client\Auth\RegisterController@clientRegister');
    }
    // Password Reset Routes...
    if ($options['reset'] ?? true) {
        Route::get('password/reset', 'Client\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Client\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Client\Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Client\Auth\ResetPasswordController@reset')->name('password.update');
    }
    // Email Verification Routes...
    if ($options['verify'] ?? false) {
        Route::get('email/verify', 'Client\Auth\VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}', 'Client\Auth\VerificationController@verify')->name('verification.verify');
        Route::get('email/resend', 'Client\Auth\VerificationController@resend')->name('verification.resend');
    }
});




Route::get('/home', 'HomeController@index')->name('home');
