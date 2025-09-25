<?php

namespace App\Http\Controllers;

use Str;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Lister tous les produits
     *
     * @group Produits
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "product_id": "uuid",
     *       "code": "PRO-ABC123",
     *       "name": "Produit Exemple",
     *       "description": "Description du produit",
     *       "unit_price": 1500.50,
     *       "cost": 1200,
     *       "minimum_cost": 1000,
     *       "min_stock_level": 10,
     *       "is_active": true,
     *       "picture": "image.jpg",
     *       "product_category_id": "uuid",
     *       "category": {
     *         "product_category_id": "uuid",
     *         "label": "Catégorie Exemple"
     *       }
     *     }
     *   ],
     *   "message": "Liste des produits"
     * }
     */
    public function index(): JsonResponse
    {
        $products = Product::with('category')->get();
        return response()->json([
            'data' => $products,
            'message' => 'Liste des produits'
        ]);
    }

    /**
     * Créer un nouveau produit
     *
     * @group Produits
     *
     * @bodyParam name string required Nom du produit. Exemple: "Produit Exemple"
     * @bodyParam description string Description du produit. Exemple: "Description du produit"
     * @bodyParam product_category_id uuid required ID de la catégorie. Exemple: "uuid"
     * @bodyParam unit_price numeric required Prix unitaire. Exemple: 1500.50
     * @bodyParam cost numeric Coût du produit. Exemple: 1200
     * @bodyParam minimum_cost numeric Coût minimum. Exemple: 1000
     * @bodyParam min_stock_level integer Quantité minimale en stock. Exemple: 10
     * @bodyParam is_active boolean Produit actif ou non. Exemple: true
     * @bodyParam picture string URL ou nom de l'image. Exemple: "image.jpg"
     *
     * @response 201 {
     *   "data": {
     *     "product_id": "uuid",
     *     "code": "PRO-ABC123",
     *     "name": "Produit Exemple",
     *     "description": "Description du produit",
     *     "unit_price": 1500.50,
     *     "cost": 1200,
     *     "minimum_cost": 1000,
     *     "min_stock_level": 10,
     *     "is_active": true,
     *     "picture": "image.jpg",
     *     "product_category_id": "uuid",
     *     "category": {
     *       "product_category_id": "uuid",
     *       "label": "Catégorie Exemple"
     *     }
     *   },
     *   "message": "Produit créé avec succès"
     * }
     *
     * @response 422 {
     *   "message": "Les données sont invalides",
     *   "errors": {
     *     "name": ["Le nom du produit est obligatoire", "Ce nom existe déjà"],
     *     "product_category_id": ["La catégorie est obligatoire"]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        // Règles de validation
        $rules = [
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'product_category_id' => 'required|uuid|exists:product_categories,product_category_id',
            'unit_price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'minimum_cost' => 'nullable|numeric|min:0',
            'min_stock_level' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'picture' => 'nullable|string|max:255',
        ];

        // Messages personnalisés
        $messages = [
            'name.required' => 'Le nom du produit est obligatoire',
            'name.unique' => 'Ce nom de produit existe déjà',
            'product_category_id.required' => 'La catégorie est obligatoire',
            'product_category_id.exists' => 'La catégorie sélectionnée n\'existe pas',
            'unit_price.required' => 'Le prix unitaire est obligatoire',
        ];

        // Validation
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si validation échoue
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        // Génération automatique du code si absent
        if (!isset($validated['code'])) {
            $validated['code'] = 'PRO-' . strtoupper(Str::random(6));
        }

        // Création du produit
        $product = Product::create($validated);
        $product->load('category');

        return response()->json([
            'data' => $product,
            'message' => 'Produit créé avec succès'
        ], 201);
    }



    /**
     * Afficher un produit par ID
     *
     * @group Produits
     */
    public function show(string $id): JsonResponse
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json([
            'data' => $product,
            'message' => 'Détail du produit'
        ]);
    }

    /**
     * Mettre à jour un produit
     *
     * @group Produits
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        // Règles de validation
        $rules = [
            'name' => 'required|string|max:255|unique:products,name,' . $product->product_id . ',product_id',
            'description' => 'nullable|string',
            'product_category_id' => 'required|uuid|exists:product_categories,product_category_id',
            'unit_price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'minimum_cost' => 'nullable|numeric|min:0',
            'min_stock_level' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'picture' => 'nullable|string|max:255',
        ];

        // Messages personnalisés
        $messages = [
            'name.required' => 'Le nom du produit est obligatoire',
            'name.unique' => 'Ce nom de produit existe déjà',
            'product_category_id.required' => 'La catégorie est obligatoire',
            'product_category_id.exists' => 'La catégorie sélectionnée n\'existe pas',
            'unit_price.required' => 'Le prix unitaire est obligatoire',
        ];

        // Validation
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        // Mise à jour
        $product->update($validated);
        $product->load('category');

        return response()->json([
            'data' => $product,
            'message' => 'Produit mis à jour avec succès'
        ], 200);
    }


    /**
     * Supprimer un produit (soft delete)
     *
     * @group Produits
     */
    public function destroy(string $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Produit supprimé avec succès'
        ]);
    }

    /**
     * Restaurer un produit supprimé
     *
     * @group Produits
     */
    public function restore(string $id): JsonResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return response()->json([
            'data' => $product,
            'message' => 'Produit restauré avec succès'
        ]);
    }

    /**
     * Supprimer définitivement un produit
     *
     * @group Produits
     */
    public function forceDelete(string $id): JsonResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();

        return response()->json([
            'message' => 'Produit supprimé définitivement'
        ]);
    }

    /**
     * Lister les produits par catégorie
     *
     * @group Produits
     */
    public function byCategory(string $categoryId): JsonResponse
    {
        $products = Product::with('category')
            ->where('product_category_id', $categoryId)
            ->get();

        return response()->json([
            'data' => $products,
            'message' => 'Produits de la catégorie'
        ]);
    }
}
