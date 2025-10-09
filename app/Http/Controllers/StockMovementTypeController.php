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
     * Afficher la liste des types de mouvements de stock
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
     * Créer un nouveau type de mouvement de stock
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
     * Afficher un type de mouvement de stock spécifique
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
     * Mettre à jour un type de mouvement de stock
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
     * Supprimer un type de mouvement de stock (soft delete)
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
     * Restaurer un type de mouvement de stock supprimé
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
     * Lister les types de mouvements de stock supprimés
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
