<?php

declare(strict_types=1);

namespace App\Auth\Guards;

use App\Models\TelegramUser;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use \Illuminate\Cookie\CookieJar;
use Illuminate\Support\Facades\Cookie;
use Laravel\Sanctum\PersonalAccessToken;

class TelegramGuard implements Guard
{
    protected $user;

    public const GUARD_NAME = 'telegram';

    public function __construct(
        protected readonly UserProvider $provider,
        protected readonly Request $request,
        protected readonly PersonalAccessToken $personalAccessToken,
    ) {
    }

    private $isRetrievingUser = false;

    public function user(): mixed
    {
        if ($this->isRetrievingUser) {
            return null;
        }

        $this->isRetrievingUser = true;

        $token = $this->request->bearerToken();

        if (!$token) {
            $this->isRetrievingUser = false;
            return null;
        }

        $this->user = PersonalAccessToken::findToken($token)?->tokenable()->first();

        $this->isRetrievingUser = false;

        return $this->user;
    }

    public function validate(array $credentials = []): bool
    {
        \Log::info("CHECKING CREDENTIALS", $credentials);

        if (isset($credentials['id'])) {
            // $auth_data = $credentials['auth_data'];
            // if ($this->verifyTelegramData($auth_data)) {
            // }

            $this->user = $this->provider->retrieveByCredentials([
                TelegramUser::TELEGRAM_USER_ID => $credentials['id']
            ]);

            return $this->user !== null;
        }

        return false;
    }


    public function attempt(array $credentials = [], bool $remember = false): bool
    {
        if ($this->validate($credentials)) {
            $this->login($this->user);
            return true;
        }

        return false;
    }

    public function check(): bool
    {
        return $this->user() !== null;
    }

    public function guest(): bool
    {
        return !$this->check();
    }

    public function id(): mixed
    {
        return $this->user() ? $this->user()->getAuthIdentifier() : null;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }
    /**
     * @inheritDoc
     */
    public function hasUser(): bool
    {
        return $this->user() !== null;
    }

    public function login($user): bool
    {
        $this->setUser($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return true;
    }

    // private function verifyTelegramData($auth_data): bool
    // {
    //     \Log::info("VERIFYING TELEGRAM DATA", $auth_data);

    //     $botToken = env(key: 'TELEGRAM_BOT_TOKEN');

    //     $checkString = collect(value: $auth_data)
    //         ->except(keys: 'hash')
    //         ->map(callback: fn($value, $key): string => (string) $key . "=" . (string) $value)
    //         ->sortKeys()
    //         ->implode(value: "\n");

    //     $secretKey = hash_hmac(
    //         algo: 'sha256',
    //         data: $botToken,
    //         key: 'WebAppData',
    //         binary: true
    //     );

    //     $calculatedHash = hash_hmac(
    //         algo: 'sha256',
    //         data: $checkString,
    //         key: $secretKey
    //     );

    //     // Telegram's hash comes as hex, and we need to compare it
    //     return hash_equals(known_string: $calculatedHash, user_string: $auth_data['hash']);
    // }
}