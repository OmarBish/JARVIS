<?php

namespace App\Http\Controllers\Client\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('client.auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        return $this->sendResponse('Login succeded', $req);
        if (Auth::guard('web')->attempt($credentials)) {
            // Authentication passed...
            return $this->sendResponse('Login succeded', 'Client register successfully.');
        }
        return $this->sendError('Validation Error.', ['email'=>trans('auth.failed')]);
        
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
