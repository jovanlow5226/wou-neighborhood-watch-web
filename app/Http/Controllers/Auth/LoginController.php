<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return View::make('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login_id' => 'required',
            'password' => 'required',
            'user_type' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            if($request->user_type == 'management'){
                return redirect()->intended('/management-dashboard');
            }else{
                return redirect()->intended('/ownertenant-dashboard');
            }
            
        }

        return redirect()->back()->withErrors(['login_error' => 'Invalid login credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
