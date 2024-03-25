<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');
Route::redirect('/login', '/')->name('login');

// Docs URL
Route::redirect('/docs', '/docs/index.html');
