<?php

namespace App\Http\Controllers\Tester;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tester;
use Auth;
use Validator;


class AuthController extends Controller
{
    //TODO
    public function __construct(){
            // $this->middleware('guest')->except();
            // $this->middleware('guest:client')->except('');
            // $this->middleware('guest:tester')->except('');
    }
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

        if ( Auth::guard('tester')->attempt($credentials)) {
            // Authentication passed...
            return $this->sendResponse('Login succeded', 'Tester register successfully.');
        }
        return $this->sendError(trans('auth.failed'), 'invalid data');
    }
    public function register(Request $request)
    {
        return app('App\Http\Controllers\API\TesterController')->store($request);
    }
    public function logout()
    {
        Auth::logout();
        return $this->sendResponse('logout succeded', 'Client logout successfully.');
    }
}
