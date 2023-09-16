<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            StasiunSeeder::class,
            PegawaiSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
            NotifikasiSeeder::class,
        ]);
    }
}
