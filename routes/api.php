<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use \App\Http\Controllers\OperationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', function (Request $request) {
    if (!Auth::attempt($request->only('email', 'password'))) {
        abort(401, 'Invalid credentials');
    }

    $token = Auth::user()->createToken('auth-token')->plainTextToken;
    return response()->json(['token' => $token]);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (){return auth()->user()->id;});
    Route::post('/index/', [IndexController::class, 'index'])->name('apiIndex');
    Route::post('/operations/', [OperationController::class, 'index'])->name('operation');
    Route::post('/operations/create/', [OperationController::class, 'store'])->name('operation');
    Route::post('/home/', [HomeController::class, 'index'])->name('home');
});
