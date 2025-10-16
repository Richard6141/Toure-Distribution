<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\PaiementCommande;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @group Gestion des Paiements de Commandes
 * 
 * API pour gérer les paiements des commandes d'achat.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class PaiementCommandeController extends Controller
{
    /**
     * Liste des paiements
     * 
     * Récupère la liste paginée de tous les paiements avec leurs commandes.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * @queryParam search string Rechercher par référence de paiement. Example: PAY-2025-001
     * @queryParam commande_id string Filtrer par ID de commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @queryParam statut string Filtrer par statut (en_attente, valide, refuse, annule). Example: valide
     * @queryParam mode_paiement string Filtrer par mode (especes, cheque, virement, carte_bancaire, mobile_money). Example: mobile_money
     * @queryParam date_debut date Filtrer par date minimum (format: Y-m-d). Example: 2025-01-01
     * @queryParam date_fin date Filtrer par date maximum (format: Y-m-d). Example: 2025-12-31
     * @queryParam montant_min numeric Filtrer par montant minimum. Example: 1000
     * @queryParam montant_max numeric Filtrer par montant maximum. Example: 50000
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des paiements récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "paiement_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "reference_paiement": "PAY-2025-0001",
     *         "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "montant": "10000.00",
     *         "mode_paiement": "mobile_money",
     *         "statut": "valide",
     *         "date_paiement": "2025-01-15T14:30:00.000000Z",
     *         "numero_transaction": "TRX123456789",
     *         "note": "Paiement via MTN Mobile Money",
     *         "created_at": "2025-01-15T14:30:00.000000Z",
     *         "updated_at": "2025-01-15T14:30:00.000000Z",
     *         "commande": {
     *           "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *           "numero_commande": "CMD-2025-0001",
     *           "montant": "25000.00",
     *           "status": "en_cours"
     *         }
     *       }
     *     ],
     *     "first_page_url": "http://localhost/api/paiement-commandes?page=1",
     *     "from": 1,
     *     "last_page": 2,
     *     "per_page": 15,
     *     "to": 15,
     *     "total": 30
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = PaiementCommande::with('commande:commande_id,numero_commande,montant,status');

        // Recherche par référence de paiement
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('reference_paiement', 'like', "%{$search}%");
        }

        // Filtrer par commande
        if ($request->filled('commande_id')) {
            $query->parCommande($request->input('commande_id'));
        }

        // Filtrer par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        // Filtrer par mode de paiement
        if ($request->filled('mode_paiement')) {
            $query->parMode($request->input('mode_paiement'));
        }

        // Filtrer par période
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->parPeriode(
                $request->input('date_debut'),
                $request->input('date_fin') . ' 23:59:59'
            );
        } elseif ($request->filled('date_debut')) {
            $query->where('date_paiement', '>=', $request->input('date_debut'));
        } elseif ($request->filled('date_fin')) {
            $query->where('date_paiement', '<=', $request->input('date_fin') . ' 23:59:59');
        }

        // Filtrer par montant
        if ($request->filled('montant_min')) {
            $query->where('montant', '>=', $request->input('montant_min'));
        }

        if ($request->filled('montant_max')) {
            $query->where('montant', '<=', $request->input('montant_max'));
        }

        $paiements = $query->orderBy('date_paiement', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des paiements récupérée avec succès',
            'data' => $paiements
        ]);
    }

    /**
     * Créer un paiement
     * 
     * Enregistre un nouveau paiement pour une commande.
     * La référence de paiement est générée automatiquement au format PAY-YYYY-0001.
     * 
     * @authenticated
     * 
     * @bodyParam commande_id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam montant numeric required Le montant payé. Example: 10000.00
     * @bodyParam mode_paiement string required Le mode de paiement (especes, cheque, virement, carte_bancaire, mobile_money). Example: mobile_money
     * @bodyParam statut string Le statut du paiement (en_attente, valide, refuse, annule). Par défaut: en_attente. Example: valide
     * @bodyParam date_paiement datetime required La date et heure du paiement (format: Y-m-d H:i:s). Example: 2025-01-15 14:30:00
     * @bodyParam numero_transaction string Le numéro de transaction (pour paiements électroniques). Example: TRX123456789
     * @bodyParam numero_cheque string Le numéro de chèque (pour paiements par chèque). Example: CHQ987654
     * @bodyParam banque string La banque émettrice. Example: Bank of Africa
     * @bodyParam note string Des notes ou observations. Example: Paiement via MTN Mobile Money
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "Paiement enregistré avec succès",
     *   "data": {
     *     "paiement_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "reference_paiement": "PAY-2025-0001",
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "montant": "10000.00",
     *     "mode_paiement": "mobile_money",
     *     "statut": "valide",
     *     "date_paiement": "2025-01-15T14:30:00.000000Z",
     *     "numero_transaction": "TRX123456789",
     *     "note": "Paiement via MTN Mobile Money",
     *     "created_at": "2025-01-15T14:30:00.000000Z",
     *     "updated_at": "2025-01-15T14:30:00.000000Z",
     *     "commande": {
     *       "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_commande": "CMD-2025-0001",
     *       "montant": "25000.00",
     *       "montant_paye": "10000.00",
     *       "montant_restant": "15000.00"
     *     }
     *   }
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "montant": [
     *       "Le montant du paiement dépasse le montant restant à payer"
     *     ]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'commande_id' => 'required|uuid|exists:commandes,commande_id',
            'montant' => 'required|numeric|min:0.01|max:9999999999999.99',
            'mode_paiement' => ['required', Rule::in([
                'especes',
                'cheque',
                'virement',
                'carte_bancaire',
                'mobile_money'
            ])],
            'statut' => ['sometimes', Rule::in(['en_attente', 'valide', 'refuse', 'annule'])],
            'date_paiement' => 'required|date',
            'numero_transaction' => 'nullable|string|max:255',
            'numero_cheque' => 'nullable|string|max:255',
            'banque' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ], [
            'commande_id.required' => 'La commande est requise',
            'commande_id.exists' => 'La commande sélectionnée n\'existe pas',
            'montant.required' => 'Le montant est requis',
            'montant.numeric' => 'Le montant doit être un nombre',
            'montant.min' => 'Le montant doit être supérieur à 0',
            'mode_paiement.required' => 'Le mode de paiement est requis',
            'date_paiement.required' => 'La date de paiement est requise',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Vérifier que le montant ne dépasse pas le montant restant
        $commande = Commande::find($request->commande_id);
        $montantRestant = $commande->montant - $commande->montant_paye;

        if ($request->montant > $montantRestant) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => [
                    'montant' => [
                        "Le montant du paiement ({$request->montant}) dépasse le montant restant à payer ({$montantRestant})"
                    ]
                ]
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Créer le paiement
            $paiement = PaiementCommande::create($validator->validated());
            $paiement->load('commande:commande_id,numero_commande,montant,status');

            // Ajouter les informations de paiement de la commande
            $commande->refresh();
            $data = $paiement->toArray();
            $data['commande']['montant_paye'] = $commande->montant_paye;
            $data['commande']['montant_restant'] = $commande->montant_restant;

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement enregistré avec succès',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un paiement
     * 
     * Récupère les détails d'un paiement spécifique avec sa commande.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du paiement. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détails du paiement récupérés avec succès",
     *   "data": {
     *     "paiement_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "reference_paiement": "PAY-2025-0001",
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "montant": "10000.00",
     *     "mode_paiement": "mobile_money",
     *     "statut": "valide",
     *     "date_paiement": "2025-01-15T14:30:00.000000Z",
     *     "numero_transaction": "TRX123456789",
     *     "banque": null,
     *     "note": "Paiement via MTN Mobile Money",
     *     "created_at": "2025-01-15T14:30:00.000000Z",
     *     "updated_at": "2025-01-15T14:30:00.000000Z",
     *     "is_valide": true,
     *     "is_electronique": true,
     *     "commande": {
     *       "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_commande": "CMD-2025-0001",
     *       "montant": "25000.00",
     *       "montant_paye": "10000.00",
     *       "montant_restant": "15000.00",
     *       "fournisseur": {
     *         "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "code": "FOUR001",
     *         "name": "Fournisseur ABC"
     *       }
     *     }
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Paiement non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $paiement = PaiementCommande::with('commande.fournisseur:fournisseur_id,code,name')->find($id);

        if (!$paiement) {
            return response()->json([
                'success' => false,
                'message' => 'Paiement non trouvé'
            ], 404);
        }

        $data = $paiement->toArray();
        $data['is_valide'] = $paiement->isValide();
        $data['is_electronique'] = $paiement->isElectronique();

        // Ajouter les informations de paiement de la commande
        $data['commande']['montant_paye'] = $paiement->commande->montant_paye;
        $data['commande']['montant_restant'] = $paiement->commande->montant_restant;

        return response()->json([
            'success' => true,
            'message' => 'Détails du paiement récupérés avec succès',
            'data' => $data
        ]);
    }

    /**
     * Mettre à jour un paiement
     * 
     * Met à jour les informations d'un paiement existant.
     * Note: La référence de paiement et la commande ne peuvent pas être modifiées.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du paiement. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam montant numeric Le montant payé. Example: 10000.00
     * @bodyParam mode_paiement string Le mode de paiement. Example: mobile_money
     * @bodyParam statut string Le statut du paiement. Example: valide
     * @bodyParam date_paiement datetime La date et heure du paiement. Example: 2025-01-15 14:30:00
     * @bodyParam numero_transaction string Le numéro de transaction. Example: TRX123456789
     * @bodyParam numero_cheque string Le numéro de chèque. Example: CHQ987654
     * @bodyParam banque string La banque émettrice. Example: Bank of Africa
     * @bodyParam note string Des notes ou observations. Example: Paiement validé
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Paiement mis à jour avec succès",
     *   "data": {
     *     "paiement_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "reference_paiement": "PAY-2025-0001",
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "montant": "10000.00",
     *     "mode_paiement": "mobile_money",
     *     "statut": "valide",
     *     "date_paiement": "2025-01-15T14:30:00.000000Z",
     *     "created_at": "2025-01-15T14:30:00.000000Z",
     *     "updated_at": "2025-01-15T15:00:00.000000Z"
     *   }
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $paiement = PaiementCommande::find($id);

        if (!$paiement) {
            return response()->json([
                'success' => false,
                'message' => 'Paiement non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'montant' => 'sometimes|required|numeric|min:0.01|max:9999999999999.99',
            'mode_paiement' => ['sometimes', 'required', Rule::in([
                'especes',
                'cheque',
                'virement',
                'carte_bancaire',
                'mobile_money'
            ])],
            'statut' => ['sometimes', Rule::in(['en_attente', 'valide', 'refuse', 'annule'])],
            'date_paiement' => 'sometimes|required|date',
            'numero_transaction' => 'nullable|string|max:255',
            'numero_cheque' => 'nullable|string|max:255',
            'banque' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ], [
            'montant.required' => 'Le montant est requis',
            'montant.numeric' => 'Le montant doit être un nombre',
            'montant.min' => 'Le montant doit être supérieur à 0',
            'mode_paiement.required' => 'Le mode de paiement est requis',
            'date_paiement.required' => 'La date de paiement est requise',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Si le montant change, vérifier qu'il ne dépasse pas le montant restant
        if ($request->has('montant') && $request->montant != $paiement->montant) {
            $commande = $paiement->commande;
            $montantRestant = $commande->montant - ($commande->montant_paye - $paiement->montant);

            if ($request->montant > $montantRestant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => [
                        'montant' => [
                            "Le montant du paiement ({$request->montant}) dépasse le montant restant à payer ({$montantRestant})"
                        ]
                    ]
                ], 422);
            }
        }

        $paiement->update($validator->validated());
        $paiement->load('commande:commande_id,numero_commande,montant,status');

        return response()->json([
            'success' => true,
            'message' => 'Paiement mis à jour avec succès',
            'data' => $paiement->fresh(['commande'])
        ]);
    }

    /**
     * Supprimer un paiement
     * 
     * Effectue une suppression logique (soft delete) d'un paiement.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du paiement. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Paiement supprimé avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Paiement non trouvé"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $paiement = PaiementCommande::find($id);

        if (!$paiement) {
            return response()->json([
                'success' => false,
                'message' => 'Paiement non trouvé'
            ], 404);
        }

        $paiement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Paiement supprimé avec succès'
        ]);
    }

    /**
     * Liste des paiements supprimés
     * 
     * Récupère la liste paginée de tous les paiements supprimés.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des paiements supprimés récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [],
     *     "total": 0
     *   }
     * }
     */
    public function trashed(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $paiements = PaiementCommande::onlyTrashed()
            ->with('commande:commande_id,numero_commande,montant')
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des paiements supprimés récupérée avec succès',
            'data' => $paiements
        ]);
    }

    /**
     * Restaurer un paiement supprimé
     * 
     * Restaure un paiement précédemment supprimé.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du paiement supprimé. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Paiement restauré avec succès",
     *   "data": {
     *     "paiement_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "reference_paiement": "PAY-2025-0001",
     *     "deleted_at": null
     *   }
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $paiement = PaiementCommande::onlyTrashed()->find($id);

        if (!$paiement) {
            return response()->json([
                'success' => false,
                'message' => 'Paiement supprimé non trouvé'
            ], 404);
        }

        $paiement->restore();
        $paiement->load('commande:commande_id,numero_commande,montant');

        return response()->json([
            'success' => true,
            'message' => 'Paiement restauré avec succès',
            'data' => $paiement->fresh(['commande'])
        ]);
    }

    /**
     * Paiements d'une commande
     * 
     * Récupère tous les paiements associés à une commande spécifique.
     * 
     * @authenticated
     * 
     * @urlParam commande_id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Paiements de la commande récupérés avec succès",
     *   "data": {
     *     "commande": {
     *       "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_commande": "CMD-2025-0001",
     *       "montant": "25000.00",
     *       "montant_paye": "15000.00",
     *       "montant_restant": "10000.00",
     *       "is_totalement_payee": false,
     *       "is_partiellement_payee": true
     *     },
     *     "paiements": [
     *       {
     *         "paiement_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "reference_paiement": "PAY-2025-0001",
     *         "montant": "10000.00",
     *         "mode_paiement": "mobile_money",
     *         "statut": "valide",
     *         "date_paiement": "2025-01-15T14:30:00.000000Z"
     *       },
     *       {
     *         "paiement_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "reference_paiement": "PAY-2025-0002",
     *         "montant": "5000.00",
     *         "mode_paiement": "especes",
     *         "statut": "valide",
     *         "date_paiement": "2025-01-20T10:00:00.000000Z"
     *       }
     *     ]
     *   }
     * }
     */
    public function paiementsParCommande(string $commandeId): JsonResponse
    {
        $commande = Commande::find($commandeId);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $paiements = PaiementCommande::parCommande($commandeId)
            ->orderBy('date_paiement', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Paiements de la commande récupérés avec succès',
            'data' => [
                'commande' => [
                    'commande_id' => $commande->commande_id,
                    'numero_commande' => $commande->numero_commande,
                    'montant' => $commande->montant,
                    'montant_paye' => $commande->montant_paye,
                    'montant_restant' => $commande->montant_restant,
                    'is_totalement_payee' => $commande->isTotalementPayee(),
                    'is_partiellement_payee' => $commande->isPartiellementPayee(),
                ],
                'paiements' => $paiements
            ]
        ]);
    }
}
