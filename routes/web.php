<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::
        namespace('App')->group(function () {
            // Route::get('/healthcheck', [MainController::class, 'healthcheck'])->name('app.health-check');
            // Route::get('/short-urls/s/{shortUrlCode}', [ShortUrlController::class, 'redirectShortUrl'])
            //     ->middleware(ThrottleEnum::SHORT_URL);
        });



Route::
        namespace('Auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login'])->name('login');

            Route::post('/register', [AuthController::class, 'register'])->name('register');

            Route::get('/sanctum/token', [AuthController::class, 'refreshCookies']);
        });