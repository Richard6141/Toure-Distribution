<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @param int $count Nombre de clients à créer (par défaut 100)
     */
    public function run(int $count = 100): void
    {
        $this->command->info("🚀 Création de {$count} clients ivoiriens...");

        // Créer des clients normaux
        $normalCount = (int) ($count * 0.85); // 85% de clients normaux
        Client::factory($normalCount)->create();
        $this->command->info("✅ {$normalCount} clients normaux créés");

        // Créer des clients VIP
        $vipCount = (int) ($count * 0.10); // 10% de clients VIP
        Client::factory($vipCount)->vip()->create();
        $this->command->info("✅ {$vipCount} clients VIP créés");

        // Créer des clients inactifs
        $inactiveCount = $count - $normalCount - $vipCount; // Le reste
        Client::factory($inactiveCount)->inactive()->create();
        $this->command->info("✅ {$inactiveCount} clients inactifs créés");

        $this->command->info("🎉 Total: {$count} clients créés avec succès !");
    }
}