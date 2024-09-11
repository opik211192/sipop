<?php

namespace Database\Seeders;

use App\Models\User;
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
        $pembinaRole = Role::create(['name' => 'Tim Pembina']);
        $pelaksanaRole = Role::create(['name' => 'Tim Pelaksana']);

        // Create permissions
        $permissions = [
            'manage users',
            'manage blanko',
            'view blanko',
            'create upload',
            'edit upload',
            'view upload',
            'create paket',
            'edit paket',
            'delete paket',
            'view paket',
            'ba akhir upload'
        ];

       foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        // Admin has access to all permissions
        $adminRole->givePermissionTo($permissions);

         $timPembinaPermissions = [
            'view blanko',
            'view upload',
            'view paket'
        ];

         $pembinaRole->givePermissionTo($timPembinaPermissions);

         // Tim Pelaksana has almost all permissions except manage users
        $timPelaksanaPermissions = [
            'manage blanko',
            'view blanko',
            'create upload',
            'edit upload',
            'view upload',
            'create paket',
            'edit paket',
            'delete paket',
            'view paket',
            'ba akhir upload'
        ];
        $pelaksanaRole->givePermissionTo($timPelaksanaPermissions);

             // Create users and assign roles
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'), // Ganti dengan password yang sesuai
                'role' => 'admin'
            ],
            [
                'name' => 'Opik',
                'email' => 'opik@mail.com',
                'password' => bcrypt('password'), // Ganti dengan password yang sesuai
                'role' => 'Tim Pembina'
            ],
            [
                'name' => 'Taofik',
                'email' => 'taofik@mail.com',
                'password' => bcrypt('password'), // Ganti dengan password yang sesuai
                'role' => 'Tim Pelaksana'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password']
            ]);

            // Assign role to user
            $user->assignRole($userData['role']);
        }
    }
}
