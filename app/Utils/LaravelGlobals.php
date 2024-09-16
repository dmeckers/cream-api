<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\TelegramUser;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Bus\PendingClosureDispatch;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\JsonResponse;

class LaravelGlobals
{
    public function jsonResponse(array $response, int $code = 200): JsonResponse
    {
        return response()->json($response, $code);
    }

    public function user(): TelegramUser|User|Authenticatable|null
    {
        return auth()->user();
    }

    public function config(array|string|null $key = null, $default = null): mixed
    {
        return config($key, $default);
    }
    /*
     * @param mixed $job
     *
     * @return PendingDispatch|PendingClosureDispatch
     */
    public function dispatch(mixed $job): PendingDispatch|PendingClosureDispatch
    {
        return dispatch(...func_get_args());
    }
}