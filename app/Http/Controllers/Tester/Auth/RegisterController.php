<?php

namespace App\Http\Controllers\Tester\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        //TODO
        return view('auth.register');
    }

    public function register(Request $request)
    {
        return app('App\Http\Controllers\API\RegisterController')->testerRegister($request);
    }
}
