<?php

namespace Database\Seeders\rolePermission;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['add', 'view', 'edit', 'delete'];

        foreach ($permissions as $permission) {

            Permission::create([
                'name' => $permission
            ]);
        }

        $roles = ['super-admin', 'admin', 'editor', 'user'];

        foreach ($roles as $role) {

            Role::create([
                'name' => $role
            ]);
        }

        $superAdmin = Role::find(1);
        $superAdmin->givePermissionTo([$permissions]);

        $Admin = Role::find(2);
        $Admin->givePermissionTo(['add', 'view', 'edit']);

        $editor = Role::find(3);
        $editor->givePermissionTo(['add', 'view', 'edit']);

        $user = Role::find(4);
        $user->givePermissionTo(['view']);
    }
}
