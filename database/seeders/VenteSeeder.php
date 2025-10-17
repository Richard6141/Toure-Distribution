<?php

namespace Database\Seeders;

use App\Models\Vente;
use App\Models\DetailVente;
use App\Models\Client;
use App\Models\Entrepot;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @param int $count Nombre de ventes à créer (par défaut 50)
     */
    public function run(int $count = 50): void
    {
        // Vérifications préalables
        $clientsCount = Client::where('is_active', true)->count();
        $entrepotsCount = Entrepot::where('is_active', true)->count();
        $productsCount = Product::where('is_active', true)->count();

        if ($clientsCount === 0) {
            $this->command->error('❌ Aucun client actif trouvé !');
            $this->command->info('💡 Veuillez d\'abord exécuter: php artisan db:seed --class=ClientSeeder');
            return;
        }

        if ($entrepotsCount === 0) {
            $this->command->warn('⚠️  Aucun entrepôt actif trouvé. Les ventes seront créées sans entrepôt source.');
        }

        if ($productsCount === 0) {
            $this->command->error('❌ Aucun produit actif trouvé !');
            $this->command->info('💡 Veuillez d\'abord exécuter: php artisan db:seed --class=ProductSeeder');
            return;
        }

        $this->command->info("🚀 Création de {$count} ventes...");

        // Créer des ventes livrées et payées (40%)
        $deliveredCount = (int) ($count * 0.40);
        $this->createVentesWithDetails($deliveredCount, 'delivered');
        $this->command->info("✅ {$deliveredCount} ventes livrées créées");

        // Créer des ventes en attente (30%)
        $pendingCount = (int) ($count * 0.30);
        $this->createVentesWithDetails($pendingCount, 'pending');
        $this->command->info("✅ {$pendingCount} ventes en attente créées");

        // Créer des ventes payées totalement (20%)
        $paidCount = (int) ($count * 0.20);
        $this->createVentesWithDetails($paidCount, 'fullyPaid');
        $this->command->info("✅ {$paidCount} ventes payées totalement créées");

        // Créer des ventes annulées (10%)
        $cancelledCount = $count - $deliveredCount - $pendingCount - $paidCount;
        if ($cancelledCount > 0) {
            $this->createVentesWithDetails($cancelledCount, 'cancelled');
            $this->command->info("✅ {$cancelledCount} ventes annulées créées");
        }

        $this->command->info("🎉 Total: {$count} ventes créées avec leurs détails !");

        // Afficher un résumé
        $this->displaySummary();
    }

    /**
     * Créer des ventes avec leurs détails
     */
    private function createVentesWithDetails(int $count, string $state = null): void
    {
        $products = Product::where('is_active', true)->get();

        for ($i = 0; $i < $count; $i++) {
            // Créer la vente avec l'état spécifié
            $venteFactory = Vente::factory();
            if ($state) {
                $venteFactory = $venteFactory->$state();
            }
            $vente = $venteFactory->create();

            // Nombre de lignes de détail (entre 1 et 10 produits par vente)
            $detailsCount = rand(1, 10);

            // Sélectionner des produits aléatoires uniques pour cette vente
            $selectedProducts = $products->random(min($detailsCount, $products->count()));

            $totalMontantHT = 0;
            $totalMontantTaxe = 0;
            $totalRemise = 0;

            foreach ($selectedProducts as $product) {
                // Créer le détail de vente
                $quantite = rand(1, 50);
                $prixUnitaire = $product->unit_price * (rand(90, 110) / 100);
                $remiseLigne = $prixUnitaire * $quantite * (rand(0, 10) / 100);
                $montantHT = ($prixUnitaire * $quantite) - $remiseLigne;
                $tauxTaxe = 18;
                $montantTaxe = $montantHT * ($tauxTaxe / 100);
                $montantTTC = $montantHT + $montantTaxe;

                DetailVente::create([
                    'detail_vente_id' => (string) Str::uuid(),
                    'vente_id' => $vente->vente_id,
                    'product_id' => $product->product_id,
                    'quantite' => $quantite,
                    'prix_unitaire' => round($prixUnitaire, 2),
                    'remise_ligne' => round($remiseLigne, 2),
                    'montant_ht' => round($montantHT, 2),
                    'taux_taxe' => $tauxTaxe,
                    'montant_taxe' => round($montantTaxe, 2),
                    'montant_ttc' => round($montantTTC, 2),
                ]);

                $totalMontantHT += $montantHT;
                $totalMontantTaxe += $montantTaxe;
                $totalRemise += $remiseLigne;
            }

            // Mettre à jour la vente avec les montants calculés
            $montantTotal = $totalMontantHT + $totalMontantTaxe;
            $montantNet = $montantTotal - $totalRemise;

            $vente->update([
                'montant_ht' => round($totalMontantHT, 2),
                'montant_taxe' => round($totalMontantTaxe, 2),
                'montant_total' => round($montantTotal, 2),
                'remise' => round($totalRemise, 2),
                'montant_net' => round($montantNet, 2),
            ]);
        }
    }

    /**
     * Afficher un résumé des ventes créées
     */
    private function displaySummary(): void
    {
        $this->command->info("\n📊 Résumé des ventes:");
        $this->command->info(str_repeat('-', 60));

        $statuses = [
            'en_attente' => 'En attente',
            'validee' => 'Validées',
            'en_cours_livraison' => 'En cours de livraison',
            'livree' => 'Livrées',
            'partiellement_livree' => 'Partiellement livrées',
            'annulee' => 'Annulées',
        ];

        foreach ($statuses as $key => $label) {
            $count = Vente::where('status', $key)->count();
            if ($count > 0) {
                $montantTotal = Vente::where('status', $key)->sum('montant_net');
                $this->command->info(sprintf(
                    "  %-25s : %3d ventes (%s FCFA)",
                    $label,
                    $count,
                    number_format($montantTotal, 0, ',', ' ')
                ));
            }
        }

        $this->command->info(str_repeat('-', 60));

        $totalVentes = Vente::count();
        $montantTotalGlobal = Vente::sum('montant_net');
        $this->command->info(sprintf(
            "  %-25s : %3d ventes (%s FCFA)",
            'TOTAL',
            $totalVentes,
            number_format($montantTotalGlobal, 0, ',', ' ')
        ));

        $this->command->info(str_repeat('-', 60));
    }
}
