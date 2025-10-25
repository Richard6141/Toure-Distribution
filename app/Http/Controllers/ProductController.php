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
     *       "name": "Ciment Portland",
     *       "description": "Ciment de qualité supérieure pour construction",
     *       "unit_price": 45000.00,
     *       "unit_of_measure": "sac",
     *       "unit_weight": 50.0000,
     *       "cost": 35000.00,
     *       "minimum_cost": 30000.00,
     *       "min_stock_level": 100,
     *       "is_active": true,
     *       "picture": "ciment-portland.jpg",
     *       "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "created_at": "2025-01-15T10:30:00.000000Z",
     *       "updated_at": "2025-01-15T10:30:00.000000Z",
     *       "deleted_at": null,
     *       "category": {
     *         "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *         "label": "Matériaux de construction",
     *         "description": "Matériaux pour le bâtiment"
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
     * @bodyParam name string required Nom du produit (max 255 caractères, doit être unique). Example: "Ciment Portland"
     * @bodyParam description string optional Description détaillée du produit. Example: "Ciment de qualité supérieure pour construction"
     * @bodyParam product_category_id string required UUID de la catégorie du produit (doit exister dans product_categories). Example: "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b"
     * @bodyParam unit_price numeric required Prix de vente unitaire (doit être >= 0). Example: 45000.00
     * @bodyParam unit_of_measure string optional Unité de mesure (kg, t, l, pcs, sac, m, m², m³, etc.). Example: "sac"
     * @bodyParam unit_weight numeric optional Poids unitaire en kilogrammes pour le calcul du tonnage. Example: 50.0000
     * @bodyParam cost numeric optional Coût d'achat du produit (doit être >= 0). Example: 35000.00
     * @bodyParam minimum_cost numeric optional Coût minimum acceptable (doit être >= 0). Example: 30000.00
     * @bodyParam min_stock_level integer optional Quantité minimale en stock déclenchant une alerte (doit être >= 0). Example: 100
     * @bodyParam is_active boolean optional Indique si le produit est actif (par défaut: true). Example: true
     * @bodyParam picture string optional URL ou nom du fichier image (max 255 caractères). Example: "ciment-portland.jpg"
     * @bodyParam image string optional Alternative pour l'image du produit. Example: "image.jpg"
     *
     * @response 201 scenario="Produit créé avec succès" {
     *   "data": {
     *     "product_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "code": "PRO-A7B9C2",
     *     "name": "Ciment Portland",
     *     "description": "Ciment de qualité supérieure pour construction",
     *     "unit_price": 45000.00,
     *     "unit_of_measure": "sac",
     *     "unit_weight": 50.0000,
     *     "cost": 35000.00,
     *     "minimum_cost": 30000.00,
     *     "min_stock_level": 100,
     *     "is_active": true,
     *     "picture": "ciment-portland.jpg",
     *     "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null,
     *     "category": {
     *       "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "label": "Matériaux de construction",
     *       "description": "Matériaux pour le bâtiment"
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
            'unit_of_measure' => 'nullable|string|max:20',
            'unit_weight' => 'nullable|numeric|min:0',
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
            'unit_of_measure.max' => 'L\'unité de mesure ne doit pas dépasser 20 caractères',
            'unit_weight.numeric' => 'Le poids unitaire doit être un nombre',
            'unit_weight.min' => 'Le poids unitaire doit être positif',
        ];

        // Validation
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        // Gérer le champ 'image' comme alias de 'picture'
        if ($request->has('image') && !$request->has('picture')) {
            $validated['picture'] = $request->input('image');
        }

        // Créer le produit
        $product = Product::create($validated);
        $product->load('category');

        return response()->json([
            'data' => $product,
            'message' => 'Produit créé avec succès'
        ], 201);
    }

    /**
     * Afficher un produit spécifique
     *
     * Récupère les détails complets d'un produit spécifique avec sa catégorie associée.
     *
     * @group Gestion des Produits
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du produit. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     *
     * @response 200 scenario="Produit trouvé" {
     *   "data": {
     *     "product_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "code": "PRO-ABC123",
     *     "name": "Ciment Portland",
     *     "description": "Ciment de qualité supérieure pour construction",
     *     "unit_price": 45000.00,
     *     "unit_of_measure": "sac",
     *     "unit_weight": 50.0000,
     *     "cost": 35000.00,
     *     "minimum_cost": 30000.00,
     *     "min_stock_level": 100,
     *     "is_active": true,
     *     "picture": "ciment-portland.jpg",
     *     "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null,
     *     "category": {
     *       "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "label": "Matériaux de construction",
     *       "description": "Matériaux pour le bâtiment"
     *     }
     *   },
     *   "message": "Détails du produit"
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
    public function show(string $id): JsonResponse
    {
        $product = Product::with('category')->findOrFail($id);

        return response()->json([
            'data' => $product,
            'message' => 'Détails du produit'
        ]);
    }

    /**
     * Mettre à jour un produit
     *
     * Met à jour les informations d'un produit existant. Le nom du produit doit rester unique.
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
     * @bodyParam name string required Nom du produit (max 255 caractères, doit être unique). Example: "Ciment Portland Premium"
     * @bodyParam description string optional Description détaillée du produit. Example: "Ciment de qualité supérieure renforcé"
     * @bodyParam product_category_id string required UUID de la catégorie du produit. Example: "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b"
     * @bodyParam unit_price numeric required Prix de vente unitaire (>= 0). Example: 48000.00
     * @bodyParam unit_of_measure string optional Unité de mesure. Example: "sac"
     * @bodyParam unit_weight numeric optional Poids unitaire en kg. Example: 50.0000
     * @bodyParam cost numeric optional Coût d'achat (>= 0). Example: 38000.00
     * @bodyParam minimum_cost numeric optional Coût minimum (>= 0). Example: 32000.00
     * @bodyParam min_stock_level integer optional Quantité minimale en stock (>= 0). Example: 80
     * @bodyParam is_active boolean optional Statut actif du produit. Example: true
     * @bodyParam picture string optional URL ou nom du fichier image (max 255 caractères). Example: "ciment-premium.jpg"
     *
     * @response 200 scenario="Mise à jour réussie" {
     *   "data": {
     *     "product_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "code": "PRO-ABC123",
     *     "name": "Ciment Portland Premium",
     *     "description": "Ciment de qualité supérieure renforcé",
     *     "unit_price": 48000.00,
     *     "unit_of_measure": "sac",
     *     "unit_weight": 50.0000,
     *     "cost": 38000.00,
     *     "minimum_cost": 32000.00,
     *     "min_stock_level": 80,
     *     "is_active": true,
     *     "picture": "ciment-premium.jpg",
     *     "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-16T15:45:00.000000Z",
     *     "deleted_at": null,
     *     "category": {
     *       "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "label": "Matériaux de construction",
     *       "description": "Matériaux pour le bâtiment"
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
            'unit_of_measure' => 'nullable|string|max:20',
            'unit_weight' => 'nullable|numeric|min:0',
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
            'unit_of_measure.max' => 'L\'unité de mesure ne doit pas dépasser 20 caractères',
            'unit_weight.numeric' => 'Le poids unitaire doit être un nombre',
            'unit_weight.min' => 'Le poids unitaire doit être positif',
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
     *     "name": "Ciment Portland",
     *     "description": "Ciment de qualité supérieure",
     *     "unit_price": 45000.00,
     *     "unit_of_measure": "sac",
     *     "unit_weight": 50.0000,
     *     "cost": 35000.00,
     *     "minimum_cost": 30000.00,
     *     "min_stock_level": 100,
     *     "is_active": true,
     *     "picture": "ciment-portland.jpg",
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
     * Récupère la liste de tous les produits appartenant à une catégorie spécifique.
     *
     * @group Gestion des Produits
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam categoryId string required UUID de la catégorie. Example: 8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "product_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "code": "PRO-ABC123",
     *       "name": "Ciment Portland",
     *       "description": "Ciment de qualité supérieure",
     *       "unit_price": 45000.00,
     *       "unit_of_measure": "sac",
     *       "unit_weight": 50.0000,
     *       "cost": 35000.00,
     *       "minimum_cost": 30000.00,
     *       "min_stock_level": 100,
     *       "is_active": true,
     *       "picture": "ciment-portland.jpg",
     *       "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "created_at": "2025-01-16T14:20:00.000000Z",
     *       "updated_at": "2025-01-16T14:20:00.000000Z",
     *       "deleted_at": null,
     *       "category": {
     *         "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *         "label": "Matériaux de construction",
     *         "description": "Matériaux pour le bâtiment"
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
     * }
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

    /**
     * Calculer le tonnage pour une quantité de produit
     *
     * Calcule le tonnage total pour une quantité donnée d'un produit spécifique.
     * Le produit doit avoir un unit_weight défini.
     *
     * @group Gestion des Produits
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du produit. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     *
     * @bodyParam quantity numeric required Quantité de produit. Example: 500
     *
     * @response 200 scenario="Calcul réussi" {
     *   "data": {
     *     "product_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "product_name": "Ciment Portland",
     *     "quantity": 500,
     *     "unit_weight_kg": 50.0000,
     *     "total_weight_kg": 25000.0000,
     *     "tonnage_t": 25.0000,
     *     "unit_of_measure": "sac"
     *   },
     *   "message": "Tonnage calculé avec succès"
     * }
     * 
     * @response 422 scenario="Produit sans poids unitaire" {
     *   "message": "Ce produit n'a pas de poids unitaire défini pour le calcul du tonnage"
     * }
     * 
     * @response 422 scenario="Quantité invalide" {
     *   "errors": {
     *     "quantity": [
     *       "La quantité est obligatoire"
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
    public function calculateTonnage(Request $request, string $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        // Validation de la quantité
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:0'
        ], [
            'quantity.required' => 'La quantité est obligatoire',
            'quantity.numeric' => 'La quantité doit être un nombre',
            'quantity.min' => 'La quantité doit être positive'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Vérifier si le produit a un poids unitaire
        if (!$product->hasTonnageCalculation()) {
            return response()->json([
                'message' => 'Ce produit n\'a pas de poids unitaire défini pour le calcul du tonnage'
            ], 422);
        }

        $quantity = $request->input('quantity');
        $totalWeight = $product->getTotalWeight($quantity);
        $tonnage = $product->calculateTonnage($quantity);

        return response()->json([
            'data' => [
                'product_id' => $product->product_id,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'unit_weight_kg' => $product->unit_weight,
                'total_weight_kg' => $totalWeight,
                'tonnage_t' => $tonnage,
                'unit_of_measure' => $product->unit_of_measure
            ],
            'message' => 'Tonnage calculé avec succès'
        ], 200);
    }
}
