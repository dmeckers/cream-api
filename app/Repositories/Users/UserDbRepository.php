<?php

declare(strict_types=1);

namespace App\Repositories\Users;

use App\Models\TelegramUser;
use App\Models\User;

class UserDbRepository
{
    public function __construct(
        private readonly User $user,
        private readonly TelegramUser $telegramUser,
    ) {
    }

    public function create(array $data): User
    {
        return $this->user->create($data);
    }

    public function findOrFail(int $id): User
    {
        return $this->user->findOrFail($id);
    }

    public function findByEmail(string $email): User
    {
        return $this->user->firstWhere(User::EMAIL, $email);
    }

    public function doesTelegramUserExists(array $credentials): bool
    {
        return $this->telegramUser->where(
            TelegramUser::TELEGRAM_USER_ID,
            '=',
            $credentials[TelegramUser::ID]
        )->exists();
    }

    public function createTelegramUser(array $credentials): TelegramUser
    {
        return $this->telegramUser->create($credentials);
    }
}