<?php

namespace Database\Factories;

use App\Models\Entrepot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrepot>
 */
class EntrepotFactory extends Factory
{
    protected $model = Entrepot::class;

    /**
     * Zones d'Abidjan pour les entrepôts
     */
    private array $abidjaneZones = [
        'Zone Industrielle Yopougon',
        'Zone Industrielle Koumassi',
        'Zone Portuaire Vridi',
        'Plateau',
        'Marcory Zone 4',
        'Treichville',
        'Abobo',
        'Adjamé',
        'Port-Bouët',
    ];

    /**
     * Autres villes pour entrepôts régionaux
     */
    private array $regionalCities = [
        'Yamoussoukro',
        'Bouaké',
        'San-Pédro',
        'Daloa',
        'Korhogo',
    ];

    /**
     * Types d'entrepôts
     */
    private array $warehouseTypes = [
        'Principal',
        'Secondaire',
        'Régional',
        'Transit',
        'Stockage',
    ];

    public function definition(): array
    {
        $isAbidjan = $this->faker->boolean(70); // 70% des entrepôts à Abidjan
        $code = $this->generateWarehouseCode();
        $name = $this->generateWarehouseName();

        return [
            'entrepot_id' => (string) Str::uuid(),
            'code' => $code,
            'name' => $name,
            'adresse' => $this->generateAddress($isAbidjan),
            'is_active' => $this->faker->boolean(90), // 90% actifs
            'user_id' => User::inRandomOrder()->first()?->user_id ?? null,
        ];
    }

    /**
     * Générer un nom d'entrepôt UNIQUE
     */
    private function generateWarehouseName(): string
    {
        // ✅ Ajout d'un identifiant unique pour éviter les doublons
        $uniqueId = strtoupper(Str::random(3)) . '-' . $this->faker->numberBetween(100, 999);

        $types = [
            fn() => 'Entrepôt ' . $this->faker->randomElement($this->warehouseTypes) . ' ' .
                $this->faker->randomElement(['A', 'B', 'C', '1', '2', '3']) . ' ' . $uniqueId,

            fn() => 'Dépôt ' . $this->faker->randomElement($this->abidjaneZones) . ' ' . $uniqueId,

            fn() => 'Centre de Distribution ' .
                $this->faker->randomElement(['Nord', 'Sud', 'Est', 'Ouest', 'Central']) .
                ' ' . $uniqueId,

            fn() => 'Plateforme Logistique ' .
                $this->faker->randomElement($this->regionalCities) .
                ' ' . $uniqueId,

            fn() => 'Magasin ' . $this->faker->randomElement($this->warehouseTypes) . ' ' . $uniqueId,
        ];

        return $this->faker->randomElement($types)();
    }

    /**
     * Générer un code entrepôt unique
     */
    private function generateWarehouseCode(): string
    {
        return 'WH-' . strtoupper(Str::random(3)) . '-' .
            $this->faker->unique()->numberBetween(100, 999);
    }

    /**
     * Générer une adresse
     */
    private function generateAddress(bool $isAbidjan): string
    {
        if ($isAbidjan) {
            $zone = $this->faker->randomElement($this->abidjaneZones);
            $street = $this->faker->randomElement(['Boulevard', 'Avenue', 'Rue', 'Voie']);
            $number = $this->faker->randomElement([
                'Lot ' . $this->faker->numberBetween(1, 200),
                'Hangar ' . $this->faker->randomElement(['A', 'B', 'C', 'D']),
                'Bâtiment ' . $this->faker->numberBetween(1, 50),
            ]);

            return "{$number}, {$street} {$this->faker->streetName}, {$zone}, Abidjan";
        }

        $city = $this->faker->randomElement($this->regionalCities);
        return 'Zone Industrielle, ' . $city;
    }

    /**
     * État pour un entrepôt principal
     */
    public function principal(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Entrepôt Principal ' .
                $this->faker->randomElement(['A', 'Central', '1']) . ' ' .
                strtoupper(Str::random(3)) . '-' . $this->faker->unique()->numberBetween(100, 999),
            'is_active' => true,
        ]);
    }

    /**
     * État pour un entrepôt inactif
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
