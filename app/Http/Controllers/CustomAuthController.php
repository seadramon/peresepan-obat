<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Log;
use DB;

class CustomAuthController extends Controller
{
    public function index()
    {
    	return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
        	return redirect()->intended('/');
        }
  
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau Password yang anda inputkan tidak sesuai']);
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
