<?php

use App\Enums\RouteValidationEnum;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TracksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::prefix('tracks')->group(function () {
        Route::get('/', [TracksController::class, 'listTracks']);
        Route::post('/', [TracksController::class, 'storeTrack']);
        Route::group(
            [
                'prefix' => '/{track_id}',
                'where' => ['track_id' => RouteValidationEnum::ID->value]
            ],
            function () {
                Route::delete('/', [TracksController::class, 'deleteTrack']);
                Route::get('/', [TracksController::class, 'getTrack']);
                Route::post('/', [TracksController::class, 'updateTrack']);
            }
        );
    });
});

Route::
        namespace('Auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login'])->name('login');

            Route::post('/register', [AuthController::class, 'register'])->name('register');

            Route::get('/sanctum/token', [AuthController::class, 'refreshCookies']);
        });