<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * @group Gestion des Produits
 * 
 * APIs pour gérer les produits du système.
 * 
 * **Authentification requise**: Toutes les routes nécessitent un Bearer Token.
 * 
 * Pour obtenir un token, l'utilisateur doit d'abord s'authentifier via l'endpoint de connexion.
 * 
 * **Header requis pour toutes les requêtes:**
 * ```
 * Authorization: Bearer {votre_token}
 * Content-Type: application/json
 * Accept: application/json
 * ```
 * 
 * **Exemple de token:**
 * ```
 * Authorization: Bearer 1|abc123xyz456def789ghi012jkl345mno678pqr901stu234
 * ```
 */

class ProductController extends Controller
{
    /**
     * Lister tous les produits
     *
     * Récupère la liste complète de tous les produits avec leurs catégories associées.
     *
     * @group Gestion des Produits
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "product_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "code": "PRO-ABC123",
     *       "name": "Laptop Dell XPS 15",
     *       "description": "Ordinateur portable haute performance avec écran 15 pouces",
     *       "unit_price": 1500000.00,
     *       "cost": 1200000.00,
     *       "minimum_cost": 1000000.00,
     *       "min_stock_level": 5,
     *       "is_active": true,
     *       "picture": "laptop-dell-xps.jpg",
     *       "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "created_at": "2025-01-16T14:20:00.000000Z",
     *       "updated_at": "2025-01-16T14:20:00.000000Z",
     *       "deleted_at": null,
     *       "category": {
     *         "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *         "label": "Informatique",
     *         "description": "Équipements informatiques"
     *       }
     *     }
     *   ],
     *   "message": "Produits de la catégorie"
     * }
     * 
     * @response 200 scenario="Aucun produit dans la catégorie" {
     *   "data": [],
     *   "message": "Produits de la catégorie"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }2025-01-15T10:30:00.000000Z",
     *       "updated_at": "2025-01-15T10:30:00.000000Z",
     *       "deleted_at": null,
     *       "category": {
     *         "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *         "label": "Informatique",
     *         "description": "Équipements informatiques"
     *       }
     *     },
     *     {
     *       "product_id": "7d3e1c9b-2a4d-5e6f-7g8h-9i0j1k2l3m4n",
     *       "code": "PRO-XYZ789",
     *       "name": "Souris sans fil Logitech",
     *       "description": "Souris ergonomique sans fil",
     *       "unit_price": 25000.00,
     *       "cost": 18000.00,
     *       "minimum_cost": 15000.00,
     *       "min_stock_level": 20,
     *       "is_active": true,
     *       "picture": "souris-logitech.jpg",
     *       "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "created_at": "2025-01-16T14:20:00.000000Z",
     *       "updated_at": "2025-01-16T14:20:00.000000Z",
     *       "deleted_at": null,
     *       "category": {
     *         "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *         "label": "Informatique",
     *         "description": "Équipements informatiques"
     *       }
     *     }
     *   ],
     *   "message": "Liste des produits"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
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
     * Crée un nouveau produit dans le système. Le code produit est généré automatiquement 
     * si non fourni (format: PRO-XXXXXX où X est un caractère aléatoire).
     *
     * @group Gestion des Produits
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @bodyParam name string required Nom du produit (max 255 caractères, doit être unique). Example: "Laptop Dell XPS 15"
     * @bodyParam description string optional Description détaillée du produit. Example: "Ordinateur portable haute performance avec processeur Intel i7"
     * @bodyParam product_category_id string required UUID de la catégorie du produit (doit exister dans product_categories). Example: "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b"
     * @bodyParam unit_price numeric required Prix de vente unitaire (doit être >= 0). Example: 1500000.00
     * @bodyParam cost numeric optional Coût d'achat du produit (doit être >= 0). Example: 1200000.00
     * @bodyParam minimum_cost numeric optional Coût minimum acceptable (doit être >= 0). Example: 1000000.00
     * @bodyParam min_stock_level integer optional Quantité minimale en stock déclenchant une alerte (doit être >= 0). Example: 5
     * @bodyParam is_active boolean optional Indique si le produit est actif (par défaut: true). Example: true
     * @bodyParam picture string optional URL ou nom du fichier image (max 255 caractères). Example: "laptop-dell-xps.jpg"
     * @bodyParam image string optional Alternative pour l'image du produit. Example: "image.jpg"
     *
     * @response 201 scenario="Produit créé avec succès" {
     *   "data": {
     *     "product_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "code": "PRO-A7B9C2",
     *     "name": "Laptop Dell XPS 15",
     *     "description": "Ordinateur portable haute performance avec processeur Intel i7",
     *     "unit_price": 1500000.00,
     *     "cost": 1200000.00,
     *     "minimum_cost": 1000000.00,
     *     "min_stock_level": 5,
     *     "is_active": true,
     *     "picture": "laptop-dell-xps.jpg",
     *     "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null,
     *     "category": {
     *       "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "label": "Informatique",
     *       "description": "Équipements informatiques"
     *     }
     *   },
     *   "message": "Produit créé avec succès"
     * }
     *
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "name": [
     *       "Le nom du produit est obligatoire"
     *     ],
     *     "product_category_id": [
     *       "La catégorie est obligatoire"
     *     ],
     *     "unit_price": [
     *       "Le prix unitaire est obligatoire"
     *     ]
     *   }
     * }
     * 
     * @response 422 scenario="Nom de produit déjà existant" {
     *   "errors": {
     *     "name": [
     *       "Ce nom de produit existe déjà"
     *     ]
     *   }
     * }
     * 
     * @response 422 scenario="Catégorie invalide" {
     *   "errors": {
     *     "product_category_id": [
     *       "La catégorie sélectionnée n'existe pas"
     *     ]
     *   }
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
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
     * Récupère les détails complets d'un produit spécifique avec sa catégorie.
     *
     * @group Gestion des Produits
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du produit à afficher. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Succès" {
     *   "data": {
     *     "product_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "code": "PRO-ABC123",
     *     "name": "Laptop Dell XPS 15",
     *     "description": "Ordinateur portable haute performance",
     *     "unit_price": 1500000.00,
     *     "cost": 1200000.00,
     *     "minimum_cost": 1000000.00,
     *     "min_stock_level": 5,
     *     "is_active": true,
     *     "picture": "laptop-dell-xps.jpg",
     *     "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null,
     *     "category": {
     *       "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "label": "Informatique",
     *       "description": "Équipements informatiques"
     *     }
     *   },
     *   "message": "Détail du produit"
     * }
     * 
     * @response 404 scenario="Produit non trouvé" {
     *   "message": "No query results for model [App\\Models\\Product] 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
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
     * Met à jour les informations d'un produit existant. Tous les champs sont requis sauf indication contraire.
     * Le nom du produit doit rester unique (sauf pour le produit lui-même).
     *
     * @group Gestion des Produits
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du produit à mettre à jour. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @bodyParam name string required Nouveau nom du produit (max 255 caractères, doit être unique). Example: "Laptop Dell XPS 15 - Édition 2025"
     * @bodyParam description string optional Nouvelle description du produit. Example: "Ordinateur portable avec écran OLED"
     * @bodyParam product_category_id string required UUID de la catégorie (doit exister). Example: "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b"
     * @bodyParam unit_price numeric required Nouveau prix unitaire (>= 0). Example: 1600000.00
     * @bodyParam cost numeric optional Nouveau coût d'achat (>= 0). Example: 1300000.00
     * @bodyParam minimum_cost numeric optional Nouveau coût minimum (>= 0). Example: 1100000.00
     * @bodyParam min_stock_level integer optional Nouveau niveau de stock minimum (>= 0). Example: 3
     * @bodyParam is_active boolean optional Statut actif/inactif. Example: true
     * @bodyParam picture string optional Nouvelle image (max 255 caractères). Example: "laptop-dell-xps-2025.jpg"
     * @bodyParam image string optional Alternative pour l'image. Example: "image.jpg"
     * 
     * @response 200 scenario="Mise à jour réussie" {
     *   "data": {
     *     "product_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "code": "PRO-ABC123",
     *     "name": "Laptop Dell XPS 15 - Édition 2025",
     *     "description": "Ordinateur portable avec écran OLED",
     *     "unit_price": 1600000.00,
     *     "cost": 1300000.00,
     *     "minimum_cost": 1100000.00,
     *     "min_stock_level": 3,
     *     "is_active": true,
     *     "picture": "laptop-dell-xps-2025.jpg",
     *     "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-16T15:45:00.000000Z",
     *     "deleted_at": null,
     *     "category": {
     *       "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "label": "Informatique",
     *       "description": "Équipements informatiques"
     *     }
     *   },
     *   "message": "Produit mis à jour avec succès"
     * }
     * 
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "name": [
     *       "Ce nom de produit existe déjà"
     *     ],
     *     "unit_price": [
     *       "Le prix unitaire est obligatoire"
     *     ]
     *   }
     * }
     * 
     * @response 404 scenario="Produit non trouvé" {
     *   "message": "No query results for model [App\\Models\\Product]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
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
     * Effectue une suppression logique (soft delete) du produit. Le produit n'est pas supprimé 
     * de la base de données mais marqué comme supprimé. Il peut être restauré ultérieurement.
     *
     * @group Gestion des Produits
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du produit à supprimer. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Suppression réussie" {
     *   "message": "Produit supprimé avec succès"
     * }
     * 
     * @response 404 scenario="Produit non trouvé" {
     *   "message": "No query results for model [App\\Models\\Product]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
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
     * Restaure un produit qui a été supprimé logiquement (soft delete). 
     * Le produit redevient actif et visible dans les listes.
     *
     * @group Gestion des Produits
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du produit à restaurer. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Restauration réussie" {
     *   "data": {
     *     "product_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "code": "PRO-ABC123",
     *     "name": "Laptop Dell XPS 15",
     *     "description": "Ordinateur portable haute performance",
     *     "unit_price": 1500000.00,
     *     "cost": 1200000.00,
     *     "minimum_cost": 1000000.00,
     *     "min_stock_level": 5,
     *     "is_active": true,
     *     "picture": "laptop-dell-xps.jpg",
     *     "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-16T16:20:00.000000Z",
     *     "deleted_at": null
     *   },
     *   "message": "Produit restauré avec succès"
     * }
     * 
     * @response 404 scenario="Produit non trouvé" {
     *   "message": "No query results for model [App\\Models\\Product]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
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
     * Supprime définitivement un produit de la base de données (force delete). 
     * Cette action est irréversible. Le produit ne pourra plus être restauré.
     *
     * @group Gestion des Produits
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du produit à supprimer définitivement. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Suppression définitive réussie" {
     *   "message": "Produit supprimé définitivement"
     * }
     * 
     * @response 404 scenario="Produit non trouvé" {
     *   "message": "No query results for model [App\\Models\\Product]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
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