<?php

namespace App\Http\Requests\Permissions;

use App\Http\Data\Permissions\RevokePermissionRequestData;
use Illuminate\Foundation\Http\FormRequest;

class RevokePermissionRequest extends FormRequest
{
    public function data(): RevokePermissionRequestData
    {
        return resolve(RevokePermissionRequest::class);
    }
}
