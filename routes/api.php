<?php

use App\Http\Controllers\CategoryController;
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

Route::get('/user', function ()
{
    return auth()->user()->id;
})->middleware('auth:sanctum');

//Route::get('/test/', function () { return 'TEST'; })->name('apiTest');

Route::post('/index/', [IndexController::class, 'index'])->name('apiIndex')->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('operations', [OperationController::class, 'index']);
    Route::get('operations/{id}', [OperationController::class, 'show']);
    Route::post('operations', [OperationController::class, 'store']);
    Route::put('operations/{id}', [OperationController::class, 'update']);
    Route::delete('operations/{id}', [OperationController::class, 'destroy']);
    Route::get('categories', [CategoryController::class, 'index']);
});

