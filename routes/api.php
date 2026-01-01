<?php

use App\Http\Controllers\IndexController;
use \App\Http\Controllers\OperationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user/', [IndexController::class, 'login'])->middleware('auth:sanctum');
Route::get('/test/', function (){return 'TEST';})->name('apiTest');

Route::post('/index/', [IndexController::class, 'index'])->name('apiIndex');

Route::post('/operations/', [OperationController::class, 'index'])->name('operation');
Route::post('/operations/create/', [OperationController::class, 'store'])->name('operation');
