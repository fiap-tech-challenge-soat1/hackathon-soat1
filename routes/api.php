<?php

use App\Http\Controllers\TokensController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [TokensController::class, 'store'])->middleware('guest:sanctum')->name('api.login');
Route::delete('/logout', [TokensController::class, 'destroy'])->middleware('auth:sanctum')->name('api.logout');

Route::get('/user', [UserController::class, 'show'])->middleware('auth:sanctum')->name('api.user');
