<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entrepot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:entrepots,name',
            'adresse' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'user_id' => 'nullable|uuid|exists:users,user_id'
        ]);

        $entrepot = Entrepot::create($validated);

        // Charger la relation user si elle existe
        //$entrepot->load('user:user_id,username,email');

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
