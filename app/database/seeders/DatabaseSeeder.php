<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            WeaponSeeder::class,
            GameSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
            MessageSeeder::class,
        ]);
    }
}
