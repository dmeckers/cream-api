<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    private const SUPREME_STORAGE_ROLE = 'supreme_storage_manager_guy';

    private const CREATE_TRACK_PERMISSION   = 'track.create';
    private const UPDATE_TRACK_PERMISSION   = 'track.update';
    private const DELETE_TRACK_PERMISSION   = 'track.delete';
    private const VIEW_ALL_TRACK_PERMISSION = 'track.view-all';

    private const TRACK_MANAGE_PERMISSIONS = [
        self::CREATE_TRACK_PERMISSION,
        self::UPDATE_TRACK_PERMISSION,
        self::DELETE_TRACK_PERMISSION,
        self::VIEW_ALL_TRACK_PERMISSION,
    ];
    private const GUARD_NAME               = 'web';

    private const ME = 'gombovombo@gmail.com';

    public function up(): void
    {
        $role = Role::findOrCreate(self::SUPREME_STORAGE_ROLE, self::GUARD_NAME);

        $permissions = collect(self::TRACK_MANAGE_PERMISSIONS)->map(
            fn(string $permission) => Permission::create(['name' => $permission])
        );

        $role->syncPermissions($permissions);

        User::firstWhere(User::EMAIL, '=', self::ME)->assignRole($role);
    }

    public function down(): void
    {
        $role = Role::findByName(self::SUPREME_STORAGE_ROLE);

        $role->revokePermissionTo(self::TRACK_MANAGE_PERMISSIONS);

        Permission::whereIn('name', self::TRACK_MANAGE_PERMISSIONS)->delete();

        $role->delete();
    }
};
