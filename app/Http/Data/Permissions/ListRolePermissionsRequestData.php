<?php

declare(strict_types=1);

namespace App\Http\Data\Permissions;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ListRolePermissionsRequestData extends Data
{
    public function __construct(
        #[Exists('roles', 'id')]
        public int $roleId,
    ) {
    }
}
