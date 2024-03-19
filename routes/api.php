<?php

use App\Http\Controllers\TimeEntriesController;
use App\Http\Controllers\TokensController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [TokensController::class, 'store'])->middleware('guest:sanctum')->name('api.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::delete('/logout', [TokensController::class, 'destroy'])->name('api.logout');
    Route::get('/user', [UserController::class, 'show'])->name('api.user');

    Route::apiResource('time-entries', TimeEntriesController::class)
        ->only(['store', 'update'])
        ->parameters(['time-entries' => 'entry']);
});
