<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Http\Data\Auth\TelegramAuthRequestData;
use App\Http\Data\Auth\TelegramAuthUserData;
use App\Utils\ValidationRuleHelper;
use Illuminate\Foundation\Http\FormRequest;

class TelegramAuthRequest extends FormRequest
{
    private const AUTH_DATA                 = 'auth_data';
    private const AUTH_DATA_USER_ID         = 'auth_data.user.id';
    private const AUTH_DATA_USER_FIRST_NAME = 'auth_data.user.first_name';
    private const AUTH_DATA_USER_USERNAME   = 'auth_data.user.username';
    private const AUTH_DATA_AUTH_DATE       = 'auth_data.auth_date';
    private const AUTH_DATA_HASH            = 'auth_data.hash';

    public function rules(): array
    {
        return [
            self::AUTH_DATA => [
                ValidationRuleHelper::REQUIRED,
                ValidationRuleHelper::ARRAY ,
            ],
            self::AUTH_DATA_USER_ID => [
                ValidationRuleHelper::REQUIRED,
                ValidationRuleHelper::NUMERIC,
            ],
            self::AUTH_DATA_USER_FIRST_NAME => [
                ValidationRuleHelper::REQUIRED,
                ValidationRuleHelper::STRING,
            ],
            self::AUTH_DATA_USER_USERNAME => [
                ValidationRuleHelper::REQUIRED,
                ValidationRuleHelper::STRING,
            ],
            // self::AUTH_DATA_AUTH_DATE => [
            //     ValidationRuleHelper::REQUIRED,
            //     ValidationRuleHelper::NUMERIC,
            // ],
            // self::AUTH_DATA_HASH => [
            //     ValidationRuleHelper::REQUIRED,
            //     ValidationRuleHelper::STRING,
            // ],
        ];
    }

    public function data(): TelegramAuthRequestData
    {
        return new TelegramAuthRequestData(
            userData: new TelegramAuthUserData(
                id: $this->input(self::AUTH_DATA_USER_ID),
                firstName: $this->input(self::AUTH_DATA_USER_FIRST_NAME),
                username: $this->input(self::AUTH_DATA_USER_USERNAME),
            ),
        );
    }
}