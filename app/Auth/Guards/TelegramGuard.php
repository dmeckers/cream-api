<?php

declare(strict_types=1);

namespace App\Auth\Guards;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use \Illuminate\Cookie\CookieJar;
use Illuminate\Support\Facades\Cookie;

class TelegramGuard implements Guard
{
    protected $user;

    private const COOKIE_LIFETIME_30_DAYS = 60 * 24 * 30;
    private const COOKIE_IDENTITY         = 'user_id';

    public function __construct(
        protected readonly UserProvider $provider,
        protected readonly Request $request,
        private readonly CookieJar $cookieJar,
    ) {
    }

    public function user(): mixed
    {
        if ($this->user) {
            $this->user;
        }

        $userId = $this->request->cookie(self::COOKIE_IDENTITY);

        if ($userId) {
            $this->user = $this->provider->retrieveById(identifier: $userId);
        }

        return $this->user;
    }

    public function validate(array $credentials = []): bool
    {
        \Log::info("CHECKING CREDENTIALS", $credentials);

        if (isset($credentials['auth_data'])) {
            $auth_data = $credentials['auth_data'];

            if ($this->verifyTelegramData($auth_data)) {
                $this->user = $this->provider->retrieveById($auth_data['id']);
                if ($this->user) {
                    $this->setAuthCookie($this->user->getAuthIdentifier());
                    return true;
                }
            }
        }

        return false;
    }

    protected function setAuthCookie($userId)
    {
        $cookie = $this->cookieJar->make(
            self::COOKIE_IDENTITY,
            $userId,
            self::COOKIE_LIFETIME_30_DAYS
        );

        $this->request->headers->setCookie($cookie);
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