<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use \Illuminate\Http\Request;
use \App\Http\Controllers\DepositController;

Route::get('/', [IndexController::class, 'index'])->middleware('auth')->name('index');
Route::get('/registration', function () {
    return view('register');
}
)->name('registration');
Route::post('/registration', [UserController::class, 'store'])->name('registration');
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/login', [IndexController::class, 'login'])->name('login');
Route::post('/signin', [IndexController::class, 'signIn'])->name('signin');
Route::any('/logout', [IndexController::class, 'logout'])->name('logout');
Route::any('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});
Route::get('/operation/', [OperationController::class, 'index'])->name('operation');
Route::post('/operation/', [OperationController::class, 'store'])->name('operation');
Route::get('/deposite/', [DepositController::class, 'index'])->name('deposit');
Route::post('/deposite/update/', [DepositController::class, 'edit'])->name('deposit-update');
Route::post('/deposite/create/', [DepositController::class, 'store'])->name('deposit-create');
Route::get('/test/wer/', function(){ return view('test'); });
