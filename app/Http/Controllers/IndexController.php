<?php

namespace App\Http\Controllers;

use App\Base\BaseActions\FreeMoneyAction;
use App\Models\Deposit;
use http\Client\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Laravel\Sanctum\NewAccessToken;

class IndexController extends Controller
{
    public function index(Request $request) : array
    {
        try
        {
            $freemoneys = FreeMoneyAction::getFreeMoney($request['userId']);
            $deposites = Deposit::where('user_id', $request['userId'])->sum('amount');
            return [
                'freemoneys' => $freemoneys,
                'deposites' => $deposites,
            ];
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }

    }

    public function login(Request $request)
    {
//        dd($request);
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $token = Auth::user()->createToken('spa-token')->plainTextToken;
dd($token);
        return response()->json(['token' => $token]);
    }

    public function logout(Request $request) : RedirectResponse
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
