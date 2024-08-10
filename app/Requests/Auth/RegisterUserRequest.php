<?php

declare(strict_types=1);

namespace App\Requests\Auth;

use App\Data\Auth\RegisterUserRequestData;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function data(): RegisterUserRequestData
    {
        return resolve(RegisterUserRequestData::class);
    }
}