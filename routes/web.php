<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use \Illuminate\Http\Request;

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
