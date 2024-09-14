<?php

declare(strict_types=1);

namespace App\Http\Data\Auth;
use Spatie\LaravelData\Data;

class TelegramAuthUserData extends Data
{
    public function __construct(
        public int $id,
        public string $firstName,
        public string $username,
    ) {
    }
}