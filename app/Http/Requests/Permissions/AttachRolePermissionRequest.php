<?php

namespace App\Http\Requests\Permissions;

use App\Http\Data\Permissions\AttachRolePermissionRequestData;
use Illuminate\Foundation\Http\FormRequest;

class AttachRolePermissionRequest extends FormRequest
{
    public function data(): AttachRolePermissionRequestData
    {
        return resolve(AttachRolePermissionRequestData::class);
    }
}
