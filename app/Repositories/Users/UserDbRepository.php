<?php

declare(strict_types=1);

namespace App\Repositories\Users;

use App\Models\User;

class UserDbRepository
{
    public function __construct(private readonly User $user)
    {
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
}