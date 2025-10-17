<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Entrepot;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * @group Entrepôts
 *
 * APIs pour la gestion des entrepôts et l'attribution des responsables
 */
class EntrepotController extends Controller
{
    /**
     * Liste des entrepôts
     *
     * Récupère la liste paginée des entrepôts avec possibilité de filtrage.
     *
     * @queryParam page int Numéro de la page. Example: 1
     * @queryParam per_page int Nombre d'éléments par page (max 100). Example: 15
     * @queryParam search string Recherche par nom, code ou adresse. Example: Central
     * @queryParam is_active boolean Filtrer par statut actif (true/false). Example: true
     * @queryParam user_id string Filtrer par responsable (UUID). Example: 550e8400-e29b-41d4-a716-446655440001
     * @queryParam has_user boolean Filtrer les entrepôts avec/sans responsable. Example: true
     * @queryParam sort_by string Champ de tri (name, code, created_at). Example: name
     * @queryParam sort_order string Ordre de tri (asc, desc). Example: asc
     * @queryParam with_user boolean Inclure les informations du responsable. Example: true
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "entrepot_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "code": "ENT001",
     *       "name": "Entrepôt Central",
     *       "adresse": "123 Rue de l'Industrie",
     *       "is_active": true,
     *       "user_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "created_at": "2023-01-01T00:00:00.000000Z",
     *       "updated_at": "2023-01-01T00:00:00.000000Z",
     *       "user": {
     *         "user_id": "550e8400-e29b-41d4-a716-446655440001",
     *         "name": "Jean Dupont",
     *         "email": "jean.dupont@example.com"
     *       }
     *     }
     *   ],
     *   "links": {
     *     "first": "http://api.example.com/entrepots?page=1",
     *     "last": "http://api.example.com/entrepots?page=5",
     *     "prev": null,
     *     "next": "http://api.example.com/entrepots?page=2"
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 5,
     *     "per_page": 15,
     *     "to": 15,
     *     "total": 75
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $query = Entrepot::query();

        // Inclure les informations du responsable si demandé
        if ($request->boolean('with_user')) {
            $query->with('user:user_id,name,email');
        }

        // Filtres de recherche
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('adresse', 'like', "%{$search}%");
            });
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        // Filtrer par présence/absence de responsable
        if ($request->has('has_user')) {
            if ($request->boolean('has_user')) {
                $query->whereNotNull('user_id');
            } else {
                $query->whereNull('user_id');
            }
        }

        // Tri
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        if (in_array($sortBy, ['name', 'code', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder === 'desc' ? 'desc' : 'asc');
        }

        $perPage = min($request->get('per_page', 15), 100);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Créer un entrepôt
     *
     * Crée un nouvel entrepôt dans le système. Le code est généré automatiquement.
     *
     * @bodyParam name string required Nom de l'entrepôt. Example: Entrepôt Central
     * @bodyParam adresse string Adresse de l'entrepôt. Example: 123 Rue de l'Industrie
     * @bodyParam is_active boolean Statut actif (par défaut: true). Example: true
     * @bodyParam user_id string UUID du responsable (optionnel). Example: 550e8400-e29b-41d4-a716-446655440001
     *
     * @response 201 {
     *   "entrepot_id": "550e8400-e29b-41d4-a716-446655440000",
     *   "code": "ENT-ABC123",
     *   "name": "Entrepôt Central",
     *   "adresse": "123 Rue de l'Industrie",
     *   "is_active": true,
     *   "user_id": "550e8400-e29b-41d4-a716-446655440001",
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z",
     *   "user": {
     *     "user_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "name": "Jean Dupont",
     *     "email": "jean.dupont@example.com"
     *   }
     * }
     *
     * @response 422 {
     *   "message": "Les données fournies ne sont pas valides.",
     *   "errors": {
     *     "name": ["Le nom est obligatoire."]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();

        $rules = [
            'name' => 'required|string|max:255|unique:entrepots,name',
            'adresse' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'user_id' => 'nullable|uuid|exists:users,user_id',
        ];

        $messages = [
            'name.required' => 'Le nom est obligatoire.',
            'name.unique' => 'Ce nom est déjà utilisé.',
            'user_id.exists' => 'Utilisateur inexistant.',
        ];

        // Validation
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Création de l'entrepôt
        $entrepot = Entrepot::create($validator->validated());

        // Charger la relation user si elle existe
        $entrepot->load('user:user_id,username,email');

        return response()->json($entrepot, 201);
    }


    /**
     * Afficher un entrepôt
     *
     * Récupère les détails d'un entrepôt spécifique.
     *
     * @urlParam id string required L'ID de l'entrepôt. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam with_user boolean Inclure les informations du responsable. Example: true
     *
     * @response 200 {
     *   "entrepot_id": "550e8400-e29b-41d4-a716-446655440000",
     *   "code": "ENT001",
     *   "name": "Entrepôt Central",
     *   "adresse": "123 Rue de l'Industrie",
     *   "is_active": true,
     *   "user_id": "550e8400-e29b-41d4-a716-446655440001",
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z",
     *   "user": {
     *     "user_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "name": "Jean Dupont",
     *     "email": "jean.dupont@example.com"
     *   }
     * }
     *
     * @response 404 {
     *   "message": "Entrepôt non trouvé."
     * }
     */
    public function show(Request $request, string $id): JsonResponse
    {
        $query = Entrepot::where('entrepot_id', $id);

        if ($request->boolean('with_user')) {
            $query->with('user:user_id,name,email');
        }

        $entrepot = $query->firstOrFail();

        return response()->json($entrepot);
    }

