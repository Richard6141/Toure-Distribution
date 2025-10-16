<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'label' => 'Boissons',
                'description' => 'Boissons gazeuses, jus, eaux minérales'
            ],
            [
                'label' => 'Produits Laitiers',
                'description' => 'Lait, yaourts, fromages'
            ],
            [
                'label' => 'Épicerie Salée',
                'description' => 'Riz, pâtes, conserves, huiles'
            ],
            [
                'label' => 'Épicerie Sucrée',
                'description' => 'Biscuits, chocolats, confiseries'
            ],
            [
                'label' => 'Produits d\'Entretien',
                'description' => 'Détergents, savons, produits ménagers'
            ],
            [
                'label' => 'Hygiène & Beauté',
                'description' => 'Savons, shampoings, cosmétiques'
            ],
            [
                'label' => 'Céréales & Farines',
                'description' => 'Farine de blé, maïs, attiéké, gari'
            ],
            [
                'label' => 'Condiments & Épices',
                'description' => 'Cubes Maggi, piment, épices locales'
            ],
            [
                'label' => 'Produits Surgelés',
                'description' => 'Poissons, viandes, légumes surgelés'
            ],
            [
                'label' => 'Alcools & Bières',
                'description' => 'Bières locales et importées, vins, spiritueux'
            ],
            [
                'label' => 'Boulangerie & Pâtisserie',
                'description' => 'Pain, viennoiseries, gâteaux'
            ],
            [
                'label' => 'Conserves',
                'description' => 'Tomates, sardines, thon en conserve'
            ],
        ];

        $this->command->info('🚀 Création des catégories de produits...');

        foreach ($categories as $category) {
            ProductCategory::create([
                'product_category_id' => (string) Str::uuid(),
                'label' => $category['label'],
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ ' . count($categories) . ' catégories de produits créées avec succès !');
    }
}
