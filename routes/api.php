<?php

use App\Auth\Enums\PermissionEnum;
use App\Enums\RouteValidationEnum;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\StationsController;
use App\Http\Controllers\TracksController;
use App\Models\Track;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

Route::middleware([
    \App\Http\Middleware\SetTelegramGuard::class
])->group(function () {

    Route::middleware(\App\Http\Middleware\AllowUserFromTelegramOnly::class)->group(
        function () {


            Route::prefix('stations')->group(function () {

                Route::get('/', [StationsController::class, 'list']);
                Route::post('/', [StationsController::class, 'storeStation']);
                Route::group(
                    [
                        'prefix' => '/{station_id}',
                        'where' => ['station_id' => RouteValidationEnum::ID->value]
                    ],
                    function () {
                        Route::delete('/', [StationsController::class, 'deleteStation']);
                        Route::get('/', [StationsController::class, 'getStation']);
                        Route::post('/', [StationsController::class, 'updateStation']);
                    }
                );
            });

            // Route::prefix('playlists')->group(function () {
    
            //     Route::get('/', [PlaylistsController::class, 'list']);
            //     Route::post('/', [PlaylistsController::class, 'storePlaylist']);
            //     Route::group(
            //         [
            //             'prefix' => '/{playlist_id}',
            //             'where' => ['playlist_id' => RouteValidationEnum::ID->value]
            //         ],
            //         function () {
            //             Route::delete('/', [PlaylistsController::class, 'deletePlaylist']);
            //             Route::get('/', [PlaylistsController::class, 'getPlaylist']);
            //             Route::post('/', [PlaylistsController::class, 'updatePlaylist']);
            //         }
            //     );
            // });
    
            Route::get('/me', [AuthController::class, 'me']);
        }
    );

    Route::prefix('auth')->group(function () {
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });
});

// Route::get('/trecks', function () {
//     if (!Track::count()) {
//         return response()->json([], Response::HTTP_NOT_FOUND);
//     }

//     $filePath = collect(Storage::files(Track::latest()->first()->getName()))->first();

//     return new StreamedResponse(function () use ($filePath) {
//         $stream = Storage::readStream($filePath);
//         fpassthru($stream);
//         fclose($stream);
//     }, Response::HTTP_OK, [
//         'Content-Type' => 'audio/mpeg',
//         'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
//     ]);
// });

// Route::get('/trecks_slave', function () {
//     if (!Track::count()) {
//         return response()->json([], Response::HTTP_NOT_FOUND);
//     }
//     dump('a');

//     $filePath = collect(Storage::files(Track::first()->getName()))->first();

//     return new StreamedResponse(function () use ($filePath) {
//         $stream = Storage::readStream($filePath);
//         fpassthru($stream);
//         fclose($stream);
//     }, Response::HTTP_OK, [
//         'Content-Type' => 'audio/mpeg',
//         'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
//     ]);
// });

// Route::get('/jingles', function () {
//     $filePath = collect(Storage::files(Track::inRandomOrder()->first()->getName()))->first();

//     if (!Track::count()) {
//         return response()->json([], Response::HTTP_NOT_FOUND);
//     }

//     return new StreamedResponse(function () use ($filePath) {
//         $stream = Storage::readStream($filePath);
//         fpassthru($stream);
//         fclose($stream);
//     }, Response::HTTP_OK, [
//         'Content-Type' => 'audio/mpeg',
//         'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
//     ]);
// });


// /**
//  * Auth routes
//  */
// Route::
//         namespace('Auth')->group(function () {
//             Route::post('/login', [AuthController::class, 'login'])->name('login');

//             Route::post('/register', [AuthController::class, 'register'])->name('register');

//             Route::get('/sanctum/token', [AuthController::class, 'refreshCookies']);
//         });

// Route::get('/test', function () {
//     return response()->json(['message' => 'Hello world!']);
// });

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