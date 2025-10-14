<?php

namespace App\Http\Controllers;

use App\Models\StockMovementType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StockMovementTypeController extends Controller
{
    /**
<<<<<<< HEAD
     * @group Stock Movement Types
     * 
     * Récupère la liste des types de mouvements de stock
     * 
     * @queryParam direction string Filtrer par direction (in, out, transfer). Example: in
     * @queryParam search string Rechercher par nom. Example: Réception
     * @queryParam sort_by string Champ de tri. Example: created_at
     * @queryParam sort_order string Ordre de tri (asc, desc). Example: desc
     * @queryParam per_page integer Nombre d'éléments par page. Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "stock_movement_type_id": "uuid",
     *         "name": "Réception",
     *         "direction": "in",
     *         "created_at": "2024-01-01 10:00:00",
     *         "updated_at": "2024-01-01 10:00:00",
     *         "stock_movements_count": 5
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 1
     *   },
     *   "message": "Types de mouvements de stock récupérés avec succès"
     * }
     * 
     * @response 500 {
     *   "success": false,
     *   "message": "Erreur lors de la récupération des types de mouvements de stock",
     *   "error": "Message d'erreur"
     * }
=======
     * Afficher la liste des types de mouvements de stock
>>>>>>> 1c81847c9bdb851e44db291266c5769bded4c228
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = StockMovementType::query();

            // Filtrage par direction si fourni
            if ($request->has('direction')) {
                $query->where('direction', $request->direction);
            }

            // Recherche par nom si fourni
            if ($request->has('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            // Tri
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Pagination
            $perPage = $request->get('per_page', 15);
            $stockMovementTypes = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $stockMovementTypes,
                'message' => 'Types de mouvements de stock récupérés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des types de mouvements de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
<<<<<<< HEAD
     * @group Stock Movement Types
     * 
     * Crée un nouveau type de mouvement de stock
     * 
     * @bodyParam name string required Nom du type de mouvement. Example: Réception
     * @bodyParam direction string required Direction du mouvement (in, out, transfer). Example: in
     * 
     * @response 201 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_type_id": "uuid",
     *     "name": "Réception",
     *     "direction": "in",
     *     "created_at": "2024-01-01 10:00:00",
     *     "updated_at": "2024-01-01 10:00:00"
     *   },
     *   "message": "Type de mouvement de stock créé avec succès"
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "name": ["Le nom du type de mouvement est obligatoire."],
     *     "direction": ["La direction est obligatoire."]
     *   }
     * }
=======
     * Créer un nouveau type de mouvement de stock
>>>>>>> 1c81847c9bdb851e44db291266c5769bded4c228
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:stock_movement_types,name',
                'direction' => 'required|in:in,out,transfer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $stockMovementType = StockMovementType::create([
                'stock_movement_type_id' => (string) Str::uuid(),
                'name' => $request->name,
                'direction' => $request->direction
            ]);

            return response()->json([
                'success' => true,
                'data' => $stockMovementType,
                'message' => 'Type de mouvement de stock créé avec succès'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du type de mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
<<<<<<< HEAD
     * @group Stock Movement Types
     * 
     * Récupère un type de mouvement de stock spécifique
     * 
     * @urlParam id string required ID du type de mouvement de stock. Example: uuid
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_type_id": "uuid",
     *     "name": "Réception",
     *     "direction": "in",
     *     "created_at": "2024-01-01 10:00:00",
     *     "updated_at": "2024-01-01 10:00:00",
     *     "stock_movements_count": 5
     *   },
     *   "message": "Type de mouvement de stock récupéré avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Type de mouvement de stock non trouvé"
     * }
=======
     * Afficher un type de mouvement de stock spécifique
>>>>>>> 1c81847c9bdb851e44db291266c5769bded4c228
     */
    public function show(string $id): JsonResponse
    {
        try {
            $stockMovementType = StockMovementType::find($id);

            if (!$stockMovementType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type de mouvement de stock non trouvé'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $stockMovementType,
                'message' => 'Type de mouvement de stock récupéré avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du type de mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
<<<<<<< HEAD
     * @group Stock Movement Types
     * 
     * Met à jour un type de mouvement de stock
     * 
     * @urlParam id string required ID du type de mouvement de stock. Example: uuid
     * @bodyParam name string required Nom du type de mouvement. Example: Réception
     * @bodyParam direction string required Direction du mouvement (in, out, transfer). Example: in
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_type_id": "uuid",
     *     "name": "Réception",
     *     "direction": "in",
     *     "created_at": "2024-01-01 10:00:00",
     *     "updated_at": "2024-01-01 10:00:00"
     *   },
     *   "message": "Type de mouvement de stock mis à jour avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Type de mouvement de stock non trouvé"
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "name": ["Le nom du type de mouvement est obligatoire."]
     *   }
     * }
=======
     * Mettre à jour un type de mouvement de stock
>>>>>>> 1c81847c9bdb851e44db291266c5769bded4c228
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $stockMovementType = StockMovementType::find($id);

            if (!$stockMovementType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type de mouvement de stock non trouvé'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:stock_movement_types,name,' . $id . ',stock_movement_type_id',
                'direction' => 'required|in:in,out,transfer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $stockMovementType->update([
                'name' => $request->name,
                'direction' => $request->direction
            ]);

            return response()->json([
                'success' => true,
                'data' => $stockMovementType,
                'message' => 'Type de mouvement de stock mis à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du type de mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
<<<<<<< HEAD
     * @group Stock Movement Types
     * 
     * Supprime un type de mouvement de stock (soft delete)
     * 
     * @urlParam id string required ID du type de mouvement de stock. Example: uuid
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Type de mouvement de stock supprimé avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Type de mouvement de stock non trouvé"
     * }
=======
     * Supprimer un type de mouvement de stock (soft delete)
>>>>>>> 1c81847c9bdb851e44db291266c5769bded4c228
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $stockMovementType = StockMovementType::find($id);

            if (!$stockMovementType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type de mouvement de stock non trouvé'
                ], 404);
            }

            $stockMovementType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Type de mouvement de stock supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du type de mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
