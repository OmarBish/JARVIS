<?php

namespace App\Http\Controllers\Tester\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        //TODO
        return view('tester.auth.register');
    }

    public function register(Request $request)
    {
        $res = app('App\Http\Controllers\API\RegisterController')->testerRegister($request);
        
        if($res->getData()->success){
            return view('tester.auth.login');
        }else{
            return Redirect::back()->withErrors($res->getData()->data);
        }
    }
}
