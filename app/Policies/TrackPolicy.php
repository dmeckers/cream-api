<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Utils\PermissionBook;
use App\Utils\RoleEnum;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrackPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->hasDirectPermission(PermissionBook::CREATE_TRACK_PERMISSION)
            || $user->hasRole(RoleEnum::SUPREME_STORAGE_MANAGER_GUY);
    }

    public function update(User $user)
    {
        return $user->hasDirectPermission(PermissionBook::UPDATE_TRACK_PERMISSION)
            || $user->hasRole(RoleEnum::SUPREME_STORAGE_MANAGER_GUY);
    }

    public function delete(User $user)
    {
        return $user->hasDirectPermission(PermissionBook::DELETE_TRACK_PERMISSION)
            || $user->hasRole(RoleEnum::SUPREME_STORAGE_MANAGER_GUY);
    }

    public function viewAll(User $user)
    {
        return $user->hasDirectPermission(PermissionBook::VIEW_ALL_TRACK_PERMISSION)
            || $user->hasRole(RoleEnum::SUPREME_STORAGE_MANAGER_GUY);
    }
}