<<<<<<< HEAD
     * @group Stock Movement Types
     * 
     * Restaure un type de mouvement de stock supprimé
     * 
     * @urlParam id string required ID du type de mouvement de stock. Example: uuid
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_type_id": "uuid",
     *     "name": "Réception",
     *     "direction": "in",
     *     "created_at": "2024-01-01 10:00:00",
     *     "updated_at": "2024-01-01 10:00:00"
     *   },
     *   "message": "Type de mouvement de stock restauré avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Type de mouvement de stock non trouvé"
     * }
     * 
     * @response 400 {
     *   "success": false,
     *   "message": "Ce type de mouvement de stock n'est pas supprimé"
     * }
=======
     * Restaurer un type de mouvement de stock supprimé
>>>>>>> 1c81847c9bdb851e44db291266c5769bded4c228
     */
    public function restore(string $id): JsonResponse
    {
        try {
            $stockMovementType = StockMovementType::withTrashed()->find($id);

            if (!$stockMovementType) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type de mouvement de stock non trouvé'
                ], 404);
            }

            if (!$stockMovementType->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce type de mouvement de stock n\'est pas supprimé'
                ], 400);
            }

            $stockMovementType->restore();

            return response()->json([
                'success' => true,
                'data' => $stockMovementType,
                'message' => 'Type de mouvement de stock restauré avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration du type de mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
<<<<<<< HEAD
     * @group Stock Movement Types
     * 
     * Récupère la liste des types de mouvements de stock supprimés
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "stock_movement_type_id": "uuid",
     *         "name": "Réception",
     *         "direction": "in",
     *         "created_at": "2024-01-01 10:00:00",
     *         "updated_at": "2024-01-01 10:00:00",
     *         "deleted_at": "2024-01-01 12:00:00"
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 1
     *   },
     *   "message": "Types de mouvements de stock supprimés récupérés avec succès"
     * }
=======
     * Lister les types de mouvements de stock supprimés
>>>>>>> 1c81847c9bdb851e44db291266c5769bded4c228
     */
    public function trashed(): JsonResponse
    {
        try {
            $stockMovementTypes = StockMovementType::onlyTrashed()->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $stockMovementTypes,
                'message' => 'Types de mouvements de stock supprimés récupérés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des types de mouvements de stock supprimés',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}