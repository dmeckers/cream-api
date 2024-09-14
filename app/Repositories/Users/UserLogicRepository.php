<?php

declare(strict_types=1);

namespace App\Repositories\Users;

use App\Http\Data\Auth\LoginUserRequestData;
use App\Http\Data\Auth\RegisterUserRequestData;
use App\Http\Data\Auth\TelegramAuthRequestData;
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

    public function signInOrSignUpViaTelegram(TelegramAuthRequestData $data): TelegramUser|Authenticatable
    {
        $exists = $this->userDbRepository->doesTelegramUserExists($data->userData->id);

        if (!$exists) {
            $telegramUser = $this->userDbRepository->createTelegramUser([
                TelegramUser::TELEGRAM_USER_ID => $data->userData->id,
                TelegramUser::NAME => $data->userData->firstName,
                TelegramUser::USERNAME => $data->userData->username,
            ]);

            $this->auth->login($telegramUser);

            return $telegramUser;
        }

        if ($this->auth->attempt($data->userData->toArray())) {
            return $this->userDbRepository->getTelegramUserByTelegramId($data->userData->id);
        } else {
            throw new \Exception('Invalid credentials');
        }
    }
}
