<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @group Gestion des Stocks
 *
 * APIs pour la gestion des stocks de produits dans les entrepôts
 */
class StockController extends Controller
{
    /**
     * Lister tous les stocks
     *
     * Récupère la liste de tous les stocks avec pagination et filtres optionnels
     *
     * @queryParam page int Numéro de la page. Example: 1
     * @queryParam per_page int Nombre d'éléments par page (max 100). Example: 15
     * @queryParam product_id string Filtrer par ID du produit. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam entrepot_id string Filtrer par ID de l'entrepôt. Example: 550e8400-e29b-41d4-a716-446655440001
     * @queryParam quantite_min int Quantité minimum. Example: 10
     * @queryParam quantite_max int Quantité maximum. Example: 100
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "stock_id": "550e8400-e29b-41d4-a716-446655440000",
     *         "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *         "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *         "quantite": 50,
     *         "reserved_quantity": 5,
     *         "available_quantity": 45,
     *         "created_at": "2024-01-15T10:30:00.000000Z",
     *         "updated_at": "2024-01-15T10:30:00.000000Z",
     *         "product": {
     *           "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *           "name": "Produit Example"
     *         },
     *         "entrepot": {
     *           "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *           "name": "Entrepôt Principal"
     *         }
     *       }
     *     ],
     *     "per_page": 15,
     *     "total": 1
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'product_id' => 'string|uuid',
            'entrepot_id' => 'string|uuid',
            'quantite_min' => 'integer|min:0',
            'quantite_max' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Paramètres invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Stock::with(['product', 'entrepot']);

        // Filtres
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('entrepot_id')) {
            $query->where('entrepot_id', $request->entrepot_id);
        }

        if ($request->filled('quantite_min')) {
            $query->where('quantite', '>=', $request->quantite_min);
        }

        if ($request->filled('quantite_max')) {
            $query->where('quantite', '<=', $request->quantite_max);
        }

        $perPage = $request->get('per_page', 15);
        $stocks = $query->paginate($perPage);

        // Ajouter la quantité disponible
        $stocks->getCollection()->transform(function ($stock) {
            $stock->available_quantity = $stock->quantite - $stock->reserved_quantity;
            return $stock;
        });

        return response()->json([
            'success' => true,
            'data' => $stocks
        ]);
    }

    /**
     * Afficher un stock spécifique
     *
     * Récupère les détails d'un stock par son ID
     *
     * @urlParam stock_id string required L'ID du stock. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "quantite": 50,
     *     "reserved_quantity": 5,
     *     "available_quantity": 45,
     *     "created_at": "2024-01-15T10:30:00.000000Z",
     *     "updated_at": "2024-01-15T10:30:00.000000Z",
     *     "product": {
     *       "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "name": "Produit Example"
     *     },
     *     "entrepot": {
     *       "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *       "name": "Entrepôt Principal"
     *     }
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Stock non trouvé"
     * }
     */
    public function show(string $stock_id): JsonResponse
    {
        try {
            $stock = Stock::with(['product', 'entrepot'])->findOrFail($stock_id);
            $stock->available_quantity = $stock->quantite - $stock->reserved_quantity;

            return response()->json([
                'success' => true,
                'data' => $stock
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stock non trouvé'
            ], 404);
        }
    }

