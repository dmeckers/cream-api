<?php

namespace App\Http\Requests\Permissions;

use App\Http\Data\Permissions\GiveRoleRequestData;
use Illuminate\Foundation\Http\FormRequest;

class GiveRoleRequest extends FormRequest
{
    public function data(): GiveRoleRequestData
    {
        return resolve(GiveRoleRequestData::class);
    }
}
