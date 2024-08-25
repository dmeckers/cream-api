<?php

declare(strict_types=1);

namespace App\Requests\Auth;

use App\Data\Auth\LoginUserRequestData;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function data(): LoginUserRequestData
    {
        return resolve(LoginUserRequestData::class);
    }
}
