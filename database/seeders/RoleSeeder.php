<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $rolesConfig = config('const.roles');

        $allPermissions = [];
        foreach ($rolesConfig as $module) {
            foreach ($module['roles'] as $permissionName) {
                $permission = Permission::firstOrCreate(
                    ['name' => $permissionName],
                    ['guard_name' => 'web']
                );

                $allPermissions[] = $permission->name;
            }
        }
        foreach ($rolesConfig as $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $roleData['name']],
                ['guard_name' => 'web']
            );

            if (strtolower($roleData['name']) === 'admin') {
                $role->syncPermissions($allPermissions);
            } else {
                $role->syncPermissions($roleData['roles']);
            }

            $this->command->info("Role '{$role->name}' created with permissions.");
        }
    }
}
