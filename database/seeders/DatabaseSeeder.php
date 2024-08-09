<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Artisan::call('laravolt:indonesia:seed');
        $this->call([
            MasterBobotBlanko1ASeeder::class,
            MasterBobotBlanko1BSeeder::class,
            MasterBobotBlanko1CSeeder::class,
            MasterBobotBlanko2Seeder::class,
            MasterBobotBlanko3ASeeder::class,
            MasterBobotBlanko3BSeeder::class,
            MasterBobotBlanko3CSeeder::class,
            MasterBobotBlanko3DSeeder::class,
            UserSeeder::class,
            RoleAndPermissionSeeder::class,
            JaringanSeeder::class,
        ]);
    }
}
