<?php

namespace App\Http\Requests\Permissions;

use App\Http\Data\Permissions\ListRolePermissionsRequestData;
use Illuminate\Foundation\Http\FormRequest;

class ListRolePermissionsRequest extends FormRequest
{
    public function data(): ListRolePermissionsRequestData
    {
        return resolve(ListRolePermissionsRequestData::class);
    }
}
