<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

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
        'Divo',
        'Abengourou',
        'Grand-Bassam',
        'Dimbokro',
        'Bondoukou',
        'Odienné',
        'Séguéla',
        'Soubré',
        'Sassandra',
        'Adzopé',
        'Dabou',
        'Agboville'
    ];

    /**
     * Communes d'Abidjan
     */
    private array $abidjaneCommunes = [
        'Cocody',
        'Plateau',
        'Marcory',
        'Treichville',
        'Koumassi',
        'Adjamé',
        'Abobo',
        'Yopougon',
        'Attécoubé',
        'Port-Bouët'
    ];

    /**
     * Types d'entreprises en Côte d'Ivoire
     */
    private array $companyTypes = [
        'SARL',
        'SA',
        'SAS',
        'EURL',
        'GIE',
        'SCI',
        'Entreprise Individuelle'
    ];

    /**
     * Secteurs d'activité
     */
    private array $sectors = [
        'Distribution',
        'Import-Export',
        'Commerce Général',
        'Restauration',
        'Hôtellerie',
        'Transport',
        'Agriculture',
        'BTP',
        'Services',
        'Technologie',
        'Pharmacie',
        'Textile',
        'Agroalimentaire',
        'Logistique'
    ];

    /**
     * Prénoms ivoiriens courants
     */
    private array $ivorianFirstNames = [
        'Kouadio',
        'Kouassi',
        'Koffi',
        'Yao',
        'N\'Guessan',
        'Adjoua',
        'Akissi',
        'Aya',
        'Amenan',
        'Affoué',
        'Mamadou',
        'Ibrahim',
        'Abdoulaye',
        'Issouf',
        'Fatoumata',
        'Oumar',
        'Seydou',
        'Bakary',
        'Moussa',
        'Adama',
        'Jean',
        'Marie',
        'Paul',
        'Pierre',
        'Jacques',
        'Aminata',
        'Mariam',
        'Aïssatou',
        'Kadiatou',
        'Hawa'
    ];

    /**
     * Noms de famille ivoiriens courants
     */
    private array $ivorianLastNames = [
        'Koné',
        'Coulibaly',
        'Traoré',
        'Ouattara',
        'Touré',
        'Bamba',
        'Diallo',
        'Sangaré',
        'Diabaté',
        'Soro',
        'N\'Dri',
        'Brou',
        'Kouamé',
        'Yeboah',
        'Gnabro',
        'Diaby',
        'Doumbia',
        'Fofana',
        'Camara',
        'Konaté',
        'Silué',
        'Beugré',
        'Tiémoko',
        'Bi',
        'N\'Goran'
    ];

    /**
     * Définir l'état par défaut du modèle
     */
    public function definition(): array
    {
        $city = $this->faker->randomElement($this->cities);
        $isAbidjan = $city === 'Abidjan';

        // Générer un code client unique
        $code = $this->generateClientCode();

        // Générer un nom d'entreprise réaliste
        $companyName = $this->generateCompanyName();

        // Générer un représentant avec nom ivoirien
        $firstName = $this->faker->randomElement($this->ivorianFirstNames);
        $lastName = $this->faker->randomElement($this->ivorianLastNames);
        $representant = $firstName . ' ' . $lastName;

        // Téléphone ivoirien (format depuis 2021: +225 XXXXXXXXXX)
        $phone = $this->generateIvorianPhone();

        // Email UNIQUE - Utiliser le code client pour garantir l'unicité
        $email = $this->generateEmail($companyName, $code);

        // IFU (Identifiant Fiscal Unique) - format: CI-ABJ-2024-X-XXXXX
        $ifu = $this->generateIFU($city);

        // Adresse
        $adresse = $this->generateAddress($city, $isAbidjan);

        return [
            'client_id' => (string) Str::uuid(),
            'code' => $code,
            'name_client' => $companyName,
            'name_representant' => $representant,
            'marketteur' => $this->faker->optional(0.7)->randomElement([
                'Kouakou Michel',
                'N\'Guessan Josée',
                'Traoré Seydou',
                'Bamba Sylvie',
                'Koné Amadou'
            ]),
            'client_type_id' => ClientType::inRandomOrder()->first()?->client_type_id ?? null,
            'adresse' => $adresse,
            'city' => $city,
            'email' => $email,
            'ifu' => $ifu,
            'phonenumber' => $phone,
            'credit_limit' => $this->faker->randomElement([
                0,
                500000,
                1000000,
                2000000,
                5000000,
                10000000
            ]),
            'current_balance' => $this->faker->numberBetween(0, 500000),
            'base_reduction' => $this->faker->randomFloat(2, 0, 15), // Réduction de 0 à 15%
            'is_active' => $this->faker->boolean(90), // 90% de clients actifs
        ];
    }

    /**
     * Générer un nom d'entreprise ivoirien
     */
    private function generateCompanyName(): string
    {
        $types = [
            // Noms avec secteur
            fn() => $this->faker->randomElement($this->sectors) . ' ' .
                $this->faker->randomElement($this->ivorianLastNames) . ' ' .
                $this->faker->randomElement($this->companyTypes),

            // Noms avec préfixe géographique
            fn() => $this->faker->randomElement(['Ivoire', 'CI', 'Abidjan', 'Africaine', 'Ouest']) . ' ' .
                $this->faker->randomElement($this->sectors) . ' ' .
                $this->faker->randomElement($this->companyTypes),

            // Noms avec nom de famille
            fn() => 'Ets ' . $this->faker->randomElement($this->ivorianLastNames) . ' & Fils',

            // Noms modernes
            fn() => $this->faker->randomElement(['Eco', 'Pro', 'Best', 'Top', 'Elite']) .
                $this->faker->randomElement(['Trade', 'Dist', 'Services', 'Logistics', 'Solutions']) . ' CI',

            // Noms traditionnels
            fn() => 'Groupe ' . $this->faker->randomElement($this->ivorianLastNames),
        ];

        return $this->faker->randomElement($types)();
    }

    /**
     * Générer un code client unique
     */
    private function generateClientCode(): string
    {
        return 'CLI-' . strtoupper(Str::random(3)) . '-' . $this->faker->unique()->numberBetween(1000, 9999);
    }

    /**
     * Générer un numéro de téléphone ivoirien
     */
    private function generateIvorianPhone(): string
    {
        // Format depuis 2021: +225 XX XX XX XX XX (10 chiffres)
        // Opérateurs: MTN (05, 07), Orange (01, 07), Moov (40-49)

        $operators = [
            '05',
            '07', // MTN
            '01',
            '07', // Orange
            '40',
            '41',
            '42',
            '43',
            '44',
            '45',
            '46',
            '47',
            '48',
            '49' // Moov
        ];

        $prefix = $this->faker->randomElement($operators);
        $rest = $this->faker->numerify('########'); // 8 chiffres restants

        return '+225 ' . $prefix . ' ' . substr($rest, 0, 2) . ' ' .
            substr($rest, 2, 2) . ' ' . substr($rest, 4, 2) . ' ' . substr($rest, 6, 2);
    }

    /**
     * Générer un email UNIQUE garanti
     * Utilise plusieurs stratégies pour éviter les doublons
     */
    private function generateEmail(string $companyName, string $code): string
    {
        // Compteur statique pour garantir l'unicité
        static $counter = 0;
        $counter++;

        // Nettoyer le nom de l'entreprise
        $domain = Str::slug($companyName);
        $domain = Str::limit($domain, 12, '');
        $domain = trim($domain, '-');

        // Si le domain est vide après nettoyage, utiliser un nom générique
        if (empty($domain)) {
            $domain = 'entreprise' . $counter;
        }

        // Extraire une partie unique du code client (ex: CLI-ABC-1234 => abc1234)
        $uniquePart = strtolower(str_replace(['CLI-', '-'], '', $code));

        // Suffixe aléatoire supplémentaire
        $randomSuffix = strtolower(Str::random(3));

        // Timestamp pour encore plus d'unicité
        $timestamp = substr(time(), -4);

        // Plusieurs formats d'email avec différentes combinaisons
        $formats = [
            "contact{$counter}@{$domain}.ci",
            "info.{$uniquePart}@{$domain}.ci",
            "commercial.{$randomSuffix}@{$domain}.com",
            "{$uniquePart}@{$domain}.ci",
            "direction.{$counter}.{$randomSuffix}@{$domain}.com",
            "admin{$uniquePart}@{$domain}.net",
            "{$domain}.{$timestamp}@gmail.com",
            "contact.{$uniquePart}.{$randomSuffix}@{$domain}.ci",
            "{$uniquePart}{$counter}@{$domain}.com",
            "info{$timestamp}@{$domain}.ci",
        ];

        return $this->faker->randomElement($formats);
    }

    /**
     * Générer un IFU (Identifiant Fiscal Unique)
     */
    private function generateIFU(string $city): string
    {
        $cityCode = strtoupper(substr($city, 0, 3));
        $year = $this->faker->numberBetween(2015, 2025);
        $category = $this->faker->randomElement(['A', 'B', 'C', 'M']);
        $number = $this->faker->numerify('#####');

        return "CI-{$cityCode}-{$year}-{$category}-{$number}";
    }

    /**
     * Générer une adresse
     */
    private function generateAddress(string $city, bool $isAbidjan): string
    {
        if ($isAbidjan) {
            $commune = $this->faker->randomElement($this->abidjaneCommunes);
            $street = $this->faker->randomElement([
                'Boulevard',
                'Avenue',
                'Rue',
                'Route',
                'Voie'
            ]);
            $number = $this->faker->randomElement([
                'Lot ' . $this->faker->numberBetween(1, 500),
                'Immeuble ' . $this->faker->lastName,
                'Villa ' . $this->faker->numberBetween(1, 200),
                $this->faker->buildingNumber
            ]);

            return "{$number}, {$street} de {$this->faker->streetName}, {$commune}, Abidjan";
        } else {
            return $this->faker->randomElement([
                'Quartier ' . $this->faker->streetName,
                'Zone Commerciale',
                'Centre-ville',
                'Carrefour ' . $this->faker->lastName
            ]) . ', ' . $city;
        }
    }

    /**
     * État pour un client VIP
     */
    public function vip(): static
    {
        return $this->state(fn(array $attributes) => [
            'credit_limit' => $this->faker->numberBetween(10000000, 50000000),
            'base_reduction' => $this->faker->randomFloat(2, 10, 25),
            'is_active' => true,
        ]);
    }

    /**
     * État pour un client inactif
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
            'current_balance' => 0,
        ]);
    }
}
