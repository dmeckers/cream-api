<?php

declare(strict_types=1);

namespace App\Http\Data\Permissions;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class AttachRolePermissionRequestData extends Data
{
    private const DEFAULT_GUARD_NAME = 'web';

    public function __construct(
        #[Exists('permissions', 'name')]
        public string $permissionName,
        #[Exists('roles', 'name')]
        public string $roleName,
        public string $guardName = self::DEFAULT_GUARD_NAME,
    ) {
    }
}
