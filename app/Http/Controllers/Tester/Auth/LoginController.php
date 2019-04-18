<?php

namespace App\Http\Controllers\Tester\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('tester.auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        
        if ( Auth::guard('tester')->attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/tester/home');
        }
        return redirect()->back()->withErrors(['email'=>trans('auth.failed')]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
