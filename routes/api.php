<?php

use App\Auth\Enums\PermissionEnum;
use App\Enums\RouteValidationEnum;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
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

    /**
     * Permissions routes
     */
    Route::group([
        'prefix' => 'permissions',
        'middleware' => [\Illuminate\Auth\Middleware\Authorize::using(PermissionEnum::TG_MASTER->value)]
    ], function () {
        Route::post('/give-permission', [PermissionController::class, 'givePermission']);
        Route::post('/revoke-permission', [PermissionController::class, 'revokePermission']);
        Route::post('/give-role', [PermissionController::class, 'giveRole']);
        Route::post('/revoke-role', [PermissionController::class, 'revokeRole']);
        Route::post('/attach-role-permission', [PermissionController::class, 'attachRolePermission']);
        Route::post('/detach-role-permission', [PermissionController::class, 'detachRolePermission']);

        Route::get('/list-permissions', [PermissionController::class, 'listPermissions']);
        Route::get('/list-roles', [PermissionController::class, 'listRoles']);
        Route::get('/list-role-permissions', [PermissionController::class, 'listRolePermissions']);
    });
});

Route::
        namespace('Auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login'])->name('login');

            Route::post('/register', [AuthController::class, 'register'])->name('register');

            Route::get('/sanctum/token', [AuthController::class, 'refreshCookies']);
        });