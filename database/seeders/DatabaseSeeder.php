<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil semua seeder secara berurutan agar foreign key safe
        $this->call([
            UserSeeder::class,
            MitraSeeder::class,
            JadwalSeeder::class,
        ]);
    }
}
