<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        // Villes principales de Côte d'Ivoire
        $cities = [
            'Abidjan',
            'Bouaké',
            'Daloa',
            'Yamoussoukro',
            'San-Pédro',
            'Korhogo',
            'Man',
            'Gagnoa',
            'Divo',
            'Abengourou',
            'Grand-Bassam',
            'Dabou',
            'Agboville',
            'Anyama',
            'Bingerville'
        ];

        // Quartiers d'Abidjan
        $quartiers = [
            'Plateau',
            'Cocody',
            'Yopougon',
            'Marcory',
            'Treichville',
            'Adjamé',
            'Abobo',
            'Port-Bouët',
            'Koumassi',
            'Attécoubé'
        ];

        // Types d'entreprises ivoiriennes
        $entreprises = [
            'SARL',
            'SA',
            'SAS',
            'GIE',
            'Coopérative',
            'Entreprise Individuelle',
            'SNC',
            'SCS'
        ];

        $city = fake()->randomElement($cities);
        $isAbidjan = $city === 'Abidjan';

        // Générer l'adresse
        $adresse = $isAbidjan
            ? fake()->randomElement(['Boulevard', 'Avenue', 'Rue', 'Carrefour']) . ' ' .
            fake()->randomElement($quartiers)
            : fake()->randomElement(['Quartier', 'Avenue', 'Rue', 'Carrefour']) . ' ' .
            fake()->word();

        return [
            'code' => 'CLI-' . strtoupper(fake()->lexify('???')) . '-' . fake()->numberBetween(1000, 9999),
            'name_client' => fake()->randomElement([
                fake()->company() . ' ' . fake()->randomElement($entreprises),
                fake()->lastName() . ' ' . fake()->randomElement(['Distribution', 'Services', 'Commerce', 'Trading']),
                fake()->word() . fake()->randomElement(['Corp', 'Group', 'International', 'Services', 'Solutions'])
            ]),
            'name_representant' => fake()->firstName() . ' ' . fake()->lastName(),
            'marketteur' => fake()->optional(0.7)->randomElement([
                fake()->firstName() . ' ' . fake()->lastName(),
                fake()->firstName() . ' ' . fake()->lastName(),
            ]),
            'client_type_id' => ClientType::inRandomOrder()->first()?->client_type_id,
            'adresse' => $adresse,
            'city' => $city,

            // ✅ CORRECTION ICI: Utiliser unique() pour éviter les doublons
            'email' => fake()->unique()->safeEmail(),

            // IFU ivoirien (format: CI-VILLE-ANNÉE-TYPE-NUMÉRO)
            'ifu' => 'CI-' . strtoupper(substr($city, 0, 3)) . '-' . date('Y') . '-' .
                fake()->randomElement(['A', 'B', 'C']) . '-' .
                fake()->numberBetween(10000, 99999),

            // Téléphone ivoirien (+225 suivi de 10 chiffres)
            'phonenumber' => '+225 ' .
                fake()->randomElement(['01', '05', '07', '27', '47', '57']) . ' ' .
                fake()->numberBetween(10, 99) . ' ' .
                fake()->numberBetween(10, 99) . ' ' .
                fake()->numberBetween(10, 99) . ' ' .
                fake()->numberBetween(10, 99),

            'credit_limit' => fake()->randomElement([
                500000,
                1000000,
                2000000,
                5000000,
                10000000,
                20000000
            ]),
            'current_balance' => fake()->randomFloat(2, 0, 5000000),
            'base_reduction' => fake()->randomFloat(2, 0, 15), // Réduction de 0 à 15%
            'is_active' => true,
        ];
    }

    /**
     * Créer un client VIP avec limite de crédit élevée
     */
    public function vip(): static
    {
        return $this->state(fn(array $attributes) => [
            'credit_limit' => fake()->randomElement([10000000, 20000000, 50000000]),
            'base_reduction' => fake()->randomFloat(2, 10, 20),
        ]);
    }

    /**
     * Créer un client inactif
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
