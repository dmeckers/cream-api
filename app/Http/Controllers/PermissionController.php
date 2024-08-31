<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Permissions\AttachRolePermissionRequest;
use App\Http\Requests\Permissions\DetachRolePermissionRequest;
use App\Http\Requests\Permissions\GivePermissionRequest;
use App\Http\Requests\Permissions\GiveRoleRequest;
use App\Http\Requests\Permissions\ListPermissionsRequest;
use App\Http\Requests\Permissions\ListRolePermissionsRequest;
use App\Http\Requests\Permissions\ListRolesRequest;
use App\Http\Requests\Permissions\RevokePermissionRequest;
use App\Http\Requests\Permissions\RevokeRoleRequest;
use App\Repositories\Permissions\PermissionRepository;
use App\Utils\LaravelGlobals;
use Illuminate\Http\JsonResponse;

class PermissionController
{
    public function __construct(
        private readonly LaravelGlobals $laravelGlobals,
        private readonly PermissionRepository $permissionRepository
    ) {
    }

    public function givePermission(GivePermissionRequest $request): JsonResponse
    {
        $this->permissionRepository->givePermission($request->data());

        return $this->laravelGlobals->jsonResponse(['message' => 'Permission given successfully']);
    }

    public function revokePermission(RevokePermissionRequest $request): JsonResponse
    {
        $this->permissionRepository->revokePermission($request->data());

        return $this->laravelGlobals->jsonResponse(['message' => 'Permission revoked successfully']);
    }

    public function giveRole(GiveRoleRequest $request): JsonResponse
    {
        $this->permissionRepository->giveRole($request->data());

        return $this->laravelGlobals->jsonResponse(['message' => 'Role given successfully']);
    }

    public function revokeRole(RevokeRoleRequest $request)
    {
        $this->permissionRepository->revokeRole($request->data());

        return $this->laravelGlobals->jsonResponse(['message' => 'Role revoked successfully']);
    }

    public function listPermissions(ListPermissionsRequest $unusedRequest): JsonResponse
    {
        return $this->laravelGlobals->jsonResponse(['data' => $this->permissionRepository->listPermissions()]);
    }

    public function listRoles(ListRolesRequest $unusedRequest): JsonResponse
    {
        return $this->laravelGlobals->jsonResponse(['data' => $this->permissionRepository->listRoles()]);
    }

    public function listRolePermissions(ListRolePermissionsRequest $request): JsonResponse
    {
        return $this->laravelGlobals->jsonResponse([
            'data' => $this->permissionRepository->listRolePermissions($request->data())
        ]);
    }

    public function attachRolePermission(AttachRolePermissionRequest $request): JsonResponse
    {
        $this->permissionRepository->attachRolePermission($request->data());

        return $this->laravelGlobals->jsonResponse(['message' => 'Role permission attached successfully']);
    }

    public function detachRolePermission(DetachRolePermissionRequest $request): JsonResponse
    {
        $this->permissionRepository->detachRolePermission($request->data());

        return $this->laravelGlobals->jsonResponse(['message' => 'Role permission detached successfully']);
    }
}