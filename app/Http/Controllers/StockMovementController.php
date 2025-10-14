<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\StockMovementType;
use App\Models\Entrepot;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    /**
     * @group Stock Movements
     * @authenticated
     * 
     * Récupère la liste paginée de tous les mouvements de stock
     * 
     * Cette endpoint retourne tous les mouvements de stock avec leurs détails complets.
     * Elle supporte le filtrage, la recherche et le tri avancé.
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @queryParam movement_type_id string Filtrer par type de mouvement (UUID). Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam statut string Filtrer par statut du mouvement. Example: pending
     * @queryParam entrepot_from_id string Filtrer par entrepôt source (UUID). Example: 550e8400-e29b-41d4-a716-446655440001
     * @queryParam entrepot_to_id string Filtrer par entrepôt destination (UUID). Example: 550e8400-e29b-41d4-a716-446655440002
     * @queryParam client_id string Filtrer par client (UUID). Example: 550e8400-e29b-41d4-a716-446655440101
     * @queryParam fournisseur_id string Filtrer par fournisseur (UUID). Example: 550e8400-e29b-41d4-a716-446655440100
     * @queryParam search string Rechercher par numéro de référence. Example: MV-2024
     * @queryParam date_from date Filtrer par date de début (YYYY-MM-DD). Example: 2024-01-01
     * @queryParam date_to date Filtrer par date de fin (YYYY-MM-DD). Example: 2024-12-31
     * @queryParam sort_by string Champ sur lequel trier. Example: created_at
     * @queryParam sort_order string Ordre de tri (asc/desc). Example: desc
     * @queryParam per_page integer Nombre d'éléments par page. Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *         "reference": "MV-2024-00001",
     *         "movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *         "statut": "pending",
     *         "created_at": "2024-01-15 14:30:00"
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 1
     *   },
     *   "message": "Mouvements de stock récupérés avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 500 {
     *   "success": false,
     *   "message": "Erreur lors de la récupération des mouvements de stock",
     *   "error": "Message d'erreur détaillé"
     * }
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = StockMovement::with(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product']);

            if ($request->has('movement_type_id')) {
                $query->where('movement_type_id', $request->movement_type_id);
            }

            if ($request->has('statut')) {
                $query->where('statut', $request->statut);
            }

            if ($request->has('entrepot_from_id')) {
                $query->where('entrepot_from_id', $request->entrepot_from_id);
            }

            if ($request->has('entrepot_to_id')) {
                $query->where('entrepot_to_id', $request->entrepot_to_id);
            }

            if ($request->has('client_id')) {
                $query->where('client_id', $request->client_id);
            }

            if ($request->has('fournisseur_id')) {
                $query->where('fournisseur_id', $request->fournisseur_id);
            }

            if ($request->has('search')) {
                $query->where('reference', 'like', '%' . $request->search . '%');
            }

            if ($request->has('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            $perPage = $request->get('per_page', 15);
            $stockMovements = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $stockMovements,
                'message' => 'Mouvements de stock récupérés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des mouvements de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     * Crée un transfert de stock entre deux entrepôts
     * 
     * Cette endpoint permet de créer un mouvement de transfert entre deux entrepôts.
     * La référence du mouvement est générée automatiquement au format MV-YYYY-XXXXX.
     * 
     * **Comment inclure le Bearer Token :**
     * 
     * Ajoutez l'en-tête Authorization à votre requête :
     * ```
     * Authorization: Bearer YOUR_API_TOKEN_HERE
     * ```
     * 
     * Exemple complet avec cURL :
     * ```bash
     * curl -X POST http://votre-api.com/api/stock-movements/transfer/warehouse \
     *   -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
     *   -H "Content-Type: application/json" \
     *   -d '{
     *     "movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "entrepot_from_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "entrepot_to_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "note": "Transfert urgent",
     *     "details": [
     *       {"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantity": 10}
     *     ]
     *   }'
     * ```
     * 
     * @header Authorization required Bearer token au format "Bearer {token}". Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @bodyParam movement_type_id string required UUID du type de mouvement (direction: transfer). Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam entrepot_from_id string required UUID de l'entrepôt source. Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam entrepot_to_id string required UUID de l'entrepôt destination (doit être différent de entrepot_from_id). Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam note string optionnel Note descriptive du transfert. Example: Transfert urgent vers l'entrepôt B
     * @bodyParam details array required Tableau contenant les détails du mouvement (minimum 1 produit). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantity": 10}]
     * @bodyParam details[].product_id string required UUID du produit. Example: 550e8400-e29b-41d4-a716-446655440003
     * @bodyParam details[].quantity integer required Quantité à transférer (minimum 1). Example: 10
     * 
     * @response 201 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440010",
     *     "reference": "MV-2024-00001",
     *     "movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "entrepot_from_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "entrepot_to_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "fournisseur_id": null,
     *     "client_id": null,
     *     "statut": "pending",
     *     "note": "Transfert urgent vers l'entrepôt B",
     *     "user_id": "550e8400-e29b-41d4-a716-446655440099",
     *     "created_at": "2024-01-15 14:30:00",
     *     "updated_at": "2024-01-15 14:30:00",
     *     "movement_type": {
     *       "stock_movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "name": "Transfert",
     *       "direction": "transfer"
     *     },
     *     "entrepot_from": {
     *       "entrepot_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "name": "Entrepôt A"
     *     },
     *     "entrepot_to": {
     *       "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *       "name": "Entrepôt B"
     *     },
     *     "user": {
     *       "user_id": "550e8400-e29b-41d4-a716-446655440099",
     *       "name": "Jean Dupont"
     *     },
     *     "details": [
     *       {
     *         "stock_movement_detail_id": "550e8400-e29b-41d4-a716-446655440011",
     *         "stock_movement_id": "550e8400-e29b-41d4-a716-446655440010",
     *         "product_id": "550e8400-e29b-41d4-a716-446655440003",
     *         "quantity": 10,
     *         "product": {
     *           "product_id": "550e8400-e29b-41d4-a716-446655440003",
     *           "name": "Produit A",
     *           "sku": "PROD-A-001"
     *         }
     *       }
     *     ]
     *   },
     *   "message": "Transfert entre entrepôts créé avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "entrepot_from_id": ["Le champ entrepot_from_id est obligatoire."],
     *     "entrepot_to_id": ["Le champ entrepot_to_id doit être différent du champ entrepot_from_id."],
     *     "details": ["Le champ details est obligatoire."]
     *   }
     * }
     */
    public function storeWarehouseTransfer(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'movement_type_id' => 'required|uuid|exists:stock_movement_types,stock_movement_type_id',
                'entrepot_from_id' => 'required|uuid|exists:entrepots,entrepot_id',
                'entrepot_to_id' => 'required|uuid|exists:entrepots,entrepot_id|different:entrepot_from_id',
                'note' => 'nullable|string|max:1000',
                'details' => 'required|array|min:1',
                'details.*.product_id' => 'required|uuid|exists:products,product_id',
                'details.*.quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $movementType = StockMovementType::find($request->movement_type_id);
            if ($movementType->direction !== 'transfer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Le type de mouvement doit être un transfert (transfer)'
                ], 422);
            }

            DB::beginTransaction();

            try {
                $reference = $this->generateReference();

                $stockMovement = StockMovement::create([
                    'stock_movement_id' => (string) Str::uuid(),
                    'reference' => $reference,
                    'movement_type_id' => $request->movement_type_id,
                    'entrepot_from_id' => $request->entrepot_from_id,
                    'entrepot_to_id' => $request->entrepot_to_id,
                    'statut' => 'pending',
                    'note' => $request->note,
                    'user_id' => auth()->user()->user_id ?? null
                ]);

                foreach ($request->details as $detail) {
                    $stockMovement->details()->create([
                        'stock_movement_detail_id' => (string) Str::uuid(),
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity']
                    ]);
                }

                DB::commit();

                $stockMovement->load(['movementType', 'entrepotFrom', 'entrepotTo', 'user', 'details.product']);

                return response()->json([
                    'success' => true,
                    'data' => $stockMovement,
                    'message' => 'Transfert entre entrepôts créé avec succès'
                ], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du transfert',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     * Crée une réception de stock depuis un fournisseur vers un entrepôt
     * 
     * Cette endpoint permet de créer un mouvement de réception de marchandise en provenance d'un fournisseur.
     * 
     * **Comment inclure le Bearer Token :**
     * 
     * Ajoutez l'en-tête Authorization à votre requête :
     * ```
     * Authorization: Bearer YOUR_API_TOKEN_HERE
     * ```
     * 
     * Exemple complet avec cURL :
     * ```bash
     * curl -X POST http://votre-api.com/api/stock-movements/receipt/supplier \
     *   -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
     *   -H "Content-Type: application/json" \
     *   -d '{
     *     "movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "fournisseur_id": "550e8400-e29b-41d4-a716-446655440100",
     *     "entrepot_to_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "note": "Réception commande #PO-2024-001",
     *     "details": [
     *       {"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantity": 50}
     *     ]
     *   }'
     * ```
     * 
     * @header Authorization required Bearer token au format "Bearer {token}". Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @bodyParam movement_type_id string required UUID du type de mouvement (direction: in). Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam fournisseur_id string required UUID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440100
     * @bodyParam entrepot_to_id string required UUID de l'entrepôt destination (où sera stockée la marchandise). Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam note string optionnel Note descriptive de la réception (ex: numéro de bon de commande). Example: Réception commande #PO-2024-001
     * @bodyParam details array required Tableau contenant les détails du mouvement (minimum 1 produit). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantity": 50}]
     * @bodyParam details[].product_id string required UUID du produit reçu. Example: 550e8400-e29b-41d4-a716-446655440003
     * @bodyParam details[].quantity integer required Quantité reçue (minimum 1). Example: 50
     * 
     * @response 201 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440020",
     *     "reference": "MV-2024-00002",
     *     "movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "entrepot_from_id": null,
     *     "entrepot_to_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "fournisseur_id": "550e8400-e29b-41d4-a716-446655440100",
     *     "client_id": null,
     *     "statut": "pending",
     *     "note": "Réception commande #PO-2024-001",
     *     "user_id": "550e8400-e29b-41d4-a716-446655440099",
     *     "created_at": "2024-01-15 15:45:00",
     *     "updated_at": "2024-01-15 15:45:00",
     *     "movement_type": {
     *       "stock_movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "name": "Réception",
     *       "direction": "in"
     *     },
     *     "entrepot_to": {
     *       "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *       "name": "Entrepôt Principal"
     *     },
     *     "fournisseur": {
     *       "fournisseur_id": "550e8400-e29b-41d4-a716-446655440100",
     *       "name": "Fournisseur XYZ"
     *     },
     *     "user": {
     *       "user_id": "550e8400-e29b-41d4-a716-446655440099",
     *       "name": "Marie Martin"
     *     },
     *     "details": [
     *       {
     *         "stock_movement_detail_id": "550e8400-e29b-41d4-a716-446655440021",
     *         "product_id": "550e8400-e29b-41d4-a716-446655440003",
     *         "quantity": 50,
     *         "product": {
     *           "product_id": "550e8400-e29b-41d4-a716-446655440003",
     *           "name": "Produit A",
     *           "sku": "PROD-A-001"
     *         }
     *       }
     *     ]
     *   },
     *   "message": "Réception de fournisseur créée avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "movement_type_id": ["Le champ movement_type_id doit exister dans la table stock_movement_types."],
     *     "fournisseur_id": ["Le champ fournisseur_id est obligatoire."]
     *   }
     * }
     */
    public function storeSupplierReceipt(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'movement_type_id' => 'required|uuid|exists:stock_movement_types,stock_movement_type_id',
                'fournisseur_id' => 'required|uuid|exists:fournisseurs,fournisseur_id',
                'entrepot_to_id' => 'required|uuid|exists:entrepots,entrepot_id',
                'note' => 'nullable|string|max:1000',
                'details' => 'required|array|min:1',
                'details.*.product_id' => 'required|uuid|exists:products,product_id',
                'details.*.quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $movementType = StockMovementType::find($request->movement_type_id);
            if ($movementType->direction !== 'in') {
                return response()->json([
                    'success' => false,
                    'message' => 'Le type de mouvement doit être une entrée (in)'
                ], 422);
            }

            DB::beginTransaction();

            try {
                $reference = $this->generateReference();

                $stockMovement = StockMovement::create([
                    'stock_movement_id' => (string) Str::uuid(),
                    'reference' => $reference,
                    'movement_type_id' => $request->movement_type_id,
                    'fournisseur_id' => $request->fournisseur_id,
                    'entrepot_to_id' => $request->entrepot_to_id,
                    'statut' => 'pending',
                    'note' => $request->note,
                    'user_id' => auth()->user()->user_id ?? null
                ]);

                foreach ($request->details as $detail) {
                    $stockMovement->details()->create([
                        'stock_movement_detail_id' => (string) Str::uuid(),
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity']
                    ]);
                }

                DB::commit();

                $stockMovement->load(['movementType', 'entrepotTo', 'fournisseur', 'user', 'details.product']);

                return response()->json([
                    'success' => true,
                    'data' => $stockMovement,
                    'message' => 'Réception de fournisseur créée avec succès'
                ], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la réception',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     * Crée un mouvement de stock générique
     * 
     * Cette endpoint est une alternative générique aux endpoints spécialisés.
     * Préférez utiliser `storeWarehouseTransfer()` ou `storeSupplierReceipt()` quand applicable.
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @bodyParam movement_type_id string required UUID du type de mouvement. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam entrepot_from_id string optionnel UUID de l'entrepôt source. Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam entrepot_to_id string optionnel UUID de l'entrepôt destination. Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam fournisseur_id string optionnel UUID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440100
     * @bodyParam client_id string optionnel UUID du client. Example: 550e8400-e29b-41d4-a716-446655440101
     * @bodyParam note string optionnel Note descriptive du mouvement. Example: Mouvement générique
     * @bodyParam details array required Tableau contenant les détails du mouvement (minimum 1 produit). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantity": 20}]
     * @bodyParam details[].product_id string required UUID du produit. Example: 550e8400-e29b-41d4-a716-446655440003
     * @bodyParam details[].quantity integer required Quantité (minimum 1). Example: 20
     * 
     * @response 201 {
     *   "success": true,
     *   "data": {},
     *   "message": "Mouvement de stock créé avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {}
     * }
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'movement_type_id' => 'required|exists:stock_movement_types,stock_movement_type_id',
                'entrepot_from_id' => 'nullable|exists:entrepots,entrepot_id',
                'entrepot_to_id' => 'nullable|exists:entrepots,entrepot_id',
                'fournisseur_id' => 'nullable|exists:fournisseurs,fournisseur_id',
                'client_id' => 'nullable|exists:clients,client_id',
                'note' => 'nullable|string|max:1000',
                'details' => 'required|array|min:1',
                'details.*.product_id' => 'required|exists:products,product_id',
                'details.*.quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            try {
                $reference = $this->generateReference();

                $stockMovement = StockMovement::create([
                    'stock_movement_id' => (string) Str::uuid(),
                    'reference' => $reference,
                    'movement_type_id' => $request->movement_type_id,
                    'entrepot_from_id' => $request->entrepot_from_id,
                    'entrepot_to_id' => $request->entrepot_to_id,
                    'fournisseur_id' => $request->fournisseur_id,
                    'client_id' => $request->client_id,
                    'statut' => 'pending',
                    'note' => $request->note,
                    'user_id' => auth()->user()->user_id ?? null
                ]);

                foreach ($request->details as $detail) {
                    $stockMovement->details()->create([
                        'stock_movement_detail_id' => (string) Str::uuid(),
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity']
                    ]);
                }

                DB::commit();

                $stockMovement->load(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product']);

                return response()->json([
                    'success' => true,
                    'data' => $stockMovement,
                    'message' => 'Mouvement de stock créé avec succès'
                ], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     * Récupère les détails complets d'un mouvement de stock
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @urlParam id string required UUID du mouvement de stock à récupérer. Example: 550e8400-e29b-41d4-a716-446655440030
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *     "reference": "MV-2024-00003",
     *     "movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "statut": "pending",
     *     "details": []
     *   },
     *   "message": "Mouvement de stock récupéré avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::with(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product'])
                ->find($id);

            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $stockMovement,
                'message' => 'Mouvement de stock récupéré avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     * Met à jour entièrement un mouvement de stock (PUT)
     * 
     * Cette endpoint remplace tous les champs et détails du mouvement.
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @urlParam id string required UUID du mouvement de stock à mettre à jour. Example: 550e8400-e29b-41d4-a716-446655440030
     * @bodyParam movement_type_id string required UUID du type de mouvement. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam entrepot_from_id string optionnel UUID de l'entrepôt source. Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam entrepot_to_id string optionnel UUID de l'entrepôt destination. Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam fournisseur_id string optionnel UUID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440100
     * @bodyParam client_id string optionnel UUID du client. Example: 550e8400-e29b-41d4-a716-446655440101
     * @bodyParam statut string required Statut du mouvement (pending, completed, cancelled). Example: pending
     * @bodyParam note string optionnel Note descriptive. Example: Note mise à jour
     * @bodyParam details array required Tableau contenant les nouveaux détails du mouvement (minimum 1). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantity": 15}]
     * @bodyParam details[].product_id string required UUID du produit. Example: 550e8400-e29b-41d4-a716-446655440003
     * @bodyParam details[].quantity integer required Quantité (minimum 1). Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *     "reference": "MV-2024-00003",
     *     "statut": "completed",
     *     "details": []
     *   },
     *   "message": "Mouvement de stock mis à jour avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::find($id);

            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'movement_type_id' => 'required|exists:stock_movement_types,stock_movement_type_id',
                'entrepot_from_id' => 'nullable|exists:entrepots,entrepot_id',
                'entrepot_to_id' => 'nullable|exists:entrepots,entrepot_id',
                'fournisseur_id' => 'nullable|exists:fournisseurs,fournisseur_id',
                'client_id' => 'nullable|exists:clients,client_id',
                'statut' => 'required|in:pending,completed,cancelled',
                'note' => 'nullable|string|max:1000',
                'details' => 'required|array|min:1',
                'details.*.product_id' => 'required|exists:products,product_id',
                'details.*.quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            try {
                $stockMovement->update([
                    'movement_type_id' => $request->movement_type_id,
                    'entrepot_from_id' => $request->entrepot_from_id,
                    'entrepot_to_id' => $request->entrepot_to_id,
                    'fournisseur_id' => $request->fournisseur_id,
                    'client_id' => $request->client_id,
                    'statut' => $request->statut,
                    'note' => $request->note
                ]);

                $stockMovement->details()->delete();

                foreach ($request->details as $detail) {
                    $stockMovement->details()->create([
                        'stock_movement_detail_id' => (string) Str::uuid(),
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity']
                    ]);
                }

                DB::commit();

                $stockMovement->load(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product']);

                return response()->json([
                    'success' => true,
                    'data' => $stockMovement,
                    'message' => 'Mouvement de stock mis à jour avec succès'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     * Met à jour uniquement le statut d'un mouvement de stock
     * 
     * Cette endpoint est dédiée au changement de statut sans modifier les autres données.
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @urlParam id string required UUID du mouvement de stock. Example: 550e8400-e29b-41d4-a716-446655440030
     * @bodyParam statut string required Nouveau statut (pending, completed, cancelled). Example: completed
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *     "reference": "MV-2024-00003",
     *     "statut": "completed",
     *     "details": []
     *   },
     *   "message": "Statut du mouvement de stock mis à jour avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     */
    public function updateStatus(Request $request, string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::find($id);

            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'statut' => 'required|in:pending,completed,cancelled'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $stockMovement->update(['statut' => $request->statut]);

            $stockMovement->load(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product']);

            return response()->json([
                'success' => true,
                'data' => $stockMovement,
                'message' => 'Statut du mouvement de stock mis à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     * Supprime logiquement un mouvement de stock (soft delete)
     * 
     * Le mouvement n'est pas physiquement supprimé de la base de données,
     * mais marqué comme supprimé avec un timestamp deleted_at.
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @urlParam id string required UUID du mouvement de stock à supprimer. Example: 550e8400-e29b-41d4-a716-446655440030
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Mouvement de stock supprimé avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::find($id);

            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            $stockMovement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mouvement de stock supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     * Restaure un mouvement de stock supprimé
     * 
     * Récupère un mouvement qui a été supprimé via soft delete.
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @urlParam id string required UUID du mouvement de stock à restaurer. Example: 550e8400-e29b-41d4-a716-446655440030
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *     "reference": "MV-2024-00003",
     *     "deleted_at": null
     *   },
     *   "message": "Mouvement de stock restauré avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     */
    public function restore(string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::withTrashed()->find($id);

            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            if (!$stockMovement->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce mouvement de stock n\'est pas supprimé'
                ], 400);
            }

            $stockMovement->restore();

            $stockMovement->load(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product']);

            return response()->json([
                'success' => true,
                'data' => $stockMovement,
                'message' => 'Mouvement de stock restauré avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     * Récupère la liste des mouvements de stock supprimés
     * 
     * Retourne tous les mouvements marqués comme supprimés (soft delete).
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "data": [],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 0
     *   },
     *   "message": "Mouvements de stock supprimés récupérés avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */
    public function trashed(): JsonResponse
    {
        try {
            $stockMovements = StockMovement::onlyTrashed()
                ->with(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product'])
                ->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $stockMovements,
                'message' => 'Mouvements de stock supprimés récupérés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des mouvements de stock supprimés',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Génère une référence unique pour le mouvement au format MV-YYYY-XXXXX
     */
    private function generateReference(): string
    {
        $year = date('Y');
        $prefix = "MV-{$year}-";

        $lastMovement = StockMovement::where('reference', 'like', "{$prefix}%")
            ->orderBy('reference', 'desc')
            ->first();

        if ($lastMovement) {
            $lastNumber = (int) substr($lastMovement->reference, strlen($prefix));
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return $prefix . $newNumber;
    }
}
