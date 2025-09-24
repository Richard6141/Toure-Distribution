<?php

namespace App\Http\Controllers;

use App\Models\ClientType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @group Client Types Management
 *
 * APIs pour gérer les types de clients
 */
class ClientTypeController extends Controller
{
    /**
     * Liste tous les types de clients
     *
     * Récupère la liste de tous les types de clients avec pagination optionnelle.
     * Vous pouvez filtrer par label en utilisant le paramètre de recherche.
     *
     * @queryParam page integer Page à récupérer (pagination). Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max: 100). Example: 15
     * @queryParam search string Rechercher par label. Example: Premium
     * @queryParam with_clients boolean Inclure les clients associés. Example: false
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "label": "Premium",
     *       "description": "Client premium avec avantages spéciaux",
     *       "created_at": "2024-01-15T10:30:00Z",
     *       "updated_at": "2024-01-15T10:30:00Z"
     *     }
     *   ],
     *   "links": {
     *     "first": "http://localhost/api/client-types?page=1",
     *     "last": "http://localhost/api/client-types?page=1",
     *     "prev": null,
     *     "next": null
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 1,
     *     "per_page": 15,
     *     "to": 1,
     *     "total": 1
     *   }
     * }
     * @response 422 {
     *   "message": "Paramètres de requête invalides",
     *   "errors": {
     *     "per_page": ["Le nombre d'éléments par page ne peut pas dépasser 100"]
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'search' => 'string|max:255',
            'with_clients' => 'boolean'
        ]);

        $query = ClientType::query();

        // Recherche par label
        if (isset($validated['search'])) {
            $query->byLabel($validated['search']);
        }

        // Inclure les clients si demandé
        if (isset($validated['with_clients']) && $validated['with_clients']) {
            $query->with('clients');
        }

        $perPage = $validated['per_page'] ?? 15;
        $clientTypes = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($clientTypes);
    }

    /**
     * Créer un nouveau type de client
     *
     * Crée un nouveau type de client avec les informations fournies.
     * L'UUID est généré automatiquement.
     *
     * @bodyParam label string required Le nom du type de client. Doit être unique. Example: VIP
     * @bodyParam description string optionnel Description du type de client. Example: Client VIP avec services exclusifs
     *
     * @response 201 {
     *   "data": {
     *     "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "label": "VIP",
     *     "description": "Client VIP avec services exclusifs",
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T10:30:00Z"
     *   },
     *   "message": "Type de client créé avec succès"
     * }
     * @response 422 {
     *   "message": "Données de validation échouées",
     *   "errors": {
     *     "label": ["Ce label existe déjà"]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255|unique:client_types,label',
            'description' => 'nullable|string|max:1000'
        ], [
            'label.required' => 'Le label est requis',
            'label.unique' => 'Ce label existe déjà',
            'label.max' => 'Le label ne peut pas dépasser 255 caractères',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères'
        ]);

        $clientType = ClientType::create($validated);

        return response()->json([
            'data' => $clientType,
            'message' => 'Type de client créé avec succès'
        ], 201);
    }

    /**
     * Afficher un type de client spécifique
     *
     * Récupère les détails d'un type de client par son ID.
     *
     * @urlParam client_type_id string required L'UUID du type de client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam with_clients boolean Inclure les clients associés. Example: false
     *
     * @response 200 {
     *   "data": {
     *     "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "label": "Premium",
     *     "description": "Client premium avec avantages spéciaux",
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T10:30:00Z"
     *   }
     * }
     * @response 404 {
     *   "message": "Type de client non trouvé"
     * }
     */
    public function show(Request $request, string $client_type_id): JsonResponse
    {
        $validated = $request->validate([
            'with_clients' => 'boolean'
        ]);

        try {
            $query = ClientType::where('client_type_id', $client_type_id);

            // Inclure les clients si demandé
            if (isset($validated['with_clients']) && $validated['with_clients']) {
                $query->with('clients');
            }

            $clientType = $query->firstOrFail();

            return response()->json([
                'data' => $clientType
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Type de client non trouvé'
            ], 404);
        }
    }

