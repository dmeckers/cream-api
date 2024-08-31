<?php

namespace App\Http\Requests\Permissions;

use App\Http\Data\Permissions\GivePermissionRequestData;
use Illuminate\Foundation\Http\FormRequest;

class GivePermissionRequest extends FormRequest
{
    public function data(): GivePermissionRequestData
    {
        return resolve(GivePermissionRequestData::class);
    }
}
