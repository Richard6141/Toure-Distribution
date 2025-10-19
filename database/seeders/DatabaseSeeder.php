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