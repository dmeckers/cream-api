<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::
        namespace('App\Http\Controllers\Api\V1')
    ->middleware('auth:sanctum')
    // ->prefix('v1')
    ->group(
        function () {
            // Route::get('/tracks', [TrackController::class, 'index']);
            Route::get('/tracks', function () {
                return response()->json(['message' => 'Hello World!']);
            });
            // Route::prefix('channels')->group(function () {
            //     Route::group(['prefix' => '/{channel}', 'where' => ['channel' => '[0-9]+']], function () {
            //         Route::apiResource('playlists');
            //     });
            // });
        }
    );



Route::post('/sanctum/token', [AuthController::class, 'register']);

