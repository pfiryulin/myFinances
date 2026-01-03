<?php

use App\Http\Controllers\IndexController;
use \App\Http\Controllers\OperationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', function (\Illuminate\Http\Request $request) {
//    dd($request);
    if (!Auth::attempt($request->only('email', 'password'))) {
        abort(401, 'Invalid credentials');
    }

    $token = Auth::user()->createToken('auth-token')->plainTextToken;
    return response()->json(['token' => $token]);
});

Route::get('/user', function ()
{
    return auth()->user()->id;
})->middleware('auth:sanctum');

//Route::get('/test/', function () { return 'TEST'; })->name('apiTest');

Route::post('/index/', [IndexController::class, 'index'])->name('apiIndex')->middleware('auth:sanctum');

Route::post('/operations/', [OperationController::class, 'index'])->name('operation')->middleware('auth:sanctum');
Route::post('/operations/create/', [OperationController::class, 'store'])->name('operation');
