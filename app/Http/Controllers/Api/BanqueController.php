<?php

namespace App\Http\Controllers\Api;

use App\Models\Banque;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * @group Gestion des Banques
 * 
 * APIs pour gérer les banques du système.
 * 
 * **Authentification requise**: Toutes les routes nécessitent un Bearer Token.
 * 
 * **Header requis pour toutes les requêtes:**
 * ```
 * Authorization: Bearer {votre_token}
 * Content-Type: application/json
 * Accept: application/json
 * ```
 */
class BanqueController extends Controller
{
    /**
     * Lister toutes les banques
     *
     * Récupère la liste complète de toutes les banques avec leurs comptes associés.
     *
     * @group Gestion des Banques
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "banque_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "name": "Ecobank Bénin",
     *       "code": "BNQ-ECO001",
     *       "adresse": "Avenue Clozel, Cotonou",
     *       "contact_info": "+229 21 31 32 33",
     *       "isActive": true,
     *       "created_at": "2025-01-15T10:30:00.000000Z",
     *       "updated_at": "2025-01-15T10:30:00.000000Z",
     *       "deleted_at": null,
     *       "accounts_count": 5
     *     }
     *   ],
     *   "message": "Liste des banques"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function index(): JsonResponse
    {
        $banques = Banque::withCount('accounts')->get();

        return response()->json([
            'data' => $banques,
            'message' => 'Liste des banques'
        ]);
    }

    /**
     * Créer une nouvelle banque
     *
     * Crée une nouvelle banque dans le système. Le code banque est généré automatiquement 
     * si non fourni (format: BNQ-XXXXXX).
     *
     * @group Gestion des Banques
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @bodyParam name string required Nom de la banque (max 255 caractères, unique). Example: "Ecobank Bénin"
     * @bodyParam code string optional Code unique de la banque (auto-généré si non fourni). Example: "BNQ-ECO001"
     * @bodyParam adresse string optional Adresse physique de la banque. Example: "Avenue Clozel, Cotonou"
     * @bodyParam contact_info string optional Informations de contact (téléphone, email). Example: "+229 21 31 32 33"
     * @bodyParam isActive boolean optional Indique si la banque est active (par défaut: true). Example: true
     *
     * @response 201 scenario="Banque créée avec succès" {
     *   "data": {
     *     "banque_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "name": "Ecobank Bénin",
     *     "code": "BNQ-ECO001",
     *     "adresse": "Avenue Clozel, Cotonou",
     *     "contact_info": "+229 21 31 32 33",
     *     "isActive": true,
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null
     *   },
     *   "message": "Banque créée avec succès"
     * }
     *
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "name": ["Le nom de la banque est obligatoire"],
     *     "code": ["Ce code banque existe déjà"]
     *   }
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'name' => 'required|string|max:255|unique:banques,name',
            'code' => 'nullable|string|max:50|unique:banques,code',
            'adresse' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'isActive' => 'boolean',
        ];

        $messages = [
            'name.required' => 'Le nom de la banque est obligatoire',
            'name.unique' => 'Ce nom de banque existe déjà',
            'code.unique' => 'Ce code banque existe déjà',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $banque = Banque::create($validated);

        return response()->json([
            'data' => $banque,
            'message' => 'Banque créée avec succès'
        ], 201);
    }

    /**
     * Afficher une banque spécifique
     *
     * Récupère les détails complets d'une banque avec ses comptes associés.
     *
     * @group Gestion des Banques
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID de la banque. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     *
     * @response 200 scenario="Banque trouvée" {
     *   "data": {
     *     "banque_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "name": "Ecobank Bénin",
     *     "code": "BNQ-ECO001",
     *     "adresse": "Avenue Clozel, Cotonou",
     *     "contact_info": "+229 21 31 32 33",
     *     "isActive": true,
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null,
     *     "accounts": []
     *   },
     *   "message": "Détails de la banque"
     * }
     * 
     * @response 404 scenario="Banque non trouvée" {
     *   "message": "No query results for model [App\\Models\\Banque]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function show(string $id): JsonResponse
    {
        $banque = Banque::with('accounts')->findOrFail($id);

        return response()->json([
            'data' => $banque,
            'message' => 'Détails de la banque'
        ]);
    }

    /**
     * Mettre à jour une banque
     *
     * Met à jour les informations d'une banque existante.
     *
     * @group Gestion des Banques
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID de la banque à mettre à jour. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     *
     * @bodyParam name string required Nom de la banque (unique). Example: "Ecobank Bénin SA"
     * @bodyParam code string optional Code de la banque. Example: "BNQ-ECO001"
     * @bodyParam adresse string optional Adresse de la banque. Example: "Avenue Clozel, Cotonou"
     * @bodyParam contact_info string optional Contact de la banque. Example: "+229 21 31 32 33"
     * @bodyParam isActive boolean optional Statut actif. Example: true
     *
     * @response 200 scenario="Mise à jour réussie" {
     *   "data": {
     *     "banque_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "name": "Ecobank Bénin SA",
     *     "code": "BNQ-ECO001",
     *     "adresse": "Avenue Clozel, Cotonou",
     *     "contact_info": "+229 21 31 32 33",
     *     "isActive": true,
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-16T15:45:00.000000Z",
     *     "deleted_at": null
     *   },
     *   "message": "Banque mise à jour avec succès"
     * }
     * 
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "name": ["Ce nom de banque existe déjà"]
     *   }
     * }
     * 
     * @response 404 scenario="Banque non trouvée" {
     *   "message": "No query results for model [App\\Models\\Banque]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $banque = Banque::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255|unique:banques,name,' . $banque->banque_id . ',banque_id',
            'code' => 'nullable|string|max:50|unique:banques,code,' . $banque->banque_id . ',banque_id',
            'adresse' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'isActive' => 'boolean',
        ];

        $messages = [
            'name.required' => 'Le nom de la banque est obligatoire',
            'name.unique' => 'Ce nom de banque existe déjà',
            'code.unique' => 'Ce code banque existe déjà',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $banque->update($validator->validated());

        return response()->json([
            'data' => $banque,
            'message' => 'Banque mise à jour avec succès'
        ]);
    }

    /**
     * Supprimer une banque (soft delete)
     *
     * Effectue une suppression logique de la banque.
     *
     * @group Gestion des Banques
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID de la banque à supprimer. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Suppression réussie" {
     *   "message": "Banque supprimée avec succès"
     * }
     * 
     * @response 404 scenario="Banque non trouvée" {
     *   "message": "No query results for model [App\\Models\\Banque]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $banque = Banque::findOrFail($id);
        $banque->delete();

        return response()->json([
            'message' => 'Banque supprimée avec succès'
        ]);
    }

    /**
     * Restaurer une banque supprimée
     *
     * Restaure une banque supprimée logiquement.
     *
     * @group Gestion des Banques
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID de la banque à restaurer. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Restauration réussie" {
     *   "data": {
     *     "banque_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "name": "Ecobank Bénin",
     *     "code": "BNQ-ECO001",
     *     "adresse": "Avenue Clozel, Cotonou",
     *     "contact_info": "+229 21 31 32 33",
     *     "isActive": true,
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-16T16:20:00.000000Z",
     *     "deleted_at": null
     *   },
     *   "message": "Banque restaurée avec succès"
     * }
     * 
     * @response 404 scenario="Banque non trouvée" {
     *   "message": "No query results for model [App\\Models\\Banque]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $banque = Banque::withTrashed()->findOrFail($id);
        $banque->restore();

        return response()->json([
            'data' => $banque,
            'message' => 'Banque restaurée avec succès'
        ]);
    }

    /**
     * Lister les banques supprimées
     *
     * Récupère la liste de toutes les banques supprimées logiquement.
     *
     * @group Gestion des Banques
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @response 200 scenario="Succès" {
     *   "data": [],
     *   "message": "Liste des banques supprimées"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function trashed(): JsonResponse
    {
        $banques = Banque::onlyTrashed()->get();

        return response()->json([
            'data' => $banques,
            'message' => 'Liste des banques supprimées'
        ]);
    }

    /**
     * Lister les banques actives
     *
     * Récupère uniquement les banques avec isActive = true.
     *
     * @group Gestion des Banques
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "banque_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "name": "Ecobank Bénin",
     *       "code": "BNQ-ECO001",
     *       "adresse": "Avenue Clozel, Cotonou",
     *       "contact_info": "+229 21 31 32 33",
     *       "isActive": true
     *     }
     *   ],
     *   "message": "Liste des banques actives"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function active(): JsonResponse
    {
        $banques = Banque::active()->get();

        return response()->json([
            'data' => $banques,
            'message' => 'Liste des banques actives'
        ]);
    }
}
