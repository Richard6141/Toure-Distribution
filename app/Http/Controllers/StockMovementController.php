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
     * 
     * Récupère la liste des mouvements de stock avec leurs détails
     * 
     * @queryParam movement_type_id string Filtrer par type de mouvement. Example: uuid
     * @queryParam statut string Filtrer par statut (pending, completed, cancelled). Example: pending
     * @queryParam entrepot_from_id string Filtrer par entrepôt source. Example: uuid
     * @queryParam entrepot_to_id string Filtrer par entrepôt destination. Example: uuid
     * @queryParam client_id string Filtrer par client. Example: uuid
     * @queryParam fournisseur_id string Filtrer par fournisseur. Example: uuid
     * @queryParam search string Rechercher par référence. Example: MV-2024-001
     * @queryParam date_from date Filtrer par date de début. Example: 2024-01-01
     * @queryParam date_to date Filtrer par date de fin. Example: 2024-12-31
     * @queryParam sort_by string Champ de tri. Example: created_at
     * @queryParam sort_order string Ordre de tri (asc, desc). Example: desc
     * @queryParam per_page integer Nombre d'éléments par page. Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "stock_movement_id": "uuid",
     *         "reference": "MV-2024-00001",
     *         "movement_type_id": "uuid",
     *         "entrepot_from_id": "uuid",
     *         "entrepot_to_id": "uuid",
     *         "fournisseur_id": null,
     *         "client_id": null,
     *         "statut": "pending",
     *         "note": "Note optionnelle",
     *         "user_id": "uuid",
     *         "created_at": "2024-01-01 10:00:00",
     *         "updated_at": "2024-01-01 10:00:00",
     *         "movement_type": {
     *           "stock_movement_type_id": "uuid",
     *           "name": "Transfert",
     *           "direction": "transfer"
     *         },
     *         "entrepot_from": {
     *           "entrepot_id": "uuid",
     *           "name": "Entrepôt A"
     *         },
     *         "entrepot_to": {
     *           "entrepot_id": "uuid",
     *           "name": "Entrepôt B"
     *         },
     *         "fournisseur": null,
     *         "user": {
     *           "user_id": "uuid",
     *           "name": "John Doe"
     *         },
     *         "details": [
     *           {
     *             "stock_movement_detail_id": "uuid",
     *             "product_id": "uuid",
     *             "quantity": 10,
     *             "product": {
     *               "product_id": "uuid",
     *               "name": "Produit A",
     *               "sku": "PROD-A-001"
     *             }
     *           }
     *         ]
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 1,
     *     "last_page": 1
     *   },
     *   "message": "Mouvements de stock récupérés avec succès"
     * }
     * 
     * @response 500 {
     *   "success": false,
     *   "message": "Erreur lors de la récupération des mouvements de stock",
     *   "error": "Message d'erreur"
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
     * 
     * Crée un transfert de stock entre deux entrepôts
     * 
     * @bodyParam movement_type_id string required UUID du type de mouvement (direction: transfer). Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam entrepot_from_id string required UUID de l'entrepôt source. Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam entrepot_to_id string required UUID de l'entrepôt destination (doit être différent de entrepot_from_id). Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam note string optionnel Note descriptive du transfert. Example: Transfert urgent vers l'entrepôt B
     * @bodyParam details array required Tableau contenant les détails du mouvement (minimum 1 produit). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantity": 10}, {"product_id": "550e8400-e29b-41d4-a716-446655440004", "quantity": 5}]
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
     *       "name": "Jean Dupont",
     *       "email": "jean@example.com"
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
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "entrepot_from_id": ["Le champ entrepot_from_id est obligatoire."],
     *     "entrepot_to_id": ["Le champ entrepot_to_id doit être différent du champ entrepot_from_id."],
     *     "details": ["Le champ details est obligatoire."]
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Un ou plusieurs entrepôts n'existent pas"
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

            // Vérifier que le type de mouvement est un transfert
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
     * 
     * Crée une réception de stock depuis un fournisseur vers un entrepôt
     * 
     * @bodyParam movement_type_id string required UUID du type de mouvement (direction: in). Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam fournisseur_id string required UUID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440100
     * @bodyParam entrepot_to_id string required UUID de l'entrepôt destination (où sera stockée la marchandise). Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam note string optionnel Note descriptive de la réception (ex: numéro de bon de commande). Example: Réception commande #PO-2024-001
     * @bodyParam details array required Tableau contenant les détails du mouvement (minimum 1 produit). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantity": 50}, {"product_id": "550e8400-e29b-41d4-a716-446655440004", "quantity": 30}]
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
     *       "name": "Fournisseur XYZ",
     *       "contact": "contact@fournisseur.com"
     *     },
     *     "user": {
     *       "user_id": "550e8400-e29b-41d4-a716-446655440099",
     *       "name": "Marie Martin",
     *       "email": "marie@example.com"
     *     },
     *     "details": [
     *       {
     *         "stock_movement_detail_id": "550e8400-e29b-41d4-a716-446655440021",
     *         "stock_movement_id": "550e8400-e29b-41d4-a716-446655440020",
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
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "movement_type_id": ["Le champ movement_type_id doit exister dans la table stock_movement_types."],
     *     "fournisseur_id": ["Le champ fournisseur_id est obligatoire."],
     *     "entrepot_to_id": ["Le champ entrepot_to_id doit exister dans la table entrepots."],
     *     "details": ["Le champ details doit contenir au moins 1 élément."]
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Le fournisseur n'existe pas"
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

            // Vérifier que le type de mouvement est une entrée
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
     * 
     * Crée un mouvement de stock générique (pour les cas non couverts par les endpoints spécialisés)
     * 
     * Cette endpoint est une alternative générique aux endpoints spécialisés (transfert/réception). 
     * Préférez utiliser storeWarehouseTransfer() ou storeSupplierReceipt() quand applicable.
     * 
     * @bodyParam movement_type_id string required UUID du type de mouvement. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam entrepot_from_id string optionnel UUID de l'entrepôt source (requis pour les transferts). Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam entrepot_to_id string optionnel UUID de l'entrepôt destination (requis pour les réceptions/transferts). Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam fournisseur_id string optionnel UUID du fournisseur (pour les réceptions). Example: 550e8400-e29b-41d4-a716-446655440100
     * @bodyParam client_id string optionnel UUID du client (pour les sorties). Example: 550e8400-e29b-41d4-a716-446655440101
     * @bodyParam note string optionnel Note descriptive du mouvement. Example: Mouvement générique
     * @bodyParam details array required Tableau contenant les détails du mouvement (minimum 1 produit). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantity": 20}]
     * @bodyParam details[].product_id string required UUID du produit. Example: 550e8400-e29b-41d4-a716-446655440003
     * @bodyParam details[].quantity integer required Quantité (minimum 1). Example: 20
     * 
     * @response 201 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *     "reference": "MV-2024-00003",
     *     "movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "entrepot_from_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "entrepot_to_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "fournisseur_id": null,
     *     "client_id": null,
     *     "statut": "pending",
     *     "note": "Mouvement générique",
     *     "user_id": "550e8400-e29b-41d4-a716-446655440099",
     *     "created_at": "2024-01-15 16:20:00",
     *     "updated_at": "2024-01-15 16:20:00",
     *     "movement_type": {
     *       "stock_movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "name": "Transfert",
     *       "direction": "transfer"
     *     },
     *     "details": []
     *   },
     *   "message": "Mouvement de stock créé avec succès"
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "movement_type_id": ["Le champ movement_type_id est obligatoire."],
     *     "details": ["Le champ details est obligatoire."]
     *   }
     * }
     * 
     * @response 500 {
     *   "success": false,
     *   "message": "Erreur lors de la création du mouvement de stock",
     *   "error": "Message d'erreur détaillé"
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
     * 
     * Récupère les détails d'un mouvement de stock spécifique
     * 
     * @urlParam id string required UUID du mouvement de stock à récupérer. Example: 550e8400-e29b-41d4-a716-446655440030
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *     "reference": "MV-2024-00003",
     *     "movement_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "entrepot_from_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "entrepot_to_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "fournisseur_id": null,
     *     "client_id": null,
     *     "statut": "pending",
     *     "note": "Note optionnelle",
     *     "user_id": "550e8400-e29b-41d4-a716-446655440099",
     *     "created_at": "2024-01-15 16:20:00",
     *     "updated_at": "2024-01-15 16:20:00",
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
     *     "fournisseur": null,
     *     "client": null,
     *     "user": {
     *       "user_id": "550e8400-e29b-41d4-a716-446655440099",
     *       "name": "Jean Dupont"
     *     },
     *     "details": [
     *       {
     *         "stock_movement_detail_id": "550e8400-e29b-41d4-a716-446655440031",
     *         "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *         "product_id": "550e8400-e29b-41d4-a716-446655440003",
     *         "quantity": 20,
     *         "product": {
     *           "product_id": "550e8400-e29b-41d4-a716-446655440003",
     *           "name": "Produit A",
     *           "sku": "PROD-A-001"
     *         }
     *       }
     *     ]
     *   },
     *   "message": "Mouvement de stock récupéré avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     * 
     * @response 500 {
     *   "success": false,
     *   "message": "Erreur lors de la récupération du mouvement de stock",
     *   "error": "Message d'erreur détaillé"
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
     * Mettre à jour un mouvement de stock
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
     * Met à jour le statut d'un mouvement de stock
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
     * Supprimer un mouvement de stock (soft delete)
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
     * Restaurer un mouvement de stock supprimé
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
     * Lister les mouvements de stock supprimés
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
     * Génère une référence unique pour le mouvement
     * Format: MV-YYYY-XXXXX
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