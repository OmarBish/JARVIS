<?php

namespace App\Http\Controllers\Client\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        
        return view('client.auth.register');
    }

    public function register(Request $request)
    {
        $res = app('App\Http\Controllers\API\RegisterController')->clientRegister($request);
        
        if($res->getData()->success){
            return view('client.auth.login');
        }else{            
            return Redirect::back()->withErrors($res->getData()->data);
        }
         
    }
}
