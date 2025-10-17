<?php

namespace Database\Seeders;

use App\Models\Fournisseur;
use Illuminate\Database\Seeder;

class FournisseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @param int $count Nombre de fournisseurs à créer (par défaut 30)
     */
    public function run(int $count = 30): void
    {
        $this->command->info("🚀 Création de {$count} fournisseurs ivoiriens...");

        // Créer des fournisseurs actifs (90%)
        $activeCount = (int) ($count * 0.90);
        Fournisseur::factory($activeCount)->create();
        $this->command->info("✅ {$activeCount} fournisseurs actifs créés");

        // Créer des fournisseurs inactifs (10%)
        $inactiveCount = $count - $activeCount;
        Fournisseur::factory($inactiveCount)->inactive()->create();
        $this->command->info("✅ {$inactiveCount} fournisseurs inactifs créés");

        $this->command->info("🎉 Total: {$count} fournisseurs créés avec succès !");
    }
}
