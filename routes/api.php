<?php

use App\Http\Controllers\TokensController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [TokensController::class, 'store'])->middleware('guest:sanctum')->name('api.login');

Route::get('/user', [UserController::class, 'show'])->middleware('auth:sanctum')->name('api.user');
