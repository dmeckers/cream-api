<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetTelegramGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Auth::setDefaultDriver('telegram');

        return $next($request);
        // ->header('Access-Control-Allow-Credentials', 'true')
        // ->header('Access-Control-Allow-Origin', 'https://yellow-lands-attend.loca.lt/')
        // ->header('Access-Control-Allow-Methods', '*')
        // ->header('Access-Control-Max-Age', '3600')
        // ->header('Access-Control-Allow-Headers', 'X-Requested-With, Origin, X-Csrftoken, Content-Type, Accept, Authorization');
    }

}
