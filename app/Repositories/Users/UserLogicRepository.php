<?php

declare(strict_types=1);

namespace App\Repositories\Users;

use App\Http\Data\Auth\LoginUserRequestData;
use App\Http\Data\Auth\RegisterUserRequestData;
use App\Models\TelegramUser;
use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;

class UserLogicRepository
{

    public function __construct(
        private readonly UserDbRepository $userDbRepository,
        private readonly AuthManager $auth,
    ) {
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

    public function login(LoginUserRequestData $data): string
    {
        if (!$this->auth->attempt($data->toArray())) {
            throw new \Exception('Invalid credentials');
        }

        return $this->auth->user()->createToken('sanctum')->plainTextToken;
    }

    public function findOrFail(int $id): User
    {
        return $this->userDbRepository->findOrFail($id);
    }

    public function signInOrSignUpViaTelegram(array $credentials): TelegramUser|Authenticatable
    {
        $exists = $this->userDbRepository->doesTelegramUserExists($credentials);

        if ($exists) {
            if ($this->auth->attempt($credentials)) {
                $this->auth->login($this->auth->user());

                return $this->auth->user();
            } else {
                throw new \Exception('Invalid credentials');
            }
        }

        $telegramUser = $this->userDbRepository->createTelegramUser($credentials);

        $this->auth->login($telegramUser);

        return $telegramUser;
    }
}