    /**
     * Mettre à jour un type de client
     *
     * Met à jour les informations d'un type de client existant.
     * Seuls les champs fournis seront mis à jour.
     *
     * @urlParam client_type_id string required L'UUID du type de client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam label string Le nom du type de client. Doit être unique. Example: Premium Plus
     * @bodyParam description string Description du type de client. Example: Client premium avec avantages étendus
     *
     * @response 200 {
     *   "data": {
     *     "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "label": "Premium Plus",
     *     "description": "Client premium avec avantages étendus",
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T11:00:00Z"
     *   },
     *   "message": "Type de client mis à jour avec succès"
     * }
     * @response 404 {
     *   "message": "Type de client non trouvé"
     * }
     * @response 422 {
     *   "message": "Données de validation échouées",
     *   "errors": {
     *     "label": ["Ce label existe déjà"]
     *   }
     * }
     */
    public function update(Request $request, string $client_type_id): JsonResponse
    {
        try {
            $clientType = ClientType::where('client_type_id', $client_type_id)->firstOrFail();

            $validated = $request->validate([
                'label' => 'sometimes|required|string|max:255|unique:client_types,label,' . $clientType->client_type_id . ',client_type_id',
                'description' => 'nullable|string|max:1000'
            ], [
                'label.unique' => 'Ce label existe déjà',
                'label.max' => 'Le label ne peut pas dépasser 255 caractères',
                'description.max' => 'La description ne peut pas dépasser 1000 caractères'
            ]);

            $clientType->update($validated);

            return response()->json([
                'data' => $clientType->fresh(),
                'message' => 'Type de client mis à jour avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Type de client non trouvé'
            ], 404);
        }
    }

    /**
     * Supprimer un type de client
     *
     * Supprime définitivement un type de client.
     * Attention : cette action est irréversible.
     *
     * @urlParam client_type_id string required L'UUID du type de client. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "message": "Type de client supprimé avec succès"
     * }
     * @response 404 {
     *   "message": "Type de client non trouvé"
     * }
     * @response 409 {
     *   "message": "Impossible de supprimer ce type de client car il est associé à des clients existants"
     * }
     */
    public function destroy(string $client_type_id): JsonResponse
    {
        try {
            $clientType = ClientType::where('client_type_id', $client_type_id)->firstOrFail();

            // Vérifier s'il y a des clients associés
            if ($clientType->clients()->exists()) {
                return response()->json([
                    'message' => 'Impossible de supprimer ce type de client car il est associé à des clients existants'
                ], 409);
            }

            $clientType->delete();

            return response()->json([
                'message' => 'Type de client supprimé avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Type de client non trouvé'
            ], 404);
        }
    }

    /**
     * Restaurer un type de client supprimé (soft delete)
     *
     * Restaure un type de client qui a été supprimé avec soft delete.
     *
     * @urlParam client_type_id string required L'UUID du type de client. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "data": {
     *     "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "label": "Premium",
     *     "description": "Client premium avec avantages spéciaux",
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T11:00:00Z",
     *     "deleted_at": null
     *   },
     *   "message": "Type de client restauré avec succès"
     * }
     * @response 404 {
     *   "message": "Type de client non trouvé"
     * }
     */
    public function restore(string $client_type_id): JsonResponse
    {
        try {
            $clientType = ClientType::withTrashed()
                ->where('client_type_id', $client_type_id)
                ->firstOrFail();

            if (!$clientType->trashed()) {
                return response()->json([
                    'message' => 'Ce type de client n\'est pas supprimé'
                ], 400);
            }

            $clientType->restore();

            return response()->json([
                'data' => $clientType->fresh(),
                'message' => 'Type de client restauré avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Type de client non trouvé'
            ], 404);
        }
    }

    /**
     * Lister les types de clients supprimés
     *
     * Récupère la liste des types de clients supprimés (soft delete).
     *
     * @queryParam page integer Page à récupérer. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page. Example: 15
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "label": "Ancien Premium",
     *       "description": "Type de client supprimé",
     *       "created_at": "2024-01-15T10:30:00Z",
     *       "updated_at": "2024-01-15T10:30:00Z",
     *       "deleted_at": "2024-01-15T12:00:00Z"
     *     }
     *   ]
     * }
     */
    public function trashed(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100'
        ]);

        $perPage = $validated['per_page'] ?? 15;
        $clientTypes = ClientType::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        return response()->json($clientTypes);
    }
}
