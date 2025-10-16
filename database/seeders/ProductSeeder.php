<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @param int $count Nombre de produits à créer (par défaut 200)
     */
    public function run(int $count = 200): void
    {
        // Vérifier que les catégories existent
        $categoriesCount = ProductCategory::count();

        if ($categoriesCount === 0) {
            $this->command->error('❌ Aucune catégorie de produit trouvée !');
            $this->command->info('💡 Veuillez d\'abord exécuter: php artisan db:seed --class=ProductCategorySeeder');
            return;
        }

        $this->command->info("🚀 Création de {$count} produits ivoiriens...");
        $this->command->info("📦 {$categoriesCount} catégories disponibles");

        // Créer des produits normaux (80%)
        $normalCount = (int) ($count * 0.80);
        Product::factory($normalCount)->create();
        $this->command->info("✅ {$normalCount} produits normaux créés");

        // Créer des produits premium (12%)
        $premiumCount = (int) ($count * 0.12);
        Product::factory($premiumCount)->premium()->create();
        $this->command->info("✅ {$premiumCount} produits premium créés");

        // Créer des produits en promotion (5%)
        $promoCount = (int) ($count * 0.05);
        Product::factory($promoCount)->onPromotion()->create();
        $this->command->info("✅ {$promoCount} produits en promotion créés");

        // Créer des produits inactifs (3%)
        $inactiveCount = $count - $normalCount - $premiumCount - $promoCount;
        Product::factory($inactiveCount)->inactive()->create();
        $this->command->info("✅ {$inactiveCount} produits inactifs créés");

        $this->command->info("🎉 Total: {$count} produits créés avec succès !");

        // Afficher un résumé par catégorie
        $this->displayCategorySummary();
    }

    /**
     * Afficher un résumé des produits par catégorie
     */
    private function displayCategorySummary(): void
    {
        $this->command->info("\n📊 Résumé par catégorie:");
        $this->command->info(str_repeat('-', 60));

        $categories = ProductCategory::withCount('products')->get();

        foreach ($categories as $category) {
            $this->command->info(sprintf(
                "  %-30s : %3d produits",
                $category->label,
                $category->products_count
            ));
        }

        $this->command->info(str_repeat('-', 60));
    }
}
