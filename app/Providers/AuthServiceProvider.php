<?php

declare(strict_types=1);

namespace App\Providers;

use App\Utils\PermissionBook;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();

        collect(PermissionBook::GATE_TO_POLICY)->each(
            fn(array $gate, string $permission) => Gate::define($permission, $gate)
        );
    }
}
