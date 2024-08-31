<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::
        namespace('Auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login'])->name('login');

            Route::post('/register', [AuthController::class, 'register'])->name('register');

            Route::get('/sanctum/token', [AuthController::class, 'refreshCookies']);
        });