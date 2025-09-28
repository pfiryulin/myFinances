<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
//        dd($request);
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|string|unique:users',
                'password' => 'required|min:5|string|confirmed',
            ]
        );

        $validatedData['password'] = Hash::make($validatedData['password']);

        $newUser = User::create($validatedData);
        Auth::login($newUser);

        return redirect()->route('index');
    }

    public function index(): View
    {
        $users = User::all();
        return view('users', ['users' => $users]);
    }
}