    /**
     * Mettre à jour un entrepôt
     *
     * Met à jour les informations d'un entrepôt existant. Le code ne peut pas être modifié.
     *
     * @urlParam id string required L'ID de l'entrepôt. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam name string Nom de l'entrepôt. Example: Entrepôt Central
     * @bodyParam adresse string Adresse de l'entrepôt. Example: 123 Rue de l'Industrie
     * @bodyParam is_active boolean Statut actif. Example: true
     * @bodyParam user_id string UUID du responsable. Example: 550e8400-e29b-41d4-a716-446655440001
     *
     * @response 200 {
     *   "entrepot_id": "550e8400-e29b-41d4-a716-446655440000",
     *   "code": "ENT-ABC123",
     *   "name": "Entrepôt Central Mis à Jour",
     *   "adresse": "456 Nouvelle Adresse",
     *   "is_active": true,
     *   "user_id": "550e8400-e29b-41d4-a716-446655440001",
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-02T00:00:00.000000Z",
     *   "user": {
     *     "user_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "name": "Jean Dupont",
     *     "email": "jean.dupont@example.com"
     *   }
     * }
     *
     * @response 404 {
     *   "message": "Entrepôt non trouvé."
     * }
     *
     * @response 422 {
     *   "message": "Les données fournies ne sont pas valides."
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $entrepot = Entrepot::where('entrepot_id', $id)->firstOrFail();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'user_id' => 'nullable|uuid|exists:users,user_id'
        ]);

        $entrepot->update($validated);

        return response()->json($entrepot);
    }

    /**
     * Obtenir tous les produits avec leurs stocks pour un entrepôt spécifique
     *
     * Récupère la liste complète des produits avec leurs informations de stock
     * dans un entrepôt donné. Inclut également les produits sans stock (quantité 0).
     *
     * @urlParam id string required L'ID de l'entrepôt. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam with_category boolean Inclure les informations de catégorie des produits. Example: true
     * @queryParam only_in_stock boolean Afficher uniquement les produits en stock (quantité > 0). Example: false
     * @queryParam only_active boolean Afficher uniquement les produits actifs. Example: true
     * @queryParam search string Rechercher par nom ou code de produit. Example: Laptop
     * @queryParam sort_by string Champ de tri (name, quantite, available_quantity). Example: name
     * @queryParam sort_order string Ordre de tri (asc, desc). Example: asc
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 20
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "entrepot": {
     *       "entrepot_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "code": "ENT001",
     *       "name": "Entrepôt Central",
     *       "adresse": "123 Rue de l'Industrie",
     *       "is_active": true
     *     },
     *     "products": {
     *       "current_page": 1,
     *       "data": [
     *         {
     *           "product_id": "550e8400-e29b-41d4-a716-446655440003",
     *           "code": "PRO-ABC123",
     *           "name": "Laptop Dell XPS 15",
     *           "description": "Ordinateur portable haute performance",
     *           "unit_price": 1500000.00,
     *           "cost": 1200000.00,
     *           "min_stock_level": 5,
     *           "is_active": true,
     *           "picture": "laptop-dell-xps.jpg",
     *           "category": {
     *             "product_category_id": "550e8400-e29b-41d4-a716-446655440010",
     *             "label": "Informatique"
     *           },
     *           "stock": {
     *             "stock_id": "550e8400-e29b-41d4-a716-446655440020",
     *             "quantite": 50,
     *             "reserved_quantity": 5,
     *             "available_quantity": 45,
     *             "is_below_minimum": false,
     *             "last_updated": "2024-10-15T10:30:00.000000Z"
     *           }
     *         },
     *         {
     *           "product_id": "550e8400-e29b-41d4-a716-446655440004",
     *           "code": "PRO-XYZ789",
     *           "name": "Souris Logitech",
     *           "description": "Souris sans fil ergonomique",
     *           "unit_price": 25000.00,
     *           "cost": 18000.00,
     *           "min_stock_level": 20,
     *           "is_active": true,
     *           "picture": "souris-logitech.jpg",
     *           "category": {
     *             "product_category_id": "550e8400-e29b-41d4-a716-446655440010",
     *             "label": "Informatique"
     *           },
     *           "stock": {
     *             "stock_id": null,
     *             "quantite": 0,
     *             "reserved_quantity": 0,
     *             "available_quantity": 0,
     *             "is_below_minimum": true,
     *             "last_updated": null
     *           }
     *         }
     *       ],
     *       "per_page": 20,
     *       "total": 2
     *     },
     *     "summary": {
     *       "total_products": 2,
     *       "products_in_stock": 1,
     *       "products_out_of_stock": 1,
     *       "products_below_minimum": 1,
     *       "total_stock_value": 60000000.00
     *     }
     *   },
     *   "message": "Produits de l'entrepôt récupérés avec succès"
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Entrepôt non trouvé."
     * }
     */
    public function getProductsWithStocks(Request $request, string $id): JsonResponse
    {
        try {
            // Vérifier que l'entrepôt existe
            $entrepot = Entrepot::where('entrepot_id', $id)->firstOrFail();

            // Construire la requête pour les produits
            $query = Product::query();

            // Inclure la catégorie si demandé
            if ($request->boolean('with_category')) {
                $query->with('category');
            }

            // Filtrer par produits actifs seulement si demandé
            if ($request->boolean('only_active', true)) {
                $query->where('is_active', true);
            }

            // Recherche par nom ou code
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            }

            // Récupérer les produits avec leurs stocks dans cet entrepôt
            $query->leftJoin('stocks', function ($join) use ($id) {
                $join->on('products.product_id', '=', 'stocks.product_id')
                    ->where('stocks.entrepot_id', '=', $id)
                    ->whereNull('stocks.deleted_at');
            });

            // Filtrer par produits en stock seulement si demandé
            if ($request->boolean('only_in_stock')) {
                $query->where('stocks.quantite', '>', 0);
            }

            // Sélectionner les champs
            $query->select(
                'products.*',
                'stocks.stock_id',
                'stocks.quantite',
                'stocks.reserved_quantity',
                'stocks.updated_at as stock_last_updated'
            );

            // Tri
            $sortBy = $request->get('sort_by', 'name');
            $sortOrder = $request->get('sort_order', 'asc');

            switch ($sortBy) {
                case 'quantite':
                    $query->orderBy('stocks.quantite', $sortOrder);
                    break;
                case 'available_quantity':
                    $query->orderByRaw("(COALESCE(stocks.quantite, 0) - COALESCE(stocks.reserved_quantity, 0)) {$sortOrder}");
                    break;
                default:
                    $query->orderBy('products.' . $sortBy, $sortOrder);
            }

            $perPage = min($request->get('per_page', 20), 100);
            $products = $query->paginate($perPage);

            // Formater les résultats
            $formattedProducts = $products->getCollection()->map(function ($product) {
                $quantite = $product->quantite ?? 0;
                $reservedQuantity = $product->reserved_quantity ?? 0;
                $availableQuantity = $quantite - $reservedQuantity;

                return [
                    'product_id' => $product->product_id,
                    'code' => $product->code,
                    'name' => $product->name,
                    'description' => $product->description,
                    'unit_price' => $product->unit_price,
                    'cost' => $product->cost,
                    'minimum_cost' => $product->minimum_cost,
                    'min_stock_level' => $product->min_stock_level,
                    'is_active' => $product->is_active,
                    'picture' => $product->picture,
                    'category' => $product->category ? [
                        'product_category_id' => $product->category->product_category_id,
                        'label' => $product->category->label,
                        'description' => $product->category->description
                    ] : null,
                    'stock' => [
                        'stock_id' => $product->stock_id,
                        'quantite' => $quantite,
                        'reserved_quantity' => $reservedQuantity,
                        'available_quantity' => $availableQuantity,
                        'is_below_minimum' => $quantite < $product->min_stock_level,
                        'last_updated' => $product->stock_last_updated
                    ]
                ];
            });

            $products->setCollection($formattedProducts);

            // Calculer les statistiques
            $totalProducts = $products->total();
            $productsInStock = $formattedProducts->filter(fn($p) => $p['stock']['quantite'] > 0)->count();
            $productsOutOfStock = $formattedProducts->filter(fn($p) => $p['stock']['quantite'] == 0)->count();
            $productsBelowMinimum = $formattedProducts->filter(fn($p) => $p['stock']['is_below_minimum'])->count();
            $totalStockValue = $formattedProducts->sum(fn($p) => $p['stock']['quantite'] * $p['cost']);

            return response()->json([
                'success' => true,
                'data' => [
                    'entrepot' => [
                        'entrepot_id' => $entrepot->entrepot_id,
                        'code' => $entrepot->code,
                        'name' => $entrepot->name,
                        'adresse' => $entrepot->adresse,
                        'is_active' => $entrepot->is_active
                    ],
                    'products' => $products,
                    'summary' => [
                        'total_products' => $totalProducts,
                        'products_in_stock' => $productsInStock,
                        'products_out_of_stock' => $productsOutOfStock,
                        'products_below_minimum' => $productsBelowMinimum,
                        'total_stock_value' => $totalStockValue
                    ]
                ],
                'message' => 'Produits de l\'entrepôt récupérés avec succès'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Entrepôt non trouvé.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des produits',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un entrepôt
     *
     * Supprime définitivement un entrepôt.
     *
     * @urlParam id string required L'ID de l'entrepôt. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 204
     *
     * @response 404 {
     *   "message": "Entrepôt non trouvé."
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $entrepot = Entrepot::where('entrepot_id', $id)->firstOrFail();
        $entrepot->delete();

        return response()->json(null, 204);
    }

    /**
     * Attribuer un responsable à un entrepôt
     *
     * Assigne un utilisateur comme responsable d'un entrepôt.
     *
     * @urlParam id string required L'ID de l'entrepôt. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam user_id string required UUID du responsable à attribuer. Example: 550e8400-e29b-41d4-a716-446655440001
     *
     * @response 200 {
     *   "entrepot_id": "550e8400-e29b-41d4-a716-446655440000",
     *   "code": "ENT001",
     *   "name": "Entrepôt Central",
     *   "adresse": "123 Rue de l'Industrie",
     *   "is_active": true,
     *   "user_id": "550e8400-e29b-41d4-a716-446655440001",
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-02T00:00:00.000000Z",
     *   "user": {
     *     "user_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "name": "Jean Dupont",
     *     "email": "jean.dupont@example.com"
     *   }
     * }
     *
     * @response 400 {
     *   "message": "Cet entrepôt a déjà un responsable attribué."
     * }
     *
     * @response 404 {
     *   "message": "Entrepôt non trouvé."
     * }
     *
     * @response 422 {
     *   "message": "Les données fournies ne sont pas valides.",
     *   "errors": {
     *     "user_id": ["L'utilisateur sélectionné n'existe pas."]
     *   }
     * }
     */
    public function assignUser(Request $request, string $id): JsonResponse
    {
        $entrepot = Entrepot::where('entrepot_id', $id)->firstOrFail();

        if ($entrepot->user_id !== null) {
            return response()->json([
                'message' => 'Cet entrepôt a déjà un responsable attribué.'
            ], 400);
        }

        $validated = $request->validate([
            'user_id' => 'required|uuid|exists:users,user_id'
        ]);

        $entrepot->update(['user_id' => $validated['user_id']]);

        // Charger la relation user
        $entrepot->load('user:user_id,name,email');

        return response()->json($entrepot);
    }

    /**
     * Désattribuer le responsable d'un entrepôt
     *
     * Retire le responsable assigné à un entrepôt.
     *
     * @urlParam id string required L'ID de l'entrepôt. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "entrepot_id": "550e8400-e29b-41d4-a716-446655440000",
     *   "code": "ENT001",
     *   "name": "Entrepôt Central",
     *   "adresse": "123 Rue de l'Industrie",
     *   "is_active": true,
     *   "user_id": null,
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-02T00:00:00.000000Z",
     *   "user": null
     * }
     *
     * @response 400 {
     *   "message": "Aucun responsable n'est attribué à cet entrepôt."
     * }
     *
     * @response 404 {
     *   "message": "Entrepôt non trouvé."
     * }
     */
    public function unassignUser(string $id): JsonResponse
    {
        $entrepot = Entrepot::where('entrepot_id', $id)->firstOrFail();

        if ($entrepot->user_id === null) {
            return response()->json([
                'message' => 'Aucun responsable n\'est attribué à cet entrepôt.'
            ], 400);
        }

        $entrepot->update(['user_id' => null]);

        return response()->json($entrepot);
    }

    /**
     * Changer le responsable d'un entrepôt
     *
     * Remplace le responsable actuel par un nouveau responsable.
     *
     * @urlParam id string required L'ID de l'entrepôt. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam user_id string required UUID du nouveau responsable. Example: 550e8400-e29b-41d4-a716-446655440002
     *
     * @response 200 {
     *   "entrepot_id": "550e8400-e29b-41d4-a716-446655440000",
     *   "code": "ENT001",
     *   "name": "Entrepôt Central",
     *   "adresse": "123 Rue de l'Industrie",
     *   "is_active": true,
     *   "user_id": "550e8400-e29b-41d4-a716-446655440002",
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-02T00:00:00.000000Z",
     *   "user": {
     *     "user_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "name": "Marie Martin",
     *     "email": "marie.martin@example.com"
     *   }
     * }
     *
     * @response 404 {
     *   "message": "Entrepôt non trouvé."
     * }
     *
     * @response 422 {
     *   "message": "Les données fournies ne sont pas valides.",
     *   "errors": {
     *     "user_id": ["L'utilisateur sélectionné n'existe pas."]
     *   }
     * }
     */
    public function changeUser(Request $request, string $id): JsonResponse
    {
        $entrepot = Entrepot::where('entrepot_id', $id)->firstOrFail();

        $validated = $request->validate([
            'user_id' => 'required|uuid|exists:users,user_id'
        ]);

        $entrepot->update(['user_id' => $validated['user_id']]);

        // Charger la relation user
        $entrepot->load('user:user_id,name,email');

        return response()->json($entrepot);
    }
}
