<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

/**
 * @group Fournisseurs
 *
 * APIs pour la gestion des fournisseurs
 */
class FournisseurController extends Controller
{
    /**
     * Liste des fournisseurs
     *
     * Récupère la liste paginée des fournisseurs avec possibilité de filtrage.
     *
     * @queryParam page int Numéro de la page. Example: 1
     * @queryParam per_page int Nombre d'éléments par page (max 100). Example: 15
     * @queryParam search string Recherche par nom, code ou email. Example: ACME
     * @queryParam city string Filtrer par ville. Example: Paris
     * @queryParam is_active boolean Filtrer par statut actif (true/false). Example: true
     * @queryParam sort_by string Champ de tri (name, code, created_at). Example: name
     * @queryParam sort_order string Ordre de tri (asc, desc). Example: asc
     * @queryParam with_trashed boolean Inclure les fournisseurs supprimés. Example: false
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "fournisseur_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "code": "FRN-ABC123",
     *       "name": "ACME Corporation",
     *       "responsable": "John Doe",
     *       "adresse": "123 Main Street",
     *       "city": "Paris",
     *       "phone": "+33123456789",
     *       "email": "contact@acme.com",
     *       "payment_terms": "30 jours",
     *       "is_active": true,
     *       "created_at": "2023-01-01T00:00:00.000000Z",
     *       "updated_at": "2023-01-01T00:00:00.000000Z",
     *       "deleted_at": null
     *     }
     *   ],
     *   "links": {
     *     "first": "http://api.example.com/fournisseurs?page=1",
     *     "last": "http://api.example.com/fournisseurs?page=10",
     *     "prev": null,
     *     "next": "http://api.example.com/fournisseurs?page=2"
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 10,
     *     "per_page": 15,
     *     "to": 15,
     *     "total": 150
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $query = Fournisseur::query();

        // Inclure les supprimés si demandé
        if ($request->boolean('with_trashed')) {
            $query->withTrashed();
        }

        // Filtres de recherche
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', "%{$request->get('city')}%");
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Tri
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        if (in_array($sortBy, ['name', 'code', 'created_at', 'city'])) {
            $query->orderBy($sortBy, $sortOrder === 'desc' ? 'desc' : 'asc');
        }

        $perPage = min($request->get('per_page', 15), 100);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Créer un fournisseur
     *
     * Crée un nouveau fournisseur dans le système.
     *
     * @bodyParam name string required Nom du fournisseur. Example: ACME Corporation
     * @bodyParam responsable string Personne responsable. Example: John Doe
     * @bodyParam adresse string Adresse du fournisseur. Example: 123 Main Street
     * @bodyParam city string Ville. Example: Paris
     * @bodyParam phone string Numéro de téléphone. Example: +33123456789
     * @bodyParam email string Email (doit être unique). Example: contact@acme.com
     * @bodyParam payment_terms string Conditions de paiement. Example: 30 jours
     * @bodyParam is_active boolean Statut actif (par défaut: true). Example: true
     *
     * @response 201 {
     *   "fournisseur_id": "550e8400-e29b-41d4-a716-446655440000",
     *   "code": "FRN-ABC123",
     *   "name": "ACME Corporation",
     *   "responsable": "John Doe",
     *   "adresse": "123 Main Street",
     *   "city": "Paris",
     *   "phone": "+33123456789",
     *   "email": "contact@acme.com",
     *   "payment_terms": "30 jours",
     *   "is_active": true,
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z",
     *   "deleted_at": null
     * }
     *
     * @response 422 {
     *   "message": "Les données fournies ne sont pas valides.",
     *   "errors": {
     *     "name": ["Le nom est obligatoire."],
     *     "email": ["Cette adresse email est déjà utilisée."]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:fournisseurs,email',
            'payment_terms' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $fournisseur = Fournisseur::create($validated);

        return response()->json($fournisseur, 201);
    }

    /**
     * Afficher un fournisseur
     *
     * Récupère les détails d'un fournisseur spécifique.
     *
     * @urlParam id string required L'ID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam with_trashed boolean Inclure même si supprimé. Example: false
     *
     * @response 200 {
     *   "fournisseur_id": "550e8400-e29b-41d4-a716-446655440000",
     *   "code": "FRN-ABC123",
     *   "name": "ACME Corporation",
     *   "responsable": "John Doe",
     *   "adresse": "123 Main Street",
     *   "city": "Paris",
     *   "phone": "+33123456789",
     *   "email": "contact@acme.com",
     *   "payment_terms": "30 jours",
     *   "is_active": true,
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-01T00:00:00.000000Z",
     *   "deleted_at": null
     * }
     *
     * @response 404 {
     *   "message": "Fournisseur non trouvé."
     * }
     */
    public function show(Request $request, string $id): JsonResponse
    {
        $query = Fournisseur::where('fournisseur_id', $id);

        if ($request->boolean('with_trashed')) {
            $query->withTrashed();
        }

        $fournisseur = $query->firstOrFail();

        return response()->json($fournisseur);
    }

