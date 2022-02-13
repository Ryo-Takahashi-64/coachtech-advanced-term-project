<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'getLogin'])
                ->middleware('guest')
                ->name('login');

Route::post('/login', [AuthController::class, 'postLogin'])
                ->middleware('guest');

Route::post('/first_auth', [AuthController::class, 'first_auth'])
                ->middleware('guest')
                ->name('first_auth');

Route::post('/second_auth', [AuthController::class, 'second_auth'])
                ->name('second_auth');

Route::get('/register', [AuthController::class, 'getRegister'])
                ->middleware('guest')
                ->name('register');

Route::post('/register', [AuthController::class, 'postRegister'])
                ->middleware('guest');

Route::get('/logout', [AuthController::class, 'getLogout'])
                ->middleware('auth')
                ->name('logout');
