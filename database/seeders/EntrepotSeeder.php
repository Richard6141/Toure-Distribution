<?php

namespace Database\Seeders;

use App\Models\Entrepot;
use App\Models\User;
use Illuminate\Database\Seeder;

class EntrepotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @param int $count Nombre d'entrepôts à créer (par défaut 10)
     */
    public function run(int $count = 10): void
    {
        // Vérifier qu'il y a des utilisateurs
        $usersCount = User::count();

        if ($usersCount === 0) {
            $this->command->warn('⚠️  Aucun utilisateur trouvé. Les entrepôts seront créés sans gestionnaire.');
        }

        $this->command->info("🚀 Création de {$count} entrepôts...");

        // Créer 1-2 entrepôts principaux
        $principalCount = min(2, (int) ($count * 0.2));
        Entrepot::factory($principalCount)->principal()->create();
        $this->command->info("✅ {$principalCount} entrepôts principaux créés");

        // Créer des entrepôts actifs (80%)
        $activeCount = (int) (($count - $principalCount) * 0.80);
        Entrepot::factory($activeCount)->create();
        $this->command->info("✅ {$activeCount} entrepôts secondaires actifs créés");

        // Créer des entrepôts inactifs (reste)
        $inactiveCount = $count - $principalCount - $activeCount;
        if ($inactiveCount > 0) {
            Entrepot::factory($inactiveCount)->inactive()->create();
            $this->command->info("✅ {$inactiveCount} entrepôts inactifs créés");
        }

        $this->command->info("🎉 Total: {$count} entrepôts créés avec succès !");
    }
}
