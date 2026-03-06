<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
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

    public function login(Request $request) : JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            abort(401, 'Invalid credentials');
        }

        $token = Auth::user()->createToken('auth-token')->plainTextToken;
        return response()->json(['token' => $token]);
    }


    public function logout(Request $request) : JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['Logout']);
    }

    public function index(): UserResource
    {
        return new UserResource(Auth::user());
    }
}
