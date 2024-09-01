<?php

namespace App\Http\Requests\Permissions;

use App\Http\Data\Permissions\DetachRolePermissionRequestData;
use Illuminate\Foundation\Http\FormRequest;

class DetachRolePermissionRequest extends FormRequest
{
    public function data(): DetachRolePermissionRequestData
    {
        return resolve(DetachRolePermissionRequestData::class);
    }
}
