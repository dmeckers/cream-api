<?php

declare(strict_types=1);

namespace App\Http\Data\Permissions;

use App\Models\User;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class RevokeRoleRequestData extends Data
{
    public function __construct(
        #[Exists('roles', 'name')]
        public string $name,
        #[Exists(User::TABLE, User::ID)]
        public int $userId,
    ) {
    }
}
