<?php

declare(strict_types=1);

namespace App\Http\Data\Auth;

use Spatie\LaravelData\Data;

class LoginUserRequestData extends Data
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}