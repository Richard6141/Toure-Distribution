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
        // Créer les types de clients d'abord
        $this->call([
            ClientTypeSeeder::class,
            ClientSeeder::class,
        ]);
    }
}
