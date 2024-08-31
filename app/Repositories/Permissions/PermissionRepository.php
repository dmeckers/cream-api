<?php

declare(strict_types=1);

namespace App\Repositories\Permissions;
use App\Http\Data\Permissions\AttachRolePermissionRequestData;
use App\Http\Data\Permissions\DetachRolePermissionRequestData;
use App\Http\Data\Permissions\GivePermissionRequestData;
use App\Http\Data\Permissions\GiveRoleRequestData;
use App\Http\Data\Permissions\ListRolePermissionsRequestData;
use App\Http\Data\Permissions\RevokePermissionRequestData;
use App\Http\Data\Permissions\RevokeRoleRequestData;
use App\Repositories\Users\UserLogicRepository;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRepository
{
    public function __construct(
        private readonly Permission $permission,
        private readonly UserLogicRepository $userLogicRepository,
        private readonly Role $role
    ) {
    }

    public function givePermission(GivePermissionRequestData $data): void
    {
        $user = $this->userLogicRepository->findOrFail($data->userId);

        $user->givePermissionTo($data->name, $data->guardName);
    }

    public function revokePermission(RevokePermissionRequestData $data): void
    {
        $user = $this->userLogicRepository->findOrFail($data->userId);

        $user->revokePermissionTo($data->name);
    }

    public function giveRole(GiveRoleRequestData $data): void
    {
        $user = $this->userLogicRepository->findOrFail($data->userId);

        $user->assignRole($data->name, $data->guardName);
    }

    public function revokeRole(RevokeRoleRequestData $data): void
    {
        $user = $this->userLogicRepository->findOrFail($data->userId);

        $user->removeRole($data->name);
    }

    public function listPermissions(): Collection
    {
        return $this->permission->all();
    }

    public function listRoles(): Collection
    {
        return $this->role->all();
    }

    public function listRolePermissions(ListRolePermissionsRequestData $data): Collection
    {
        $role = $this->role->find($data->roleId);

        return $role->permissions;
    }

    public function attachRolePermission(AttachRolePermissionRequestData $data): void
    {
        $role = $this->role->findByName($data->roleName);

        $role->syncPermissions($data->permissionName);
    }

    public function detachRolePermission(DetachRolePermissionRequestData $data): void
    {
        $role = $this->role->findByName($data->roleName);

        $role->revokePermissionTo($data->permissionName);
    }
}