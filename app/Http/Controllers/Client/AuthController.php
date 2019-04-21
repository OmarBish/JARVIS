<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Client;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        /**
         * 1- check validation
         * 2- login
         */
        $credentials = $request->only('email', 'password');
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',

            'password' => 'required',

        ]);

        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }
        
        if (Auth::guard('client')->attempt($credentials)) {
            // Authentication passed...
            return $this->sendResponse('Login succeded', 'Client register successfully.');
        }
        return $this->sendError(trans('auth.failed'), 'invalid data');
        
    }
    public function register(Request $request)
    {
        return app('App\Http\Controllers\Client\ClientController')->store($request);         
    }
    public function logout()
    {
        Auth::logout();
        return $this->sendResponse('logout succeded', 'Client logout successfully.');
    }
}
