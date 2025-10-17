<?php

namespace Database\Factories;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Entrepot;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vente>
 */
class VenteFactory extends Factory
{
    protected $model = Vente::class;

    /**
     * Statuts possibles
     */
    private array $statuses = [
        'en_attente',
        'validee',
        'en_cours_livraison',
        'livree',
        'partiellement_livree',
    ];

    /**
     * Statuts de paiement
     */
    private array $paymentStatuses = [
        'non_paye',
        'paye_partiellement',
        'paye_totalement',
    ];

    public function definition(): array
    {
        $dateVente = $this->faker->dateTimeBetween('-6 months', 'now');
        $status = $this->faker->randomElement($this->statuses);
        $paymentStatus = $this->faker->randomElement($this->paymentStatuses);

        // Générer les montants
        $montantHT = $this->faker->randomFloat(2, 50000, 5000000);
        $tauxTaxe = 18; // TVA en Côte d'Ivoire
        $montantTaxe = $montantHT * ($tauxTaxe / 100);
        $montantTotal = $montantHT + $montantTaxe;

        // Remise aléatoire (0-15%)
        $remise = $montantTotal * $this->faker->randomFloat(2, 0, 0.15);
        $montantNet = $montantTotal - $remise;

        return [
            'vente_id' => (string) Str::uuid(),
            'numero_vente' => $this->generateVenteNumber($dateVente),
            'client_id' => Client::where('is_active', true)->inRandomOrder()->first()?->client_id
                ?? Client::factory()->create()->client_id,
            'entrepot_id' => Entrepot::where('is_active', true)->inRandomOrder()->first()?->entrepot_id
                ?? null,
            'date_vente' => $dateVente,
            'montant_ht' => round($montantHT, 2),
            'montant_taxe' => round($montantTaxe, 2),
            'montant_total' => round($montantTotal, 2),
            'remise' => round($remise, 2),
            'montant_net' => round($montantNet, 2),
            'status' => $status,
            'statut_paiement' => $paymentStatus,
            'note' => $this->faker->optional(0.3)->sentence(),
            'stock_movement_id' => null, // Sera défini lors de la création du mouvement de stock
        ];
    }

    /**
     * Générer un numéro de vente unique
     */
    private function generateVenteNumber($date): string
    {
        static $counter = 0;
        $counter++;

        $year = $date->format('Y');
        $number = str_pad($counter, 4, '0', STR_PAD_LEFT);

        return "VTE-{$year}-{$number}";
    }

    /**
     * État pour une vente validée et livrée
     */
    public function delivered(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'livree',
            'statut_paiement' => $this->faker->randomElement(['paye_totalement', 'paye_partiellement']),
        ]);
    }

    /**
     * État pour une vente en attente
     */
    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'en_attente',
            'statut_paiement' => 'non_paye',
        ]);
    }

    /**
     * État pour une vente payée totalement
     */
    public function fullyPaid(): static
    {
        return $this->state(fn(array $attributes) => [
            'statut_paiement' => 'paye_totalement',
            'status' => $this->faker->randomElement(['validee', 'livree']),
        ]);
    }

    /**
     * État pour une vente annulée
     */
    public function cancelled(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'annulee',
            'statut_paiement' => 'non_paye',
        ]);
    }
}
