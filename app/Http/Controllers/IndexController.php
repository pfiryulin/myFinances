<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index() : View
    {
        $user = Auth::user();

        return view('index');
    }

    public function login() : View
    {
        return view('login');
    }

    public function logout(Request $request) : RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }

    public function signIn(Request $request)
    {

        $requestData = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);
        if(Auth::attempt($requestData, true))
        {
            $request->session()->regenerate();

            return redirect()->intended('index');
        }
        return back()->withErrors(
            ['email' => 'The provided credentials do not match our records.']
        )->onlyInput('email');
    }
}
