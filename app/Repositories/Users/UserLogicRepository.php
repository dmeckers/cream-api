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

        if ($exists) {
            if ($this->validate([])) {
                $telegramUser = $this->userDbRepository->getTelegramUserByTelegramId($data->userData->id);

                $this->auth->login($telegramUser);

                return $this->auth->user();

            } else {
                throw new \Exception('Invalid credentials');
            }
        }

        $telegramUser = $this->userDbRepository->createTelegramUser([
            TelegramUser::TELEGRAM_USER_ID => $data->userData->id,
            TelegramUser::NAME => $data->userData->firstName,
            TelegramUser::USERNAME => $data->userData->username,
        ]);

        $this->auth->login($telegramUser);

        return $telegramUser;
    }

    public function validate(array $credentials = []): bool
    {
        return true;
        // \Log::info("CHECKING CREDENTIALS", $credentials);

        // if (isset($credentials['id'])) {
        //     // $auth_data = $credentials['auth_data'];
        //     // if ($this->verifyTelegramData($auth_data)) { }

        //     if () {
        //         return true;
        //     }
        // }

        // return false;
    }

    private function verifyTelegramData($auth_data): bool
    {
        \Log::info("VERIFYING TELEGRAM DATA", $auth_data);

        $botToken = env(key: 'TELEGRAM_BOT_TOKEN');

        $checkString = collect(value: $auth_data)
            ->except(keys: 'hash')
            ->map(callback: fn($value, $key): string => (string) $key . "=" . (string) $value)
            ->sortKeys()
            ->implode(value: "\n");

        $secretKey = hash_hmac(
            algo: 'sha256',
            data: $botToken,
            key: 'WebAppData',
            binary: true
        );

        $calculatedHash = hash_hmac(
            algo: 'sha256',
            data: $checkString,
            key: $secretKey
        );

        // Telegram's hash comes as hex, and we need to compare it
        return hash_equals(known_string: $calculatedHash, user_string: $auth_data['hash']);
    }
}
