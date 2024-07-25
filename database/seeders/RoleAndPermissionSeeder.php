<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $manageUsers = Permission::create(['name' => 'manage users']);
        $managePosts = Permission::create(['name' => 'manage posts']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($manageUsers);
        $adminRole->givePermissionTo($managePosts);

        $userRole->givePermissionTo($managePosts);   
    }
}