    /**
     * Mettre à jour un fournisseur
     *
     * Met à jour les informations d'un fournisseur existant.
     *
     * @urlParam id string required L'ID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam name string Nom du fournisseur. Example: ACME Corporation
     * @bodyParam responsable string Personne responsable. Example: John Doe
     * @bodyParam adresse string Adresse du fournisseur. Example: 123 Main Street
     * @bodyParam city string Ville. Example: Paris
     * @bodyParam phone string Numéro de téléphone. Example: +33123456789
     * @bodyParam email string Email (doit être unique). Example: contact@acme.com
     * @bodyParam payment_terms string Conditions de paiement. Example: 30 jours
     * @bodyParam is_active boolean Statut actif. Example: true
     *
     * @response 200 {
     *   "fournisseur_id": "550e8400-e29b-41d4-a716-446655440000",
     *   "code": "FRN-ABC123",
     *   "name": "ACME Corporation Updated",
     *   "responsable": "Jane Doe",
     *   "adresse": "456 New Street",
     *   "city": "Lyon",
     *   "phone": "+33987654321",
     *   "email": "contact@acme.com",
     *   "payment_terms": "45 jours",
     *   "is_active": true,
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-02T00:00:00.000000Z",
     *   "deleted_at": null
     * }
     *
     * @response 404 {
     *   "message": "Fournisseur non trouvé."
     * }
     *
     * @response 422 {
     *   "message": "Les données fournies ne sont pas valides.",
     *   "errors": {
     *     "email": ["Cette adresse email est déjà utilisée."]
     *   }
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $fournisseur = Fournisseur::where('fournisseur_id', $id)->firstOrFail();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => [
                'nullable',
                'email',
                Rule::unique('fournisseurs', 'email')->ignore($fournisseur->fournisseur_id, 'fournisseur_id')
            ],
            'payment_terms' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $fournisseur->update($validated);

        return response()->json($fournisseur);
    }

    /**
     * Supprimer un fournisseur
     *
     * Supprime définitivement un fournisseur (soft delete).
     *
     * @urlParam id string required L'ID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 204
     *
     * @response 404 {
     *   "message": "Fournisseur non trouvé."
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $fournisseur = Fournisseur::where('fournisseur_id', $id)->firstOrFail();
        $fournisseur->delete();

        return response()->json(null, 204);
    }

    /**
     * Restaurer un fournisseur
     *
     * Restaure un fournisseur précédemment supprimé.
     *
     * @urlParam id string required L'ID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "fournisseur_id": "550e8400-e29b-41d4-a716-446655440000",
     *   "code": "FRN-ABC123",
     *   "name": "ACME Corporation",
     *   "responsable": "John Doe",
     *   "adresse": "123 Main Street",
     *   "city": "Paris",
     *   "phone": "+33123456789",
     *   "email": "contact@acme.com",
     *   "payment_terms": "30 jours",
     *   "is_active": true,
     *   "created_at": "2023-01-01T00:00:00.000000Z",
     *   "updated_at": "2023-01-02T00:00:00.000000Z",
     *   "deleted_at": null
     * }
     *
     * @response 404 {
     *   "message": "Fournisseur non trouvé."
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $fournisseur = Fournisseur::withTrashed()
            ->where('fournisseur_id', $id)
            ->firstOrFail();

        if (!$fournisseur->trashed()) {
            return response()->json(['message' => 'Le fournisseur n\'est pas supprimé.'], 400);
        }

        $fournisseur->restore();

        return response()->json($fournisseur);
    }

    /**
     * Suppression définitive
     *
     * Supprime définitivement un fournisseur de la base de données.
     *
     * @urlParam id string required L'ID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 204
     *
     * @response 404 {
     *   "message": "Fournisseur non trouvé."
     * }
     */
    public function forceDelete(string $id): JsonResponse
    {
        $fournisseur = Fournisseur::withTrashed()
            ->where('fournisseur_id', $id)
            ->firstOrFail();

        $fournisseur->forceDelete();

        return response()->json(null, 204);
    }
}
