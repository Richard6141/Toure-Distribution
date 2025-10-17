<?php

namespace Database\Factories;

use App\Models\DetailVente;
use App\Models\Vente;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailVente>
 */
class DetailVenteFactory extends Factory
{
    protected $model = DetailVente::class;

    public function definition(): array
    {
        $product = Product::where('is_active', true)->inRandomOrder()->first();

        if (!$product) {
            throw new \Exception('Aucun produit actif trouvé. Exécutez ProductSeeder d\'abord.');
        }

        // Quantité vendue
        $quantite = $this->faker->numberBetween(1, 100);

        // Prix unitaire (peut être différent du prix catalogue)
        $prixUnitaire = $product->unit_price * $this->faker->randomFloat(2, 0.9, 1.1);

        // Remise sur la ligne (0-10%)
        $remiseLigne = $prixUnitaire * $quantite * $this->faker->randomFloat(2, 0, 0.10);

        // Montant HT
        $montantHT = ($prixUnitaire * $quantite) - $remiseLigne;

        // Taux de taxe (TVA 18% en Côte d'Ivoire)
        $tauxTaxe = 18;
        $montantTaxe = $montantHT * ($tauxTaxe / 100);

        // Montant TTC
        $montantTTC = $montantHT + $montantTaxe;

        return [
            'detail_vente_id' => (string) Str::uuid(),
            'vente_id' => Vente::factory(), // Sera remplacé lors de l'utilisation
            'product_id' => $product->product_id,
            'quantite' => $quantite,
            'prix_unitaire' => round($prixUnitaire, 2),
            'remise_ligne' => round($remiseLigne, 2),
            'montant_ht' => round($montantHT, 2),
            'taux_taxe' => $tauxTaxe,
            'montant_taxe' => round($montantTaxe, 2),
            'montant_ttc' => round($montantTTC, 2),
        ];
    }

    /**
     * État pour une ligne sans remise
     */
    public function noDiscount(): static
    {
        return $this->state(function (array $attributes) {
            $montantHT = $attributes['prix_unitaire'] * $attributes['quantite'];
            $montantTaxe = $montantHT * ($attributes['taux_taxe'] / 100);

            return [
                'remise_ligne' => 0,
                'montant_ht' => round($montantHT, 2),
                'montant_taxe' => round($montantTaxe, 2),
                'montant_ttc' => round($montantHT + $montantTaxe, 2),
            ];
        });
    }

    /**
     * État pour une grande quantité
     */
    public function bulk(): static
    {
        return $this->state(function (array $attributes) {
            $quantite = $this->faker->numberBetween(100, 500);
            $prixUnitaire = $attributes['prix_unitaire'];
            $remiseLigne = $prixUnitaire * $quantite * 0.15; // 15% de remise en gros
            $montantHT = ($prixUnitaire * $quantite) - $remiseLigne;
            $montantTaxe = $montantHT * ($attributes['taux_taxe'] / 100);

            return [
                'quantite' => $quantite,
                'remise_ligne' => round($remiseLigne, 2),
                'montant_ht' => round($montantHT, 2),
                'montant_taxe' => round($montantTaxe, 2),
                'montant_ttc' => round($montantHT + $montantTaxe, 2),
            ];
        });
    }
}
