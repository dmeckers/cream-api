<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Http\JsonResponse;

class LaravelGlobals
{
    public function jsonResponse(array $response, int $code = 200): JsonResponse
    {
        return response()->json($response, $code);
    }
}