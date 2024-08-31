<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Http\Data\Auth\LoginUserRequestData;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function data(): LoginUserRequestData
    {
        return resolve(LoginUserRequestData::class);
    }
}
