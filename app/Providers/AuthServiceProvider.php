<?php

namespace App\Providers;

use App\Auth\Guards\TelegramGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Auth::extend('telegram', function ($app, $name, array $config) {
            return new TelegramGuard(
                Auth::createUserProvider($config['provider']),
                $app['request'],
                $app['cookie']
            );
        });
    }
}
