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
        $this->command->info('🌱 Démarrage du seeding de la base de données...');
        $this->command->info('');

        // 1. Créer les types de clients d'abord
        $this->command->info('👥 Création des types de clients...');
        $this->call(ClientTypeSeeder::class);
        $this->command->info('');

        // 2. Créer les catégories de produits
        $this->command->info('📦 Création des catégories de produits...');
        $this->call(ProductCategorySeeder::class);
        $this->command->info('');

        // 3. Créer les clients
        $this->command->info('👔 Création des clients...');
        $this->call(ClientSeeder::class);
        $this->command->info('');

        // 4. Créer les produits
        $this->command->info('🛍️ Création des produits...');
        $this->call(ProductSeeder::class);
        $this->command->info('');

        $this->command->info('✨ Seeding terminé avec succès !');
    }
}
