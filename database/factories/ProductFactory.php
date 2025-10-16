<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Produits par catégorie (contexte ivoirien)
     */
    private array $productsByCategory = [
        'Boissons' => [
            'Coca-Cola 33cl',
            'Coca-Cola 1L',
            'Fanta Orange 33cl',
            'Sprite 33cl',
            'Jus Tampico Orange 1L',
            'Jus Ki\'Or Ananas 1L',
            'Eau Awé 1.5L',
            'Eau Possotomé 1.5L',
            'Djino Cocktail 1L',
            'Malta Guinness 33cl',
            'Eku Power 33cl',
            'Vita Malt 33cl',
            'Top Grenadine 1L',
            'Jus Ananas 1L',
            'Bissap (Jus de Fleur d\'Hibiscus) 1L'
        ],
        'Produits Laitiers' => [
            'Lait Gloria 400g',
            'Lait Nido 900g',
            'Lait Nido 400g',
            'Lait Peak 400g',
            'Yaourt Yoplait Nature 125g',
            'Yaourt Yoplait Fraise 125g',
            'Yaourt Danone Vanille',
            'Fromage La Vache Qui Rit 200g',
            'Lait Condensé Nestlé 397g',
            'Lait Concentré Gloria 170g',
            'Crème Fraîche Elle & Vire 20cl'
        ],
        'Épicerie Salée' => [
            'Riz Parfumé Uncle Ben\'s 5kg',
            'Riz Basmati 5kg',
            'Riz Blanc Local 25kg',
            'Huile Dinor 5L',
            'Huile Jago 1L',
            'Pâtes Panzani 500g',
            'Spaghetti 500g',
            'Macaroni 500g',
            'Tomate Concentrée Gino 70g',
            'Tomate Concentrée 210g',
            'Sardines à l\'Huile 125g',
            'Thon à l\'Huile d\'Olive',
            'Sel fin 1kg',
            'Sucre en Morceaux 1kg',
            'Sucre en Poudre 1kg'
        ],
        'Épicerie Sucrée' => [
            'Biscuits Choco BN',
            'Biscuits Oro Saiwa',
            'Biscuits Prince',
            'Chocolat Milka 100g',
            'Chocolat Nestlé Dessert',
            'Bonbons Haribo',
            'Carambar',
            'Nutella 400g',
            'Confiture Bonne Maman',
            'Miel 500g'
        ],
        'Produits d\'Entretien' => [
            'Omo 400g',
            'Omo 900g',
            'Ariel 400g',
            'Bonux 400g',
            'Eau de Javel Lacroix 1L',
            'Liquide Vaisselle Mir 500ml',
            'Savon Marseille',
            'Jex 1L',
            'Cif Crème 500ml',
            'Ajax Multi-Surfaces 1L',
            'Désodorisant Air Wick'
        ],
        'Hygiène & Beauté' => [
            'Savon Lux 90g',
            'Savon Dove 90g',
            'Savon Cadum 90g',
            'Shampoing Sunsilk 200ml',
            'Shampoing Head & Shoulders',
            'Dentifrice Colgate 75ml',
            'Dentifrice Signal 75ml',
            'Gel Douche Dop 250ml',
            'Déodorant Nivea 150ml',
            'Vaseline Blue Seal 100g',
            'Crème Fair & White',
            'Lessive Corporelle Caresse',
            'Papier Toilette Moltonel'
        ],
        'Céréales & Farines' => [
            'Farine de Blé Type 55 1kg',
            'Farine Tania 1kg',
            'Attiéké Traditionnel 1kg',
            'Gari Blanc 1kg',
            'Semoule de Maïs 1kg',
            'Farine de Manioc 1kg',
            'Couscous Moyen 500g',
            'Corn Flakes Kellogg\'s',
            'Céréales Nestlé Fitness'
        ],
        'Condiments & Épices' => [
            'Maggi Cube 100 cubes',
            'Jumbo Cube 48 cubes',
            'Poivre Noir Moulu 50g',
            'Piment en Poudre 50g',
            'Curry en Poudre 50g',
            'Gingembre Moulu 50g',
            'Ail en Poudre 50g',
            'Noix de Muscade',
            'Sauce Soja 250ml',
            'Vinaigre Blanc 1L',
            'Moutarde Amora 265g',
            'Ketchup Heinz 570g',
            'Mayonnaise Amora 235g'
        ],
        'Produits Surgelés' => [
            'Poisson Tilapia Surgelé 1kg',
            'Crevettes Décortiquées 500g',
            'Poulet Entier Surgelé',
            'Ailes de Poulet 1kg',
            'Poisson Chat Surgelé',
            'Légumes Mélangés Surgelés 500g',
            'Frites Surgelées McCain 1kg'
        ],
        'Alcools & Bières' => [
            'Bière Flag 65cl',
            'Bière Ivoire 65cl',
            'Castel Beer 65cl',
            'Heineken 33cl',
            'Guinness 33cl',
            'Desperados 33cl',
            'Vin Rouge Bordeaux',
            'Champagne Moët & Chandon',
            'Whisky Johnnie Walker Red',
            'Vodka Smirnoff',
            'Gin Bombay Sapphire'
        ],
        'Boulangerie & Pâtisserie' => [
            'Pain de Mie 500g',
            'Pain Complet Tranché',
            'Croissants x6',
            'Pains au Chocolat x6',
            'Brioche Tranchée',
            'Cake aux Fruits'
        ],
        'Conserves' => [
            'Concentré de Tomate Gino 210g',
            'Sardines Marocaines 125g',
            'Thon Naturel 160g',
            'Petits Pois Extra-Fins 400g',
            'Haricots Verts 400g',
            'Macédoine de Légumes 400g',
            'Maïs Doux 340g',
            'Champignons Émincés 400g'
        ],
    ];

    /**
     * Marques populaires en Côte d'Ivoire
     */
    private array $brands = [
        'Nestlé',
        'Unilever',
        'Coca-Cola',
        'PepsiCo',
        'Danone',
        'Solibra',
        'Olam',
        'SIFCA',
        'Gino',
        'Uncle Ben\'s',
        'Tampico',
        'Ki\'Or',
        'Awé',
        'Possotomé',
        'Gloria'
    ];

    /**
     * Définir l'état par défaut du modèle
     */
    public function definition(): array
    {
        // Sélectionner une catégorie aléatoire
        $category = ProductCategory::inRandomOrder()->first();

        if (!$category) {
            throw new \Exception('Aucune catégorie de produit trouvée. Exécutez d\'abord ProductCategorySeeder.');
        }

        // Obtenir un nom de produit basé sur la catégorie
        $productName = $this->getProductNameForCategory($category->label);

        // Générer un code produit unique
        $code = $this->generateProductCode($category->label);

        // Prix réalistes pour le marché ivoirien (en FCFA)
        $unitPrice = $this->generatePriceForCategory($category->label);

        // Le coût est généralement 60-75% du prix de vente
        $cost = $unitPrice * $this->faker->randomFloat(2, 0.60, 0.75);

        // Le coût minimum est 90% du coût
        $minimumCost = $cost * 0.90;

        return [
            'product_id' => (string) Str::uuid(),
            'code' => $code,
            'name' => $productName,
            'description' => $this->generateDescription($productName),
            'product_category_id' => $category->product_category_id,
            'unit_price' => round($unitPrice, 2),
            'cost' => round($cost, 2),
            'minimum_cost' => round($minimumCost, 2),
            'min_stock_level' => $this->faker->numberBetween(10, 100),
            'is_active' => $this->faker->boolean(95), // 95% de produits actifs
            'picture' => null, // Peut être ajouté plus tard
        ];
    }

    /**
     * Obtenir un nom de produit pour une catégorie donnée
     */
    private function getProductNameForCategory(string $categoryLabel): string
    {
        if (isset($this->productsByCategory[$categoryLabel])) {
            $products = $this->productsByCategory[$categoryLabel];
            return $this->faker->randomElement($products);
        }

        // Produit générique si la catégorie n'est pas dans la liste
        return $this->faker->randomElement($this->brands) . ' ' .
            $categoryLabel . ' ' .
            $this->faker->numberBetween(100, 1000) . 'g';
    }

    /**
     * Générer un code produit unique
     */
    private function generateProductCode(string $categoryLabel): string
    {
        // Prendre les 3 premières lettres de la catégorie
        $prefix = strtoupper(substr(str_replace(' ', '', $categoryLabel), 0, 3));

        // Ajouter un nombre aléatoire unique
        $number = $this->faker->unique()->numberBetween(1000, 9999);

        return "PRD-{$prefix}-{$number}";
    }

    /**
     * Générer un prix réaliste selon la catégorie (en FCFA)
     */
    private function generatePriceForCategory(string $categoryLabel): float
    {
        $priceRanges = [
            'Boissons' => [300, 1500],
            'Produits Laitiers' => [500, 3000],
            'Épicerie Salée' => [200, 15000],
            'Épicerie Sucrée' => [200, 2500],
            'Produits d\'Entretien' => [300, 5000],
            'Hygiène & Beauté' => [250, 4000],
            'Céréales & Farines' => [400, 8000],
            'Condiments & Épices' => [150, 2000],
            'Produits Surgelés' => [2000, 15000],
            'Alcools & Bières' => [500, 50000],
            'Boulangerie & Pâtisserie' => [200, 3000],
            'Conserves' => [300, 2500],
        ];

        if (isset($priceRanges[$categoryLabel])) {
            [$min, $max] = $priceRanges[$categoryLabel];
            return $this->faker->numberBetween($min, $max);
        }

        // Prix par défaut
        return $this->faker->numberBetween(500, 5000);
    }

    /**
     * Générer une description pour un produit
     */
    private function generateDescription(string $productName): string
    {
        $descriptions = [
            "Produit de qualité supérieure - {$productName}",
            "{$productName} - Disponible en stock",
            "Excellence garantie - {$productName}",
            "{$productName} - Marque de confiance",
            "Produit authentique - {$productName}",
        ];

        return $this->faker->randomElement($descriptions);
    }

    /**
     * État pour un produit en promotion
     */
    public function onPromotion(): static
    {
        return $this->state(fn(array $attributes) => [
            'unit_price' => $attributes['unit_price'] * 0.85, // 15% de réduction
        ]);
    }

    /**
     * État pour un produit inactif
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * État pour un produit premium
     */
    public function premium(): static
    {
        return $this->state(fn(array $attributes) => [
            'unit_price' => $attributes['unit_price'] * 1.5,
            'cost' => $attributes['cost'] * 1.3,
        ]);
    }
}
