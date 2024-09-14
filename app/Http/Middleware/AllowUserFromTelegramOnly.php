<?php

namespace App\Http\Middleware;

use App\Auth\Guards\TelegramGuard;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowUserFromTelegramOnly
{
    private const UNAUTHORIZED_MESSAGE = 'Unauthorized';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth(TelegramGuard::GUARD_NAME)->guest()) {
            abort(Response::HTTP_UNAUTHORIZED, self::UNAUTHORIZED_MESSAGE);
        }

        return $next($request);
    }
}
