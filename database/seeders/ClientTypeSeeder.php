<?php

namespace Database\Seeders;

use App\Models\ClientType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'label' => 'Grossiste',
                'icon' => 'warehouse',
                'description' => 'Client achetant en grande quantité pour revendre'
            ],
            [
                'label' => 'Détaillant',
                'icon' => 'store',
                'description' => 'Boutique ou magasin vendant au consommateur final'
            ],
            [
                'label' => 'Entreprise',
                'icon' => 'building',
                'description' => 'Société ou entreprise pour usage professionnel'
            ],
            [
                'label' => 'Particulier',
                'icon' => 'user',
                'description' => 'Client individuel'
            ],
            [
                'label' => 'Distributeur',
                'icon' => 'truck',
                'description' => 'Distributeur régional ou national'
            ],
            [
                'label' => 'Restaurant/Hôtel',
                'icon' => 'utensils',
                'description' => 'Établissement de restauration ou hôtelier'
            ],
            [
                'label' => 'Export',
                'icon' => 'globe',
                'description' => 'Client à l\'export (hors Côte d\'Ivoire)'
            ],
        ];

        foreach ($types as $type) {
            ClientType::create([
                'client_type_id' => (string) Str::uuid(),
                'label' => $type['label'],
                'icon' => $type['icon'],
                'description' => $type['description'],
            ]);
        }

        $this->command->info('✅ Types de clients créés avec succès !');
    }
}
