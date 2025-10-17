<?php

namespace Database\Factories;

use App\Models\Fournisseur;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fournisseur>
 */
class FournisseurFactory extends Factory
{
    protected $model = Fournisseur::class;

    /**
     * Villes principales de Côte d'Ivoire
     */
    private array $cities = [
        'Abidjan',
        'Yamoussoukro',
        'Bouaké',
        'Daloa',
        'San-Pédro',
        'Korhogo',
        'Man',
        'Gagnoa',
    ];

    /**
     * Types de fournisseurs
     */
    private array $supplierTypes = [
        'Importateur',
        'Grossiste',
        'Producteur Local',
        'Distributeur',
        'Fabricant',
    ];

    /**
     * Secteurs d'activité
     */
    private array $sectors = [
        'Agroalimentaire',
        'Boissons',
        'Produits Laitiers',
        'Épicerie',
        'Produits d\'Entretien',
        'Cosmétiques',
        'Import-Export',
    ];

    /**
     * Noms ivoiriens
     */
    private array $ivorianNames = [
        'Kouadio',
        'Kouassi',
        'Koffi',
        'Yao',
        'N\'Guessan',
        'Koné',
        'Coulibaly',
        'Traoré',
        'Ouattara',
        'Touré',
        'Bamba',
        'Diallo',
        'Sangaré',
        'Mamadou',
        'Ibrahim',
    ];

    /**
     * Conditions de paiement
     */
    private array $paymentTerms = [
        '30 jours fin de mois',
        '60 jours',
        '90 jours',
        'Comptant',
        '45 jours fin de mois',
        '15 jours',
    ];

    public function definition(): array
    {
        $city = $this->faker->randomElement($this->cities);
        $code = $this->generateSupplierCode();
        $companyName = $this->generateCompanyName();

        return [
            'fournisseur_id' => (string) Str::uuid(),
            'code' => $code,
            'name' => $companyName,
            'responsable' => $this->faker->randomElement($this->ivorianNames) . ' ' .
                $this->faker->randomElement($this->ivorianNames),
            'adresse' => $this->generateAddress($city),
            'city' => $city,
            'phone' => $this->generateIvorianPhone(),
            'email' => $this->generateEmail($companyName, $code),
            'payment_terms' => $this->faker->randomElement($this->paymentTerms),
            'is_active' => $this->faker->boolean(95), // 95% actifs
        ];
    }

    /**
     * Générer un nom d'entreprise fournisseur
     */
    private function generateCompanyName(): string
    {
        $types = [
            fn() => $this->faker->randomElement($this->supplierTypes) . ' ' .
                $this->faker->randomElement($this->ivorianNames),

            fn() => 'Société ' . $this->faker->randomElement($this->sectors) . ' ' .
                $this->faker->randomElement($this->ivorianNames),

            fn() => $this->faker->randomElement(['CI', 'Ivoire', 'Africaine']) . ' ' .
                $this->faker->randomElement($this->sectors),

            fn() => 'Ets ' . $this->faker->randomElement($this->ivorianNames) . ' & Co',

            fn() => 'Groupe ' . $this->faker->randomElement($this->ivorianNames) . ' Distribution',
        ];

        return $this->faker->randomElement($types)();
    }

    /**
     * Générer un code fournisseur unique
     */
    private function generateSupplierCode(): string
    {
        return 'FRS-' . strtoupper(Str::random(3)) . '-' .
            $this->faker->unique()->numberBetween(1000, 9999);
    }

    /**
     * Générer un numéro de téléphone ivoirien
     */
    private function generateIvorianPhone(): string
    {
        $operators = ['05', '07', '01', '40', '41', '42', '43', '44', '45'];
        $prefix = $this->faker->randomElement($operators);
        $rest = $this->faker->numerify('########');

        return '+225 ' . $prefix . ' ' . substr($rest, 0, 2) . ' ' .
            substr($rest, 2, 2) . ' ' . substr($rest, 4, 2) . ' ' .
            substr($rest, 6, 2);
    }

    /**
     * Générer une adresse
     */
    private function generateAddress(string $city): string
    {
        if ($city === 'Abidjan') {
            $communes = ['Cocody', 'Plateau', 'Marcory', 'Treichville', 'Koumassi', 'Adjamé'];
            $commune = $this->faker->randomElement($communes);
            return $this->faker->randomElement(['Boulevard', 'Avenue', 'Rue']) . ' ' .
                $this->faker->streetName . ', ' . $commune . ', Abidjan';
        }

        return 'Zone Commerciale, ' . $city;
    }

    /**
     * Générer un email unique
     */
    private function generateEmail(string $companyName, string $code): string
    {
        static $counter = 0;
        $counter++;

        $domain = Str::slug($companyName);
        $domain = Str::limit($domain, 12, '');
        $domain = trim($domain, '-');

        if (empty($domain)) {
            $domain = 'fournisseur' . $counter;
        }

        $uniquePart = strtolower(str_replace(['FRS-', '-'], '', $code));
        $formats = [
            "contact{$counter}@{$domain}.ci",
            "commercial.{$uniquePart}@{$domain}.com",
            "{$uniquePart}@{$domain}.ci",
            "info{$counter}@{$domain}.com",
        ];

        return $this->faker->randomElement($formats);
    }

    /**
     * État pour un fournisseur inactif
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
