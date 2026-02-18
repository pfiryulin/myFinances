<?php

namespace App\Http\Controllers;

use App\Base\BaseActions\FreeMoneyAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class IndexController extends Controller
{
    public function index(Request $request) : View
    {
        return view('index');
    }

    public function login() : View
    {
//        dd($request);
//        if (!Auth::attempt($request->only('email', 'password'))) {
//            throw ValidationException::withMessages([
//                'email' => __('auth.failed'),
//            ]);
//        }
//
//        $token = Auth::user()->createToken('spa-token')->plainTextToken;
//        return response()->json(['token' => $token]);
        return view('login');
    }

    public function logout(Request $request) : JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'Successfully logged out']);

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
