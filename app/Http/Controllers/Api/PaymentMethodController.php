<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;

/**
 * @group Payment Methods Management
 *
 * APIs pour gérer les méthodes de paiement
 */
class PaymentMethodController extends Controller
{
    /**
     * Liste toutes les méthodes de paiement
     *
     * Récupère la liste de toutes les méthodes de paiement avec pagination et filtres optionnels.
     *
     * @queryParam page integer Page à récupérer (pagination). Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max: 100). Example: 15
     * @queryParam search string Recherche par nom de méthode de paiement. Example: Espèces
     * @queryParam is_active boolean Filtrer par statut actif. Example: true
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "payment_method_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "name": "Espèces",
     *       "is_active": true,
     *       "created_at": "2024-01-15T10:30:00Z",
     *       "updated_at": "2024-01-15T10:30:00Z"
     *     },
     *     {
     *       "payment_method_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "name": "Carte bancaire",
     *       "is_active": true,
     *       "created_at": "2024-01-15T10:30:00Z",
     *       "updated_at": "2024-01-15T10:30:00Z"
     *     }
     *   ],
     *   "meta": {
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 2
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'search' => 'string|max:255',
            'is_active' => 'boolean',
        ]);

        $query = PaymentMethod::query();

        // Recherche par nom
        if (isset($validated['search'])) {
            $query->where('name', 'like', "%{$validated['search']}%");
        }

        // Filtre par statut
        if (isset($validated['is_active'])) {
            $query->where('is_active', $validated['is_active']);
        }

        $perPage = $validated['per_page'] ?? 15;
        $paymentMethods = $query->orderBy('name')->paginate($perPage);

        return response()->json($paymentMethods);
    }

    /**
     * Créer une nouvelle méthode de paiement
     *
     * Crée une nouvelle méthode de paiement avec les informations fournies.
     *
     * @bodyParam name string required Nom de la méthode de paiement. Example: Mobile Money
     * @bodyParam is_active boolean optionnel Statut actif de la méthode (défaut: true). Example: true
     *
     * @response 201 {
     *   "data": {
     *     "payment_method_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "name": "Mobile Money",
     *     "is_active": true,
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T10:30:00Z"
     *   },
     *   "message": "Méthode de paiement créée avec succès"
     * }
     * @response 422 {
     *   "message": "Données de validation échouées",
     *   "errors": {
     *     "name": ["Le nom de la méthode de paiement est requis"]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Le nom de la méthode de paiement est requis',
            'name.unique' => 'Cette méthode de paiement existe déjà',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères',
        ]);

        $paymentMethod = PaymentMethod::create($validated);

        return response()->json([
            'data' => $paymentMethod,
            'message' => 'Méthode de paiement créée avec succès'
        ], 201);
    }

    /**
     * Afficher une méthode de paiement spécifique
     *
     * Récupère les détails d'une méthode de paiement par son ID.
     *
     * @urlParam id string required L'UUID de la méthode de paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "data": {
     *     "payment_method_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "name": "Mobile Money",
     *     "is_active": true,
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T10:30:00Z"
     *   }
     * }
     * @response 404 {
     *   "message": "Méthode de paiement non trouvée"
     * }
     */
    public function show(string $id): JsonResponse
    {
        try {
            $paymentMethod = PaymentMethod::where('payment_method_id', $id)->firstOrFail();

            return response()->json([
                'data' => $paymentMethod
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Méthode de paiement non trouvée'
            ], 404);
        }
    }

