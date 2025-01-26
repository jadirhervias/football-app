<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->registerApiPermissions();
        $permissions = Permission::query()->where('guard_name', 'api')->get();
        $roles = [];

        foreach (Roles::cases() as $role) {
            $rolePermissions = array_map(fn ($item) => $item->value, $role->defaultPermissions());
            $permissionsToSync = $permissions->filter(function ($permission) use ($rolePermissions) {
                return in_array($permission->name, $rolePermissions);
            });

            $roles[$role->value] = Role::query()->updateOrCreate(
                [
                    'name' => $role->value,
                    'guard_name' => 'api',
                ],
                [
                    'label' => $role->label(),
                    'is_locked' => $role === Roles::SUPER_ADMIN,
                ]
            );

            $roles[$role->value]->syncPermissions($permissionsToSync);
        }

        $this->assignRoleToUser($roles[Roles::SUPER_ADMIN->value], 'admin@example.com');
    }

    private function registerApiPermissions(): void
    {
        foreach (Permissions::cases() as $permission) {
            Permission::query()->updateOrCreate(
                [
                    'name' => $permission->value,
                    'guard_name' => 'api',
                ],
                [
                    'label' => $permission->label(),
                ]
            );
        }
    }

    private function assignRoleToUser($role, string $email): void
    {
        $user = User::query()->where('email', $email)->first();

        if ($user) {
            $user->assignRole($role);
            $this->command->info('Rol ' . $role->name . ' assigned to user ' . $email . ' successfully.');

        } else {
            $this->command->error('No user found with email ' . $email);
        }
    }
}
