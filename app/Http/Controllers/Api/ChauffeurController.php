<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chauffeur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @group Gestion des Chauffeurs
 * 
 * API pour gérer les chauffeurs (conducteurs) de l'application.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class ChauffeurController extends Controller
{
    /**
     * Liste des chauffeurs
     * 
     * Récupère la liste paginée de tous les chauffeurs actifs.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * @queryParam search string Rechercher par nom ou numéro de téléphone. Example: Jean
     * @queryParam status string Filtrer par statut (actif, inactif, en_conge). Example: actif
     * @queryParam permis_valide boolean Filtrer par permis valide (1 ou 0). Example: 1
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des chauffeurs récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "name": "Jean Dupont",
     *         "phone": "+229 97 00 00 00",
     *         "numero_permis": "PERM123456",
     *         "date_expiration_permis": "2026-12-31",
     *         "status": "actif",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z"
     *       }
     *     ],
     *     "first_page_url": "http://localhost/api/chauffeurs?page=1",
     *     "from": 1,
     *     "last_page": 1,
     *     "last_page_url": "http://localhost/api/chauffeurs?page=1",
     *     "next_page_url": null,
     *     "path": "http://localhost/api/chauffeurs",
     *     "per_page": 15,
     *     "prev_page_url": null,
     *     "to": 5,
     *     "total": 5
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = Chauffeur::query();

        // Recherche par nom ou téléphone
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('numero_permis', 'like', "%{$search}%");
            });
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filtrer par validité du permis
        if ($request->has('permis_valide')) {
            if ($request->boolean('permis_valide')) {
                $query->permisValide();
            } else {
                $query->where('date_expiration_permis', '<', now());
            }
        }

        $chauffeurs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des chauffeurs récupérée avec succès',
            'data' => $chauffeurs
        ]);
    }

    /**
     * Créer un chauffeur
     * 
     * Enregistre un nouveau chauffeur dans le système.
     * 
     * @authenticated
     * 
     * @bodyParam name string required Le nom complet du chauffeur. Example: Jean Dupont
     * @bodyParam phone string required Le numéro de téléphone du chauffeur. Example: +229 97 00 00 00
     * @bodyParam numero_permis string required Le numéro unique du permis de conduire. Example: PERM123456
     * @bodyParam date_expiration_permis date required La date d'expiration du permis (format: Y-m-d). Example: 2026-12-31
     * @bodyParam status string Le statut du chauffeur (actif, inactif, en_conge). Par défaut: actif. Example: actif
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "Chauffeur créé avec succès",
     *   "data": {
     *     "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "name": "Jean Dupont",
     *     "phone": "+229 97 00 00 00",
     *     "numero_permis": "PERM123456",
     *     "date_expiration_permis": "2026-12-31",
     *     "status": "actif",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z"
     *   }
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "numero_permis": [
     *       "Ce numéro de permis existe déjà"
     *     ]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'numero_permis' => 'required|string|max:255|unique:chauffeurs,numero_permis',
            'date_expiration_permis' => 'required|date|after:today',
            'status' => ['sometimes', Rule::in(['actif', 'inactif', 'en_conge'])],
        ], [
            'name.required' => 'Le nom du chauffeur est requis',
            'phone.required' => 'Le numéro de téléphone est requis',
            'numero_permis.required' => 'Le numéro de permis est requis',
            'numero_permis.unique' => 'Ce numéro de permis existe déjà',
            'date_expiration_permis.required' => 'La date d\'expiration du permis est requise',
            'date_expiration_permis.after' => 'La date d\'expiration doit être dans le futur',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $chauffeur = Chauffeur::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Chauffeur créé avec succès',
            'data' => $chauffeur
        ], 201);
    }

    /**
     * Afficher un chauffeur
     * 
     * Récupère les détails d'un chauffeur spécifique.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du chauffeur. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détails du chauffeur récupérés avec succès",
     *   "data": {
     *     "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "name": "Jean Dupont",
     *     "phone": "+229 97 00 00 00",
     *     "numero_permis": "PERM123456",
     *     "date_expiration_permis": "2026-12-31",
     *     "status": "actif",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "is_permis_expire": false,
     *     "is_actif": true
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Chauffeur non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $chauffeur = Chauffeur::find($id);

        if (!$chauffeur) {
            return response()->json([
                'success' => false,
                'message' => 'Chauffeur non trouvé'
            ], 404);
        }

        $data = $chauffeur->toArray();
        $data['is_permis_expire'] = $chauffeur->isPermisExpire();
        $data['is_actif'] = $chauffeur->isActif();

        return response()->json([
            'success' => true,
            'message' => 'Détails du chauffeur récupérés avec succès',
            'data' => $data
        ]);
    }

    /**
     * Mettre à jour un chauffeur
     * 
     * Met à jour les informations d'un chauffeur existant.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du chauffeur. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam name string Le nom complet du chauffeur. Example: Jean Dupont
     * @bodyParam phone string Le numéro de téléphone du chauffeur. Example: +229 97 00 00 00
     * @bodyParam numero_permis string Le numéro unique du permis de conduire. Example: PERM123456
     * @bodyParam date_expiration_permis date La date d'expiration du permis (format: Y-m-d). Example: 2026-12-31
     * @bodyParam status string Le statut du chauffeur (actif, inactif, en_conge). Example: inactif
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Chauffeur mis à jour avec succès",
     *   "data": {
     *     "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "name": "Jean Dupont",
     *     "phone": "+229 97 00 00 00",
     *     "numero_permis": "PERM123456",
     *     "date_expiration_permis": "2026-12-31",
     *     "status": "inactif",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T11:30:00.000000Z"
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Chauffeur non trouvé"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $chauffeur = Chauffeur::find($id);

        if (!$chauffeur) {
            return response()->json([
                'success' => false,
                'message' => 'Chauffeur non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'numero_permis' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('chauffeurs', 'numero_permis')->ignore($chauffeur->chauffeur_id, 'chauffeur_id')
            ],
            'date_expiration_permis' => 'sometimes|required|date|after:today',
            'status' => ['sometimes', Rule::in(['actif', 'inactif', 'en_conge'])],
        ], [
            'name.required' => 'Le nom du chauffeur est requis',
            'phone.required' => 'Le numéro de téléphone est requis',
            'numero_permis.required' => 'Le numéro de permis est requis',
            'numero_permis.unique' => 'Ce numéro de permis existe déjà',
            'date_expiration_permis.required' => 'La date d\'expiration du permis est requise',
            'date_expiration_permis.after' => 'La date d\'expiration doit être dans le futur',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $chauffeur->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Chauffeur mis à jour avec succès',
            'data' => $chauffeur->fresh()
        ]);
    }

    /**
     * Supprimer un chauffeur
     * 
     * Effectue une suppression logique (soft delete) d'un chauffeur.
     * Le chauffeur reste dans la base mais est marqué comme supprimé.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du chauffeur. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Chauffeur supprimé avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Chauffeur non trouvé"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $chauffeur = Chauffeur::find($id);

        if (!$chauffeur) {
            return response()->json([
                'success' => false,
                'message' => 'Chauffeur non trouvé'
            ], 404);
        }

        $chauffeur->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chauffeur supprimé avec succès'
        ]);
    }

    /**
     * Liste des chauffeurs supprimés
     * 
     * Récupère la liste paginée de tous les chauffeurs supprimés (soft deleted).
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des chauffeurs supprimés récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "name": "Jean Dupont",
     *         "phone": "+229 97 00 00 00",
     *         "numero_permis": "PERM123456",
     *         "date_expiration_permis": "2026-12-31",
     *         "status": "actif",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "deleted_at": "2025-01-20T14:30:00.000000Z"
     *       }
     *     ],
     *     "first_page_url": "http://localhost/api/chauffeurs/trashed/list?page=1",
     *     "from": 1,
     *     "last_page": 1,
     *     "per_page": 15,
     *     "to": 3,
     *     "total": 3
     *   }
     * }
     */
    public function trashed(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $chauffeurs = Chauffeur::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des chauffeurs supprimés récupérée avec succès',
            'data' => $chauffeurs
        ]);
    }

    /**
     * Restaurer un chauffeur supprimé
     * 
     * Restaure un chauffeur précédemment supprimé (soft deleted).
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du chauffeur supprimé. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Chauffeur restauré avec succès",
     *   "data": {
     *     "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "name": "Jean Dupont",
     *     "phone": "+229 97 00 00 00",
     *     "numero_permis": "PERM123456",
     *     "date_expiration_permis": "2026-12-31",
     *     "status": "actif",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Chauffeur supprimé non trouvé"
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $chauffeur = Chauffeur::onlyTrashed()->find($id);

        if (!$chauffeur) {
            return response()->json([
                'success' => false,
                'message' => 'Chauffeur supprimé non trouvé'
            ], 404);
        }

        $chauffeur->restore();

        return response()->json([
            'success' => true,
            'message' => 'Chauffeur restauré avec succès',
            'data' => $chauffeur->fresh()
        ]);
    }
}