    /**
     * Mettre à jour une méthode de paiement
     *
     * Met à jour les informations d'une méthode de paiement existante.
     *
     * @urlParam id string required L'UUID de la méthode de paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam name string Nom de la méthode de paiement. Example: Carte de crédit
     * @bodyParam is_active boolean Statut actif de la méthode. Example: false
     *
     * @response 200 {
     *   "data": {
     *     "payment_method_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "name": "Carte de crédit",
     *     "is_active": false,
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T11:00:00Z"
     *   },
     *   "message": "Méthode de paiement mise à jour avec succès"
     * }
     * @response 404 {
     *   "message": "Méthode de paiement non trouvée"
     * }
     * @response 422 {
     *   "message": "Données de validation échouées",
     *   "errors": {
     *     "name": ["Cette méthode de paiement existe déjà"]
     *   }
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $paymentMethod = PaymentMethod::where('payment_method_id', $id)->firstOrFail();

            $validated = $request->validate([
                'name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('payment_methods', 'name')->ignore($paymentMethod->payment_method_id, 'payment_method_id')
                ],
                'is_active' => 'boolean',
            ], [
                'name.unique' => 'Cette méthode de paiement existe déjà',
                'name.max' => 'Le nom ne peut pas dépasser 255 caractères',
            ]);

            $paymentMethod->update($validated);

            return response()->json([
                'data' => $paymentMethod->fresh(),
                'message' => 'Méthode de paiement mise à jour avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Méthode de paiement non trouvée'
            ], 404);
        }
    }

    /**
     * Supprimer une méthode de paiement
     *
     * Supprime définitivement une méthode de paiement.
     * Attention: Cette action est irréversible.
     *
     * @urlParam id string required L'UUID de la méthode de paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "message": "Méthode de paiement supprimée avec succès"
     * }
     * @response 404 {
     *   "message": "Méthode de paiement non trouvée"
     * }
     * @response 400 {
     *   "message": "Impossible de supprimer cette méthode de paiement car elle est utilisée dans des paiements existants"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $paymentMethod = PaymentMethod::where('payment_method_id', $id)->firstOrFail();

            // Vérifier si la méthode est utilisée dans des paiements
            if ($paymentMethod->paiements()->exists()) {
                return response()->json([
                    'message' => 'Impossible de supprimer cette méthode de paiement car elle est utilisée dans des paiements existants'
                ], 400);
            }

            $paymentMethod->delete();

            return response()->json([
                'message' => 'Méthode de paiement supprimée avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Méthode de paiement non trouvée'
            ], 404);
        }
    }

    /**
     * Activer/Désactiver une méthode de paiement
     *
     * Change le statut actif d'une méthode de paiement.
     *
     * @urlParam id string required L'UUID de la méthode de paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam is_active boolean required Nouveau statut actif. Example: false
     *
     * @response 200 {
     *   "data": {
     *     "payment_method_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "is_active": false
     *   },
     *   "message": "Statut de la méthode de paiement mis à jour avec succès"
     * }
     * @response 404 {
     *   "message": "Méthode de paiement non trouvée"
     * }
     */
    public function toggleStatus(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean'
        ]);

        try {
            $paymentMethod = PaymentMethod::where('payment_method_id', $id)->firstOrFail();
            $paymentMethod->update(['is_active' => $validated['is_active']]);

            return response()->json([
                'data' => [
                    'payment_method_id' => $paymentMethod->payment_method_id,
                    'is_active' => $paymentMethod->is_active
                ],
                'message' => 'Statut de la méthode de paiement mis à jour avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Méthode de paiement non trouvée'
            ], 404);
        }
    }

    /**
     * Statistiques des méthodes de paiement
     *
     * Récupère des statistiques sur les méthodes de paiement.
     *
     * @response 200 {
     *   "data": {
     *     "total_payment_methods": 5,
     *     "active_payment_methods": 4,
     *     "inactive_payment_methods": 1,
     *     "most_used_payment_method": {
     *       "payment_method_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "name": "Espèces",
     *       "usage_count": 125
     *     }
     *   }
     * }
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_payment_methods' => PaymentMethod::count(),
            'active_payment_methods' => PaymentMethod::where('is_active', true)->count(),
            'inactive_payment_methods' => PaymentMethod::where('is_active', false)->count(),
        ];

        // Méthode de paiement la plus utilisée
        $mostUsed = PaymentMethod::withCount('paiements')
            ->orderBy('paiements_count', 'desc')
            ->first();

        if ($mostUsed) {
            $stats['most_used_payment_method'] = [
                'payment_method_id' => $mostUsed->payment_method_id,
                'name' => $mostUsed->name,
                'usage_count' => $mostUsed->paiements_count
            ];
        }

        return response()->json([
            'data' => $stats
        ]);
    }
}
