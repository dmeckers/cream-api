<?php

namespace App\Http\Requests\Permissions;

use App\Http\Data\Permissions\RevokeRoleRequestData;
use Illuminate\Foundation\Http\FormRequest;

class RevokeRoleRequest extends FormRequest
{
    public function data(): RevokeRoleRequestData
    {
        return resolve(RevokeRoleRequestData::class);
    }
}
