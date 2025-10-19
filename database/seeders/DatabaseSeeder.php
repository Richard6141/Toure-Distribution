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

        // 5. Créer les fournisseurs
        $this->command->info('🏭 Création des fournisseurs...');
        $this->call(FournisseurSeeder::class);
        $this->command->info('');

        // 6. Créer les entrepôts
        $this->command->info('🏢 Création des entrepôts...');
        $this->call(EntrepotSeeder::class);
        $this->command->info('');

        // 7. Créer les ventes avec leurs détails
        $this->command->info('💰 Création des ventes...');
        $this->call(VenteSeeder::class);
        $this->command->info('');
        // Étape 1: Créer les permissions
        $this->command->info('📝 Étape 1/2 : Création des permissions...');
        $this->call(RolesPermissionSeeder::class);
        $this->command->info('');

        // Étape 2: Créer les rôles et assigner les permissions
        $this->command->info('👥 Étape 2/2 : Création des rôles et assignation des permissions...');
        $this->call(RolesSeeder::class);
        $this->command->info('');

        $this->command->info('✨ Seeding terminé avec succès !');
    }
}
