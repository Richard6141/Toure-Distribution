<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Fournisseur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @group Gestion des Commandes
 * 
 * API pour gérer les commandes d'achat auprès des fournisseurs.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class CommandeController extends Controller
{
    /**
     * Liste des commandes
     * 
     * Récupère la liste paginée de toutes les commandes avec leurs fournisseurs.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * @queryParam search string Rechercher par numéro de commande. Example: CMD-2025-001
     * @queryParam status string Filtrer par statut (en_attente, validee, en_cours, livree, partiellement_livree, annulee). Example: en_attente
     * @queryParam fournisseur_id string Filtrer par ID du fournisseur. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @queryParam date_achat_debut date Filtrer par date d'achat minimum (format: Y-m-d). Example: 2025-01-01
     * @queryParam date_achat_fin date Filtrer par date d'achat maximum (format: Y-m-d). Example: 2025-12-31
     * @queryParam montant_min numeric Filtrer par montant minimum. Example: 1000
     * @queryParam montant_max numeric Filtrer par montant maximum. Example: 50000
     * @queryParam en_retard boolean Afficher uniquement les commandes en retard (1 ou 0). Example: 1
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des commandes récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "numero_commande": "CMD-2025-0001",
     *         "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "date_achat": "2025-01-15",
     *         "date_livraison_prevue": "2025-02-15",
     *         "date_livraison_effective": null,
     *         "montant": "25000.00",
     *         "status": "en_attente",
     *         "note": "Commande urgente",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "fournisseur": {
     *           "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *           "code": "FOUR001",
     *           "name": "Fournisseur ABC",
     *           "email": "contact@fournisseur-abc.com",
     *           "phone": "+229 97 00 00 00"
     *         }
     *       }
     *     ],
     *     "first_page_url": "http://localhost/api/commandes?page=1",
     *     "from": 1,
     *     "last_page": 3,
     *     "per_page": 15,
     *     "to": 15,
     *     "total": 45
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = Commande::with('fournisseur:fournisseur_id,code,name,email,phone');

        // Recherche par numéro de commande
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('numero_commande', 'like', "%{$search}%");
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filtrer par fournisseur
        if ($request->filled('fournisseur_id')) {
            $query->parFournisseur($request->input('fournisseur_id'));
        }

        // Filtrer par période de dates d'achat
        if ($request->filled('date_achat_debut') && $request->filled('date_achat_fin')) {
            $query->parPeriodeAchat(
                $request->input('date_achat_debut'),
                $request->input('date_achat_fin')
            );
        } elseif ($request->filled('date_achat_debut')) {
            $query->where('date_achat', '>=', $request->input('date_achat_debut'));
        } elseif ($request->filled('date_achat_fin')) {
            $query->where('date_achat', '<=', $request->input('date_achat_fin'));
        }

        // Filtrer par montant minimum
        if ($request->filled('montant_min')) {
            $query->montantMin($request->input('montant_min'));
        }

        // Filtrer par montant maximum
        if ($request->filled('montant_max')) {
            $query->montantMax($request->input('montant_max'));
        }

        // Filtrer les commandes en retard
        if ($request->boolean('en_retard')) {
            $query->enRetard();
        }

        $commandes = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des commandes récupérée avec succès',
            'data' => $commandes
        ]);
    }

    /**
     * Créer une commande
     * 
     * Enregistre une nouvelle commande d'achat dans le système.
     * Le numéro de commande est généré automatiquement au format CMD-YYYY-0001.
     * 
     * @authenticated
     * 
     * @bodyParam fournisseur_id string required L'UUID du fournisseur. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam date_achat date required La date d'achat (format: Y-m-d). Example: 2025-01-15
     * @bodyParam date_livraison_prevue date required La date de livraison prévue (format: Y-m-d). Example: 2025-02-15
     * @bodyParam date_livraison_effective date La date de livraison effective (format: Y-m-d). Example: 2025-02-10
     * @bodyParam montant numeric required Le montant total de la commande. Example: 25000.00
     * @bodyParam status string Le statut de la commande (en_attente, validee, en_cours, livree, partiellement_livree, annulee). Par défaut: en_attente. Example: en_attente
     * @bodyParam note string Des notes ou observations sur la commande. Example: Commande urgente
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "Commande créée avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0001",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "date_livraison_effective": null,
     *     "montant": "25000.00",
     *     "status": "en_attente",
     *     "note": "Commande urgente",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "fournisseur": {
     *       "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "code": "FOUR001",
     *       "name": "Fournisseur ABC",
     *       "email": "contact@fournisseur-abc.com"
     *     }
     *   }
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "fournisseur_id": [
     *       "Le fournisseur sélectionné n'existe pas"
     *     ]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'fournisseur_id' => 'required|uuid|exists:fournisseurs,fournisseur_id',
            'date_achat' => 'required|date',
            'date_livraison_prevue' => 'required|date|after_or_equal:date_achat',
            'date_livraison_effective' => 'nullable|date',
            'montant' => 'required|numeric|min:0|max:9999999999999.99',
            'status' => ['sometimes', Rule::in([
                'en_attente',
                'validee',
                'en_cours',
                'livree',
                'partiellement_livree',
                'annulee'
            ])],
            'note' => 'nullable|string',
        ], [
            'fournisseur_id.required' => 'Le fournisseur est requis',
            'fournisseur_id.exists' => 'Le fournisseur sélectionné n\'existe pas',
            'date_achat.required' => 'La date d\'achat est requise',
            'date_livraison_prevue.required' => 'La date de livraison prévue est requise',
            'date_livraison_prevue.after_or_equal' => 'La date de livraison doit être postérieure ou égale à la date d\'achat',
            'montant.required' => 'Le montant est requis',
            'montant.numeric' => 'Le montant doit être un nombre',
            'montant.min' => 'Le montant doit être supérieur ou égal à 0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Le numero_commande sera généré automatiquement par le modèle
        $commande = Commande::create($validator->validated());
        $commande->load('fournisseur:fournisseur_id,code,name,email,phone');

        return response()->json([
            'success' => true,
            'message' => 'Commande créée avec succès',
            'data' => $commande
        ], 201);
    }

    /**
     * Afficher une commande
     * 
     * Récupère les détails d'une commande spécifique avec son fournisseur.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détails de la commande récupérés avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0001",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "date_livraison_effective": null,
     *     "montant": "25000.00",
     *     "status": "en_attente",
     *     "note": "Commande urgente",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "is_en_attente": true,
     *     "is_livree": false,
     *     "is_en_retard": false,
     *     "fournisseur": {
     *       "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "code": "FOUR001",
     *       "name": "Fournisseur ABC",
     *       "responsable": "Jean Dupont",
     *       "email": "contact@fournisseur-abc.com",
     *       "phone": "+229 97 00 00 00",
     *       "adresse": "123 Rue Principale",
     *       "city": "Cotonou"
     *     }
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $commande = Commande::with('fournisseur')->find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $data = $commande->toArray();
        $data['is_en_attente'] = $commande->isEnAttente();
        $data['is_livree'] = $commande->isLivree();
        $data['is_en_retard'] = $commande->isEnRetard();

        return response()->json([
            'success' => true,
            'message' => 'Détails de la commande récupérés avec succès',
            'data' => $data
        ]);
    }

    /**
     * Mettre à jour une commande
     * 
     * Met à jour les informations d'une commande existante.
     * Note: Le numéro de commande ne peut pas être modifié.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam fournisseur_id string L'UUID du fournisseur. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam date_achat date La date d'achat (format: Y-m-d). Example: 2025-01-15
     * @bodyParam date_livraison_prevue date La date de livraison prévue (format: Y-m-d). Example: 2025-02-15
     * @bodyParam date_livraison_effective date La date de livraison effective (format: Y-m-d). Example: 2025-02-10
     * @bodyParam montant numeric Le montant total de la commande. Example: 25000.00
     * @bodyParam status string Le statut de la commande. Example: livree
     * @bodyParam note string Des notes ou observations sur la commande. Example: Livraison effectuée avec succès
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Commande mise à jour avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0001",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "date_livraison_effective": "2025-02-10",
     *     "montant": "25000.00",
     *     "status": "livree",
     *     "note": "Livraison effectuée avec succès",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-02-10T14:30:00.000000Z",
     *     "fournisseur": {
     *       "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "code": "FOUR001",
     *       "name": "Fournisseur ABC"
     *     }
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'fournisseur_id' => 'sometimes|required|uuid|exists:fournisseurs,fournisseur_id',
            'date_achat' => 'sometimes|required|date',
            'date_livraison_prevue' => 'sometimes|required|date|after_or_equal:date_achat',
            'date_livraison_effective' => 'nullable|date',
            'montant' => 'sometimes|required|numeric|min:0|max:9999999999999.99',
            'status' => ['sometimes', Rule::in([
                'en_attente',
                'validee',
                'en_cours',
                'livree',
                'partiellement_livree',
                'annulee'
            ])],
            'note' => 'nullable|string',
        ], [
            'fournisseur_id.required' => 'Le fournisseur est requis',
            'fournisseur_id.exists' => 'Le fournisseur sélectionné n\'existe pas',
            'date_achat.required' => 'La date d\'achat est requise',
            'date_livraison_prevue.required' => 'La date de livraison prévue est requise',
            'date_livraison_prevue.after_or_equal' => 'La date de livraison doit être postérieure ou égale à la date d\'achat',
            'montant.required' => 'Le montant est requis',
            'montant.numeric' => 'Le montant doit être un nombre',
            'montant.min' => 'Le montant doit être supérieur ou égal à 0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Le numero_commande ne peut pas être modifié
        $commande->update($validator->validated());
        $commande->load('fournisseur:fournisseur_id,code,name,email,phone');

        return response()->json([
            'success' => true,
            'message' => 'Commande mise à jour avec succès',
            'data' => $commande->fresh(['fournisseur'])
        ]);
    }

    /**
     * Supprimer une commande
     * 
     * Effectue une suppression logique (soft delete) d'une commande.
     * La commande reste dans la base mais est marquée comme supprimée.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Commande supprimée avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $commande->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commande supprimée avec succès'
        ]);
    }

    /**
     * Liste des commandes supprimées
     * 
     * Récupère la liste paginée de toutes les commandes supprimées (soft deleted).
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des commandes supprimées récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "numero_commande": "CMD-2025-0001",
     *         "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "date_achat": "2025-01-15",
     *         "montant": "25000.00",
     *         "status": "annulee",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "deleted_at": "2025-01-20T14:30:00.000000Z",
     *         "fournisseur": {
     *           "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *           "code": "FOUR001",
     *           "name": "Fournisseur ABC"
     *         }
     *       }
     *     ],
     *     "first_page_url": "http://localhost/api/commandes/trashed/list?page=1",
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

        $commandes = Commande::onlyTrashed()
            ->with('fournisseur:fournisseur_id,code,name,email,phone')
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des commandes supprimées récupérée avec succès',
            'data' => $commandes
        ]);
    }

    /**
     * Restaurer une commande supprimée
     * 
     * Restaure une commande précédemment supprimée (soft deleted).
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande supprimée. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Commande restaurée avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0001",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "montant": "25000.00",
     *     "status": "en_attente",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null,
     *     "fournisseur": {
     *       "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "code": "FOUR001",
     *       "name": "Fournisseur ABC"
     *     }
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Commande supprimée non trouvée"
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $commande = Commande::onlyTrashed()->find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande supprimée non trouvée'
            ], 404);
        }

        $commande->restore();
        $commande->load('fournisseur:fournisseur_id,code,name,email,phone');

        return response()->json([
            'success' => true,
            'message' => 'Commande restaurée avec succès',
            'data' => $commande->fresh(['fournisseur'])
        ]);
    }
}
