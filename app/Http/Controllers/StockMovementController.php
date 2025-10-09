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
     *         "reference": "MV-2024-001",
     *         "movement_type_id": "uuid",
     *         "entrepot_from_id": "uuid",
     *         "entrepot_to_id": "uuid",
     *         "fournisseur_id": "uuid",
     *         "client_id": "uuid",
     *         "statut": "pending",
     *         "note": "Note optionnelle",
     *         "user_id": "uuid",
     *         "created_at": "2024-01-01 10:00:00",
     *         "updated_at": "2024-01-01 10:00:00",
     *         "movement_type": {
     *           "stock_movement_type_id": "uuid",
     *           "name": "Réception",
     *           "direction": "in"
     *         },
     *         "details_count": 2,
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
     *     "total": 1
     *   },
     *   "message": "Mouvements de stock récupérés avec succès"
     * }
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = StockMovement::with(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'details.product']);

            // Filtrage par type de mouvement
            if ($request->has('movement_type_id')) {
                $query->where('movement_type_id', $request->movement_type_id);
            }

            // Filtrage par statut
            if ($request->has('statut')) {
                $query->where('statut', $request->statut);
            }

            // Filtrage par entrepôt source
            if ($request->has('entrepot_from_id')) {
                $query->where('entrepot_from_id', $request->entrepot_from_id);
            }

            // Filtrage par entrepôt destination
            if ($request->has('entrepot_to_id')) {
                $query->where('entrepot_to_id', $request->entrepot_to_id);
            }

            // Filtrage par client
            if ($request->has('client_id')) {
                $query->where('client_id', $request->client_id);
            }

            // Filtrage par fournisseur
            if ($request->has('fournisseur_id')) {
                $query->where('fournisseur_id', $request->fournisseur_id);
            }

            // Recherche par référence
            if ($request->has('search')) {
                $query->where('reference', 'like', '%' . $request->search . '%');
            }

            // Filtrage par date
            if ($request->has('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Tri
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Pagination
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
     * Crée un nouveau mouvement de stock avec ses détails
     * 
     * @bodyParam reference string required Référence unique du mouvement. Example: MV-2024-001
     * @bodyParam movement_type_id string required ID du type de mouvement. Example: uuid
     * @bodyParam entrepot_from_id string ID de l'entrepôt source (optionnel pour les transferts). Example: uuid
     * @bodyParam entrepot_to_id string ID de l'entrepôt destination (optionnel pour les réceptions). Example: uuid
     * @bodyParam fournisseur_id string ID du fournisseur (optionnel). Example: uuid
     * @bodyParam client_id string ID du client (optionnel). Example: uuid
     * @bodyParam statut string required Statut du mouvement (pending, completed, cancelled). Example: pending
     * @bodyParam note string Note optionnelle. Example: Note sur le mouvement
     * @bodyParam user_id string required ID de l'utilisateur. Example: uuid
     * @bodyParam details array required Détails du mouvement (minimum 1). Example: [{"product_id": "uuid", "quantity": 10}]
     * @bodyParam details.*.product_id string required ID du produit. Example: uuid
     * @bodyParam details.*.quantity integer required Quantité (minimum 1). Example: 10
     * 
     * @response 201 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "uuid",
     *     "reference": "MV-2024-001",
     *     "movement_type_id": "uuid",
     *     "entrepot_from_id": "uuid",
     *     "entrepot_to_id": "uuid",
     *     "fournisseur_id": "uuid",
     *     "client_id": "uuid",
     *     "statut": "pending",
     *     "note": "Note sur le mouvement",
     *     "user_id": "uuid",
     *     "created_at": "2024-01-01 10:00:00",
     *     "updated_at": "2024-01-01 10:00:00",
     *     "movement_type": {
     *       "stock_movement_type_id": "uuid",
     *       "name": "Réception",
     *       "direction": "in"
     *     },
     *     "details": [
     *       {
     *         "stock_movement_detail_id": "uuid",
     *         "product_id": "uuid",
     *         "quantity": 10,
     *         "product": {
     *           "product_id": "uuid",
     *           "name": "Produit A",
     *           "sku": "PROD-A-001"
     *         }
     *       }
     *     ]
     *   },
     *   "message": "Mouvement de stock créé avec succès"
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "reference": ["La référence est obligatoire."],
     *     "movement_type_id": ["Le type de mouvement est obligatoire."],
     *     "details": ["Les détails du mouvement sont obligatoires."]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'reference' => 'required|string|max:255|unique:stock_movements,reference',
                'movement_type_id' => 'required|exists:stock_movement_types,stock_movement_type_id',
                'entrepot_from_id' => 'nullable|exists:entrepots,entrepot_id',
                'entrepot_to_id' => 'nullable|exists:entrepots,entrepot_id',
                'fournisseur_id' => 'nullable|exists:fournisseurs,fournisseur_id',
                'client_id' => 'nullable|exists:clients,client_id',
                'statut' => 'required|in:pending,completed,cancelled',
                'note' => 'nullable|string|max:1000',
                'user_id' => 'required|exists:users,user_id',
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
                $stockMovement = StockMovement::create([
                    'stock_movement_id' => (string) Str::uuid(),
                    'reference' => $request->reference,
                    'movement_type_id' => $request->movement_type_id,
                    'entrepot_from_id' => $request->entrepot_from_id,
                    'entrepot_to_id' => $request->entrepot_to_id,
                    'fournisseur_id' => $request->fournisseur_id,
                    'client_id' => $request->client_id,
                    'statut' => $request->statut,
                    'note' => $request->note,
                    'user_id' => $request->user_id
                ]);

                // Créer les détails du mouvement
                foreach ($request->details as $detail) {
                    $stockMovement->details()->create([
                        'stock_movement_detail_id' => (string) Str::uuid(),
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity']
                    ]);
                }

                DB::commit();

                $stockMovement->load(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'details.product']);

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
     * Afficher un mouvement de stock spécifique
     */
    public function show(string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::with(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'details.product'])
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
                'reference' => 'required|string|max:255|unique:stock_movements,reference,' . $id . ',stock_movement_id',
                'movement_type_id' => 'required|exists:stock_movement_types,stock_movement_type_id',
                'entrepot_from_id' => 'nullable|exists:entrepots,entrepot_id',
                'entrepot_to_id' => 'nullable|exists:entrepots,entrepot_id',
                'fournisseur_id' => 'nullable|exists:fournisseurs,fournisseur_id',
                'client_id' => 'nullable|exists:clients,client_id',
                'statut' => 'required|in:pending,completed,cancelled',
                'note' => 'nullable|string|max:1000',
                'user_id' => 'required|exists:users,user_id',
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
                    'reference' => $request->reference,
                    'movement_type_id' => $request->movement_type_id,
                    'entrepot_from_id' => $request->entrepot_from_id,
                    'entrepot_to_id' => $request->entrepot_to_id,
                    'fournisseur_id' => $request->fournisseur_id,
                    'client_id' => $request->client_id,
                    'statut' => $request->statut,
                    'note' => $request->note,
                    'user_id' => $request->user_id
                ]);

                // Supprimer les anciens détails
                $stockMovement->details()->delete();

                // Créer les nouveaux détails
                foreach ($request->details as $detail) {
                    $stockMovement->details()->create([
                        'stock_movement_detail_id' => (string) Str::uuid(),
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity']
                    ]);
                }

                DB::commit();

                $stockMovement->load(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'details.product']);

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

            $stockMovement->load(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'details.product']);

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
                ->with(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'details.product'])
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
     * @group Stock Movements
     * 
     * Met à jour le statut d'un mouvement de stock
     * 
     * @urlParam id string required ID du mouvement de stock. Example: uuid
     * @bodyParam statut string required Nouveau statut (pending, completed, cancelled). Example: completed
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "uuid",
     *     "reference": "MV-2024-001",
     *     "statut": "completed",
     *     "movement_type": {
     *       "stock_movement_type_id": "uuid",
     *       "name": "Réception",
     *       "direction": "in"
     *     },
     *     "details": []
     *   },
     *   "message": "Statut du mouvement de stock mis à jour avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "statut": ["Le statut est obligatoire."]
     *   }
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

            $stockMovement->load(['movementType', 'entrepotFrom', 'entrepotTo', 'client', 'user', 'details.product']);

            return response()->json([
                'success' => true,
                'data' => $stockMovement,
                'message' => 'Statut du mouvement de stock mis à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
