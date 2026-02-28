<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OperationReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\DepositController;


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


Route::post('/index/', [IndexController::class, 'index'])->name('apiIndex')->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('operations', [OperationController::class, 'index']);
    Route::get('operations/{id}', [OperationController::class, 'show']);
    Route::post('operations', [OperationController::class, 'store']);
    Route::put('operations/{id}', [OperationController::class, 'update']);
    Route::delete('operations/{id}', [OperationController::class, 'destroy']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

    Route::get('type', [TypeController::class, 'index']);
    Route::get('type/all', [TypeController::class, 'allList']);

    Route::get('deposit', [DepositController::class, 'index']);
    Route::get('deposit/{id}', [DepositController::class, 'show']);
    Route::post('deposit', [DepositController::class, 'store']);
    Route::put('deposit/{id}', [DepositController::class, 'update']);
    Route::delete('deposit/{id}', [DepositController::class, 'destroy']);

    Route::get('report', [OperationReportController::class, 'index']);
});