    /**
     * Créer un nouveau stock
     *
     * Crée un nouveau stock pour un produit dans un entrepôt
     *
     * @bodyParam product_id string required L'ID du produit. Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam entrepot_id string required L'ID de l'entrepôt. Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam quantite integer required La quantité en stock. Example: 100
     * @bodyParam reserved_quantity integer La quantité réservée (optionnel, défaut: 0). Example: 10
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Stock créé avec succès",
     *   "data": {
     *     "stock_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "quantite": 100,
     *     "reserved_quantity": 10,
     *     "available_quantity": 90,
     *     "created_at": "2024-01-15T10:30:00.000000Z",
     *     "updated_at": "2024-01-15T10:30:00.000000Z"
     *   }
     * }
     *
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "product_id": ["Le champ product_id est requis."]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|string|uuid|exists:products,product_id',
            'entrepot_id' => 'required|string|uuid|exists:entrepots,entrepot_id',
            'quantite' => 'required|integer|min:0',
            'reserved_quantity' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Vérifier si le stock existe déjà pour ce produit et cet entrepôt
        $existingStock = Stock::where('product_id', $request->product_id)
            ->where('entrepot_id', $request->entrepot_id)
            ->first();

        if ($existingStock) {
            return response()->json([
                'success' => false,
                'message' => 'Un stock existe déjà pour ce produit dans cet entrepôt'
            ], 409);
        }

        $stock = Stock::create($request->all());
        $stock->available_quantity = $stock->quantite - $stock->reserved_quantity;

        return response()->json([
            'success' => true,
            'message' => 'Stock créé avec succès',
            'data' => $stock
        ], 201);
    }

    /**
     * Mettre à jour un stock
     *
     * Met à jour les informations d'un stock existant
     *
     * @urlParam stock_id string required L'ID du stock. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam quantite integer La nouvelle quantité en stock. Example: 75
     * @bodyParam reserved_quantity integer La nouvelle quantité réservée. Example: 15
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Stock mis à jour avec succès",
     *   "data": {
     *     "stock_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "quantite": 75,
     *     "reserved_quantity": 15,
     *     "available_quantity": 60,
     *     "created_at": "2024-01-15T10:30:00.000000Z",
     *     "updated_at": "2024-01-15T11:45:00.000000Z"
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Stock non trouvé"
     * }
     */
    public function update(Request $request, string $stock_id): JsonResponse
    {
        try {
            $stock = Stock::findOrFail($stock_id);

            $validator = Validator::make($request->all(), [
                'quantite' => 'integer|min:0',
                'reserved_quantity' => 'integer|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $stock->update($request->only(['quantite', 'reserved_quantity']));
            $stock->available_quantity = $stock->quantite - $stock->reserved_quantity;

            return response()->json([
                'success' => true,
                'message' => 'Stock mis à jour avec succès',
                'data' => $stock
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stock non trouvé'
            ], 404);
        }
    }

    /**
     * Supprimer un stock
     *
     * Supprime un stock de manière définitive
     *
     * @urlParam stock_id string required L'ID du stock à supprimer. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Stock supprimé avec succès"
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Stock non trouvé"
     * }
     */
    public function destroy(string $stock_id): JsonResponse
    {
        try {
            $stock = Stock::findOrFail($stock_id);
            $stock->delete();

            return response()->json([
                'success' => true,
                'message' => 'Stock supprimé avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stock non trouvé'
            ], 404);
        }
    }

    /**
     * Ajuster la quantité en stock
     *
     * Ajuste la quantité d'un stock (ajout ou retrait)
     *
     * @urlParam stock_id string required L'ID du stock. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam adjustment integer required L'ajustement à appliquer (positif pour ajout, négatif pour retrait). Example: -10
     * @bodyParam reason string La raison de l'ajustement. Example: "Inventaire physique"
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Quantité ajustée avec succès",
     *   "data": {
     *     "stock_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "quantite": 40,
     *     "reserved_quantity": 5,
     *     "available_quantity": 35,
     *     "previous_quantity": 50,
     *     "adjustment": -10,
     *     "reason": "Inventaire physique"
     *   }
     * }
     *
     * @response 422 {
     *   "success": false,
     *   "message": "Quantité insuffisante pour cet ajustement"
     * }
     */
    public function adjustQuantity(Request $request, string $stock_id): JsonResponse
    {
        try {
            $stock = Stock::findOrFail($stock_id);

            $validator = Validator::make($request->all(), [
                'adjustment' => 'required|integer',
                'reason' => 'string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $previousQuantity = $stock->quantite;
            $newQuantity = $previousQuantity + $request->adjustment;

            if ($newQuantity < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantité insuffisante pour cet ajustement'
                ], 422);
            }

            $stock->update(['quantite' => $newQuantity]);

            return response()->json([
                'success' => true,
                'message' => 'Quantité ajustée avec succès',
                'data' => [
                    'stock_id' => $stock->stock_id,
                    'product_id' => $stock->product_id,
                    'entrepot_id' => $stock->entrepot_id,
                    'quantite' => $stock->quantite,
                    'reserved_quantity' => $stock->reserved_quantity,
                    'available_quantity' => $stock->quantite - $stock->reserved_quantity,
                    'previous_quantity' => $previousQuantity,
                    'adjustment' => $request->adjustment,
                    'reason' => $request->reason
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stock non trouvé'
            ], 404);
        }
    }

    /**
     * Réserver une quantité
     *
     * Réserve une quantité spécifique du stock
     *
     * @urlParam stock_id string required L'ID du stock. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam quantity integer required La quantité à réserver. Example: 5
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Quantité réservée avec succès",
     *   "data": {
     *     "stock_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "quantite": 50,
     *     "reserved_quantity": 10,
     *     "available_quantity": 40
     *   }
     * }
     *
     * @response 422 {
     *   "success": false,
     *   "message": "Quantité disponible insuffisante"
     * }
     */
    public function reserve(Request $request, string $stock_id): JsonResponse
    {
        try {
            $stock = Stock::findOrFail($stock_id);

            $validator = Validator::make($request->all(), [
                'quantity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $availableQuantity = $stock->quantite - $stock->reserved_quantity;

            if ($request->quantity > $availableQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantité disponible insuffisante'
                ], 422);
            }

            $stock->update([
                'reserved_quantity' => $stock->reserved_quantity + $request->quantity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quantité réservée avec succès',
                'data' => [
                    'stock_id' => $stock->stock_id,
                    'quantite' => $stock->quantite,
                    'reserved_quantity' => $stock->reserved_quantity,
                    'available_quantity' => $stock->quantite - $stock->reserved_quantity
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stock non trouvé'
            ], 404);
        }
    }

    /**
     * Libérer une réservation
     *
     * Libère une quantité réservée du stock
     *
     * @urlParam stock_id string required L'ID du stock. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam quantity integer required La quantité à libérer. Example: 3
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Réservation libérée avec succès",
     *   "data": {
     *     "stock_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "quantite": 50,
     *     "reserved_quantity": 7,
     *     "available_quantity": 43
     *   }
     * }
     *
     * @response 422 {
     *   "success": false,
     *   "message": "Quantité réservée insuffisante"
     * }
     */
    public function release(Request $request, string $stock_id): JsonResponse
    {
        try {
            $stock = Stock::findOrFail($stock_id);

            $validator = Validator::make($request->all(), [
                'quantity' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->quantity > $stock->reserved_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantité réservée insuffisante'
                ], 422);
            }

            $stock->update([
                'reserved_quantity' => $stock->reserved_quantity - $request->quantity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Réservation libérée avec succès',
                'data' => [
                    'stock_id' => $stock->stock_id,
                    'quantite' => $stock->quantite,
                    'reserved_quantity' => $stock->reserved_quantity,
                    'available_quantity' => $stock->quantite - $stock->reserved_quantity
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stock non trouvé'
            ], 404);
        }
    }

    /**
     * Stocks par produit
     *
     * Récupère tous les stocks d'un produit spécifique
     *
     * @urlParam productId string required L'ID du produit. Example: 550e8400-e29b-41d4-a716-446655440001
     *
     * @response 200 {
     *   "success": true,
     *   "data": [
     *     {
     *       "stock_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *       "quantite": 50,
     *       "reserved_quantity": 5,
     *       "available_quantity": 45,
     *       "entrepot": {
     *         "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *         "name": "Entrepôt Principal"
     *       }
     *     }
     *   ]
     * }
     */
    public function byProduct(string $productId): JsonResponse
    {
        $stocks = Stock::with('entrepot')
            ->where('product_id', $productId)
            ->get();

        $stocks->transform(function ($stock) {
            $stock->available_quantity = $stock->quantite - $stock->reserved_quantity;
            return $stock;
        });

        return response()->json([
            'success' => true,
            'data' => $stocks
        ]);
    }

    /**
     * Stocks par entrepôt
     *
     * Récupère tous les stocks d'un entrepôt spécifique
     *
     * @urlParam entrepotId string required L'ID de l'entrepôt. Example: 550e8400-e29b-41d4-a716-446655440002
     *
     * @response 200 {
     *   "success": true,
     *   "data": [
     *     {
     *       "stock_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *       "quantite": 50,
     *       "reserved_quantity": 5,
     *       "available_quantity": 45,
     *       "product": {
     *         "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *         "name": "Produit Example"
     *       }
     *     }
     *   ]
     * }
     */
    public function byEntrepot(string $entrepotId): JsonResponse
    {
        $stocks = Stock::with('product')
            ->where('entrepot_id', $entrepotId)
            ->get();

        $stocks->transform(function ($stock) {
            $stock->available_quantity = $stock->quantite - $stock->reserved_quantity;
            return $stock;
        });

        return response()->json([
            'success' => true,
            'data' => $stocks
        ]);
    }

    /**
     * Restaurer un stock supprimé
     *
     * Restaure un stock qui a été supprimé de manière logique
     *
     * @urlParam id string required L'ID du stock à restaurer. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Stock restauré avec succès",
     *   "data": {
     *     "stock_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "product_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "quantite": 50,
     *     "reserved_quantity": 5,
     *     "available_quantity": 45
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Stock non trouvé"
     * }
     */
    public function restore(string $id): JsonResponse
    {
        try {
            $stock = Stock::withTrashed()->findOrFail($id);

            if (!$stock->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce stock n\'est pas supprimé'
                ], 400);
            }

            $stock->restore();
            $stock->available_quantity = $stock->quantite - $stock->reserved_quantity;

            return response()->json([
                'success' => true,
                'message' => 'Stock restauré avec succès',
                'data' => $stock
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stock non trouvé'
            ], 404);
        }
    }

    /**
     * Suppression définitive d'un stock
     *
     * Supprime définitivement un stock de la base de données
     *
     * @urlParam id string required L'ID du stock à supprimer définitivement. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Stock supprimé définitivement"
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Stock non trouvé"
     * }
     */
    public function forceDelete(string $id): JsonResponse
    {
        try {
            $stock = Stock::withTrashed()->findOrFail($id);
            $stock->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Stock supprimé définitivement'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stock non trouvé'
            ], 404);
        }
    }
}
