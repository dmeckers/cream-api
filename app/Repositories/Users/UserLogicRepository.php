<?php

declare(strict_types=1);

namespace App\Repositories\Users;

use App\Data\Auth\RegisterUserRequestData;
use App\Models\User;

class UserLogicRepository
{
    public function __construct(private readonly UserDbRepository $userDbRepository)
    {
    }

    public function create(RegisterUserRequestData $data): string
    {
        $user = $this->userDbRepository->create([
            User::EMAIL => $data->email,
            User::PASSWORD => $data->password,
            User::NAME => $data->name,
        ]);

        return $user->createToken('sanctum')->plainTextToken;
    }

    // public function login(RegisterUserRequestData $data): string
    // {
    //     $user = $this->userDbRepository->findOrFail($data->id);

    //     return $user->createToken('sanctum')->plainTextToken;
    // }

    public function findOrFail(int $id): User
    {
        return $this->userDbRepository->findOrFail($id);
    }
}