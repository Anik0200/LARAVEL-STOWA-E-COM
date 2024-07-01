<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\rolePermission\AdminSeeder;
use Database\Seeders\rolePermission\EditorSeeder;
use Database\Seeders\rolePermission\RolePermissionSeeder;
use Database\Seeders\rolePermission\SuperAdminSeeder;
use Database\Seeders\rolePermission\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // ==== Role Permission
            RolePermissionSeeder::class,
            SuperAdminSeeder::class,


            // ==== category
            // CategorySeeder::class,

            // ==== product
            // ProductSeeder::class

            // ==== Color And Size
            SizeSeeder::class,
        ]);
    }
}
