<?php

declare(strict_types=1);

namespace App\Http\Data\Auth;

use App\Models\User;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class RegisterUserRequestData extends Data
{
    public function __construct(
        #[Unique(User::class, User::EMAIL)]
        public string $email,
        public string $password,
        public string $name
    ) {
    }
}