<?php

namespace App\Http\Controllers;

use App\Models\StockMovementDetail;
use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StockMovementDetailController extends Controller
{
    /**
     * @group Stock Movement Details
     * 
     * Récupère la liste des détails de mouvements de stock
     * 
     * @queryParam stock_movement_id string Filtrer par mouvement de stock. Example: uuid
     * @queryParam product_id string Filtrer par produit. Example: uuid
     * @queryParam quantity_min integer Filtrer par quantité minimale. Example: 1
     * @queryParam quantity_max integer Filtrer par quantité maximale. Example: 100
     * @queryParam sort_by string Champ de tri. Example: created_at
     * @queryParam sort_order string Ordre de tri (asc, desc). Example: desc
     * @queryParam per_page integer Nombre d'éléments par page. Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "stock_movement_detail_id": "uuid",
     *         "stock_movement_id": "uuid",
     *         "product_id": "uuid",
     *         "quantity": 10,
     *         "created_at": "2024-01-01 10:00:00",
     *         "updated_at": "2024-01-01 10:00:00",
     *         "stock_movement": {
     *           "stock_movement_id": "uuid",
     *           "reference": "MV-2024-001",
     *           "movement_type": {
     *             "name": "Réception",
     *             "direction": "in"
     *           }
     *         },
     *         "product": {
     *           "product_id": "uuid",
     *           "name": "Produit A",
     *           "sku": "PROD-A-001"
     *         }
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 1
     *   },
     *   "message": "Détails de mouvements de stock récupérés avec succès"
     * }
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = StockMovementDetail::with(['stockMovement.movementType', 'product']);

            // Filtrage par mouvement de stock
            if ($request->has('stock_movement_id')) {
                $query->where('stock_movement_id', $request->stock_movement_id);
            }

            // Filtrage par produit
            if ($request->has('product_id')) {
                $query->where('product_id', $request->product_id);
            }

            // Filtrage par quantité minimale
            if ($request->has('quantity_min')) {
                $query->where('quantity', '>=', $request->quantity_min);
            }

            // Filtrage par quantité maximale
            if ($request->has('quantity_max')) {
                $query->where('quantity', '<=', $request->quantity_max);
            }

            // Tri
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Pagination
            $perPage = $request->get('per_page', 15);
            $stockMovementDetails = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $stockMovementDetails,
                'message' => 'Détails de mouvements de stock récupérés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails de mouvements de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movement Details
     * 
     * Crée un nouveau détail de mouvement de stock
     * 
     * @bodyParam stock_movement_id string required ID du mouvement de stock. Example: uuid
     * @bodyParam product_id string required ID du produit. Example: uuid
     * @bodyParam quantity integer required Quantité (minimum 1). Example: 10
     * 
     * @response 201 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_detail_id": "uuid",
     *     "stock_movement_id": "uuid",
     *     "product_id": "uuid",
     *     "quantity": 10,
     *     "created_at": "2024-01-01 10:00:00",
     *     "updated_at": "2024-01-01 10:00:00",
     *     "stock_movement": {
     *       "stock_movement_id": "uuid",
     *       "reference": "MV-2024-001",
     *       "movement_type": {
     *         "name": "Réception",
     *         "direction": "in"
     *       }
     *     },
     *     "product": {
     *       "product_id": "uuid",
     *       "name": "Produit A",
     *       "sku": "PROD-A-001"
     *     }
     *   },
     *   "message": "Détail de mouvement de stock créé avec succès"
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
     *     "stock_movement_id": ["Le mouvement de stock est obligatoire."],
     *     "product_id": ["Le produit est obligatoire."],
     *     "quantity": ["La quantité est obligatoire."]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'stock_movement_id' => 'required|exists:stock_movements,stock_movement_id',
                'product_id' => 'required|exists:products,product_id',
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Vérifier que le mouvement de stock existe et n'est pas supprimé
            $stockMovement = StockMovement::find($request->stock_movement_id);
            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            $stockMovementDetail = StockMovementDetail::create([
                'stock_movement_detail_id' => (string) Str::uuid(),
                'stock_movement_id' => $request->stock_movement_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);

            $stockMovementDetail->load(['stockMovement.movementType', 'product']);

            return response()->json([
                'success' => true,
                'data' => $stockMovementDetail,
                'message' => 'Détail de mouvement de stock créé avec succès'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du détail de mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un détail de mouvement de stock spécifique
     */
    public function show(string $id): JsonResponse
    {
        try {
            $stockMovementDetail = StockMovementDetail::with(['stockMovement.movementType', 'product'])
                ->find($id);

            if (!$stockMovementDetail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail de mouvement de stock non trouvé'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $stockMovementDetail,
                'message' => 'Détail de mouvement de stock récupéré avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du détail de mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour un détail de mouvement de stock
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $stockMovementDetail = StockMovementDetail::find($id);

            if (!$stockMovementDetail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail de mouvement de stock non trouvé'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'stock_movement_id' => 'required|exists:stock_movements,stock_movement_id',
                'product_id' => 'required|exists:products,product_id',
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Vérifier que le mouvement de stock existe et n'est pas supprimé
            $stockMovement = StockMovement::find($request->stock_movement_id);
            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            $stockMovementDetail->update([
                'stock_movement_id' => $request->stock_movement_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);

            $stockMovementDetail->load(['stockMovement.movementType', 'product']);

            return response()->json([
                'success' => true,
                'data' => $stockMovementDetail,
                'message' => 'Détail de mouvement de stock mis à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du détail de mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un détail de mouvement de stock (soft delete)
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $stockMovementDetail = StockMovementDetail::find($id);

            if (!$stockMovementDetail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail de mouvement de stock non trouvé'
                ], 404);
            }

            $stockMovementDetail->delete();

            return response()->json([
                'success' => true,
                'message' => 'Détail de mouvement de stock supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du détail de mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restaurer un détail de mouvement de stock supprimé
     */
    public function restore(string $id): JsonResponse
    {
        try {
            $stockMovementDetail = StockMovementDetail::withTrashed()->find($id);

            if (!$stockMovementDetail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Détail de mouvement de stock non trouvé'
                ], 404);
            }

            if (!$stockMovementDetail->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce détail de mouvement de stock n\'est pas supprimé'
                ], 400);
            }

            $stockMovementDetail->restore();

            $stockMovementDetail->load(['stockMovement.movementType', 'product']);

            return response()->json([
                'success' => true,
                'data' => $stockMovementDetail,
                'message' => 'Détail de mouvement de stock restauré avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration du détail de mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lister les détails de mouvements de stock supprimés
     */
    public function trashed(): JsonResponse
    {
        try {
            $stockMovementDetails = StockMovementDetail::onlyTrashed()
                ->with(['stockMovement.movementType', 'product'])
                ->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $stockMovementDetails,
                'message' => 'Détails de mouvements de stock supprimés récupérés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails de mouvements de stock supprimés',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movement Details
     * 
     * Récupère tous les détails d'un mouvement de stock spécifique
     * 
     * @urlParam stockMovementId string required ID du mouvement de stock. Example: uuid
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "stock_movement_detail_id": "uuid",
     *         "stock_movement_id": "uuid",
     *         "product_id": "uuid",
     *         "quantity": 10,
     *         "created_at": "2024-01-01 10:00:00",
     *         "updated_at": "2024-01-01 10:00:00",
     *         "product": {
     *           "product_id": "uuid",
     *           "name": "Produit A",
     *           "sku": "PROD-A-001"
     *         }
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 1
     *   },
     *   "message": "Détails du mouvement de stock récupérés avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     */
    public function byStockMovement(string $stockMovementId): JsonResponse
    {
        try {
            $stockMovement = StockMovement::find($stockMovementId);
            
            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            $stockMovementDetails = StockMovementDetail::with(['product'])
                ->where('stock_movement_id', $stockMovementId)
                ->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $stockMovementDetails,
                'message' => 'Détails du mouvement de stock récupérés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movement Details
     * 
     * Récupère tous les détails de mouvements pour un produit spécifique
     * 
     * @urlParam productId string required ID du produit. Example: uuid
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "stock_movement_detail_id": "uuid",
     *         "stock_movement_id": "uuid",
     *         "product_id": "uuid",
     *         "quantity": 10,
     *         "created_at": "2024-01-01 10:00:00",
     *         "updated_at": "2024-01-01 10:00:00",
     *         "stock_movement": {
     *           "stock_movement_id": "uuid",
     *           "reference": "MV-2024-001",
     *           "movement_type": {
     *             "name": "Réception",
     *             "direction": "in"
     *           }
     *         }
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 1
     *   },
     *   "message": "Détails de mouvements du produit récupérés avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Produit non trouvé"
     * }
     */
    public function byProduct(string $productId): JsonResponse
    {
        try {
            $product = Product::find($productId);
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produit non trouvé'
                ], 404);
            }

            $stockMovementDetails = StockMovementDetail::with(['stockMovement.movementType'])
                ->where('product_id', $productId)
                ->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $stockMovementDetails,
                'message' => 'Détails de mouvements du produit récupérés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails de mouvements du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
