<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Camion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @group Gestion des Camions
 * 
 * API pour gérer les camions (véhicules de transport) de l'application.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class CamionController extends Controller
{
    /**
     * Liste des camions
     * 
     * Récupère la liste paginée de tous les camions actifs.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * @queryParam search string Rechercher par numéro d'immatriculation ou marque. Example: Toyota
     * @queryParam status string Filtrer par statut (disponible, en_mission, en_maintenance, hors_service). Example: disponible
     * @queryParam capacite_min numeric Filtrer par capacité minimale en tonnes. Example: 5
     * @queryParam capacite_max numeric Filtrer par capacité maximale en tonnes. Example: 20
     * @queryParam marque string Filtrer par marque. Example: Mercedes
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des camions récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "numero_immat": "AB-1234-CD",
     *         "marque": "Mercedes",
     *         "modele": "Actros",
     *         "capacite": "15.50",
     *         "status": "disponible",
     *         "note": "Camion en excellent état",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z"
     *       }
     *     ],
     *     "first_page_url": "http://localhost/api/camions?page=1",
     *     "from": 1,
     *     "last_page": 1,
     *     "last_page_url": "http://localhost/api/camions?page=1",
     *     "next_page_url": null,
     *     "path": "http://localhost/api/camions",
     *     "per_page": 15,
     *     "prev_page_url": null,
     *     "to": 10,
     *     "total": 10
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = Camion::query();

        // Recherche par numéro d'immatriculation ou marque
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('numero_immat', 'like', "%{$search}%")
                    ->orWhere('marque', 'like', "%{$search}%")
                    ->orWhere('modele', 'like', "%{$search}%");
            });
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filtrer par marque
        if ($request->filled('marque')) {
            $query->where('marque', 'like', "%{$request->input('marque')}%");
        }

        // Filtrer par capacité minimale
        if ($request->filled('capacite_min')) {
            $query->capaciteMin($request->input('capacite_min'));
        }

        // Filtrer par capacité maximale
        if ($request->filled('capacite_max')) {
            $query->capaciteMax($request->input('capacite_max'));
        }

        $camions = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des camions récupérée avec succès',
            'data' => $camions
        ]);
    }

    /**
     * Créer un camion
     * 
     * Enregistre un nouveau camion dans le système.
     * 
     * @authenticated
     * 
     * @bodyParam numero_immat string required Le numéro d'immatriculation unique du camion. Example: AB-1234-CD
     * @bodyParam marque string required La marque du camion. Example: Mercedes
     * @bodyParam modele string Le modèle du camion. Example: Actros
     * @bodyParam capacite numeric required La capacité du camion en tonnes. Example: 15.50
     * @bodyParam status string Le statut du camion (disponible, en_mission, en_maintenance, hors_service). Par défaut: disponible. Example: disponible
     * @bodyParam note string Des notes ou observations sur le camion. Example: Camion en excellent état
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "Camion créé avec succès",
     *   "data": {
     *     "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_immat": "AB-1234-CD",
     *     "marque": "Mercedes",
     *     "modele": "Actros",
     *     "capacite": "15.50",
     *     "status": "disponible",
     *     "note": "Camion en excellent état",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z"
     *   }
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "numero_immat": [
     *       "Ce numéro d'immatriculation existe déjà"
     *     ]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'numero_immat' => 'required|string|max:255|unique:camions,numero_immat',
            'marque' => 'required|string|max:255',
            'modele' => 'nullable|string|max:255',
            'capacite' => 'required|numeric|min:0|max:99999.99',
            'status' => ['sometimes', Rule::in(['disponible', 'en_mission', 'en_maintenance', 'hors_service'])],
            'note' => 'nullable|string',
        ], [
            'numero_immat.required' => 'Le numéro d\'immatriculation est requis',
            'numero_immat.unique' => 'Ce numéro d\'immatriculation existe déjà',
            'marque.required' => 'La marque du camion est requise',
            'capacite.required' => 'La capacité du camion est requise',
            'capacite.numeric' => 'La capacité doit être un nombre',
            'capacite.min' => 'La capacité doit être supérieure ou égale à 0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $camion = Camion::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Camion créé avec succès',
            'data' => $camion
        ], 201);
    }

    /**
     * Afficher un camion
     * 
     * Récupère les détails d'un camion spécifique.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du camion. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détails du camion récupérés avec succès",
     *   "data": {
     *     "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_immat": "AB-1234-CD",
     *     "marque": "Mercedes",
     *     "modele": "Actros",
     *     "capacite": "15.50",
     *     "status": "disponible",
     *     "note": "Camion en excellent état",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "is_disponible": true,
     *     "is_en_mission": false,
     *     "is_en_maintenance": false
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Camion non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $camion = Camion::find($id);

        if (!$camion) {
            return response()->json([
                'success' => false,
                'message' => 'Camion non trouvé'
            ], 404);
        }

        $data = $camion->toArray();
        $data['is_disponible'] = $camion->isDisponible();
        $data['is_en_mission'] = $camion->isEnMission();
        $data['is_en_maintenance'] = $camion->isEnMaintenance();

        return response()->json([
            'success' => true,
            'message' => 'Détails du camion récupérés avec succès',
            'data' => $data
        ]);
    }

    /**
     * Mettre à jour un camion
     * 
     * Met à jour les informations d'un camion existant.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du camion. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam numero_immat string Le numéro d'immatriculation unique du camion. Example: AB-1234-CD
     * @bodyParam marque string La marque du camion. Example: Mercedes
     * @bodyParam modele string Le modèle du camion. Example: Actros
     * @bodyParam capacite numeric La capacité du camion en tonnes. Example: 15.50
     * @bodyParam status string Le statut du camion (disponible, en_mission, en_maintenance, hors_service). Example: en_mission
     * @bodyParam note string Des notes ou observations sur le camion. Example: Révision effectuée le 15/01/2025
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Camion mis à jour avec succès",
     *   "data": {
     *     "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_immat": "AB-1234-CD",
     *     "marque": "Mercedes",
     *     "modele": "Actros",
     *     "capacite": "15.50",
     *     "status": "en_mission",
     *     "note": "Révision effectuée le 15/01/2025",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T14:30:00.000000Z"
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Camion non trouvé"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $camion = Camion::find($id);

        if (!$camion) {
            return response()->json([
                'success' => false,
                'message' => 'Camion non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'numero_immat' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('camions', 'numero_immat')->ignore($camion->camion_id, 'camion_id')
            ],
            'marque' => 'sometimes|required|string|max:255',
            'modele' => 'nullable|string|max:255',
            'capacite' => 'sometimes|required|numeric|min:0|max:99999.99',
            'status' => ['sometimes', Rule::in(['disponible', 'en_mission', 'en_maintenance', 'hors_service'])],
            'note' => 'nullable|string',
        ], [
            'numero_immat.required' => 'Le numéro d\'immatriculation est requis',
            'numero_immat.unique' => 'Ce numéro d\'immatriculation existe déjà',
            'marque.required' => 'La marque du camion est requise',
            'capacite.required' => 'La capacité du camion est requise',
            'capacite.numeric' => 'La capacité doit être un nombre',
            'capacite.min' => 'La capacité doit être supérieure ou égale à 0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $camion->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Camion mis à jour avec succès',
            'data' => $camion->fresh()
        ]);
    }

    /**
     * Supprimer un camion
     * 
     * Effectue une suppression logique (soft delete) d'un camion.
     * Le camion reste dans la base mais est marqué comme supprimé.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du camion. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Camion supprimé avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Camion non trouvé"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $camion = Camion::find($id);

        if (!$camion) {
            return response()->json([
                'success' => false,
                'message' => 'Camion non trouvé'
            ], 404);
        }

        $camion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Camion supprimé avec succès'
        ]);
    }

    /**
     * Liste des camions supprimés
     * 
     * Récupère la liste paginée de tous les camions supprimés (soft deleted).
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des camions supprimés récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "numero_immat": "AB-1234-CD",
     *         "marque": "Mercedes",
     *         "modele": "Actros",
     *         "capacite": "15.50",
     *         "status": "hors_service",
     *         "note": "Camion accidenté",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "deleted_at": "2025-01-20T14:30:00.000000Z"
     *       }
     *     ],
     *     "first_page_url": "http://localhost/api/camions/trashed/list?page=1",
     *     "from": 1,
     *     "last_page": 1,
     *     "per_page": 15,
     *     "to": 2,
     *     "total": 2
     *   }
     * }
     */
    public function trashed(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $camions = Camion::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des camions supprimés récupérée avec succès',
            'data' => $camions
        ]);
    }

    /**
     * Restaurer un camion supprimé
     * 
     * Restaure un camion précédemment supprimé (soft deleted).
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du camion supprimé. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Camion restauré avec succès",
     *   "data": {
     *     "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_immat": "AB-1234-CD",
     *     "marque": "Mercedes",
     *     "modele": "Actros",
     *     "capacite": "15.50",
     *     "status": "disponible",
     *     "note": "Réparations effectuées",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Camion supprimé non trouvé"
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $camion = Camion::onlyTrashed()->find($id);

        if (!$camion) {
            return response()->json([
                'success' => false,
                'message' => 'Camion supprimé non trouvé'
            ], 404);
        }

        $camion->restore();

        return response()->json([
            'success' => true,
            'message' => 'Camion restauré avec succès',
            'data' => $camion->fresh()
        ]);
    }
}
