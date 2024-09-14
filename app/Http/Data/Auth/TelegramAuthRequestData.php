<?php

declare(strict_types=1);

namespace App\Http\Data\Auth;
use Spatie\LaravelData\Data;

class TelegramAuthRequestData extends Data
{
    public function __construct(
        public TelegramAuthUserData $userData,
        // public string $hash
        // public int $authDate
    ) {
    }
}