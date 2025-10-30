<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaiementVente;
use App\Models\Vente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @group Gestion des Paiements de Ventes
 * 
 * API pour gérer les paiements des ventes.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class PaiementVenteController extends Controller
{
    /**
     * Liste des paiements
     * 
     * Récupère la liste paginée de tous les paiements avec leurs ventes.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * @queryParam search string Rechercher par référence de paiement. Example: PAYV-2025-001
     * @queryParam vente_id string Filtrer par ID de vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @queryParam statut string Filtrer par statut (en_attente, valide, refuse, annule). Example: valide
     * @queryParam mode_paiement string Filtrer par mode (especes, cheque, virement, carte_bancaire, mobile_money, credit). Example: mobile_money
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
     *         "paiement_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "reference_paiement": "PAYV-2025-0001",
     *         "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "montant": "10000.00",
     *         "mode_paiement": "mobile_money",
     *         "statut": "valide",
     *         "date_paiement": "2025-01-15T14:30:00.000000Z",
     *         "numero_transaction": "TRX123456789",
     *         "created_at": "2025-01-15T14:30:00.000000Z",
     *         "vente": {
     *           "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *           "numero_vente": "VTE-2025-0001",
     *           "montant_net": "25000.00"
     *         }
     *       }
     *     ],
     *     "total": 30
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = PaiementVente::with('vente:vente_id,numero_vente,montant_net,statut_paiement');

        // Recherche par référence
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('reference_paiement', 'like', "%{$search}%");
        }

        // Filtres
        if ($request->filled('vente_id')) {
            $query->parVente($request->input('vente_id'));
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        if ($request->filled('mode_paiement')) {
            $query->where('mode_paiement', $request->input('mode_paiement'));
        }

        // Période
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_paiement', [
                $request->input('date_debut') . ' 00:00:00',
                $request->input('date_fin') . ' 23:59:59'
            ]);
        } elseif ($request->filled('date_debut')) {
            $query->where('date_paiement', '>=', $request->input('date_debut') . ' 00:00:00');
        } elseif ($request->filled('date_fin')) {
            $query->where('date_paiement', '<=', $request->input('date_fin') . ' 23:59:59');
        }

        // Montants
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
     * Enregistre un nouveau paiement pour une vente.
     * La référence de paiement est générée automatiquement au format PAYV-YYYY-0001.
     * Le statut de paiement de la vente est mis à jour automatiquement.
     * 
     * @authenticated
     * 
     * @bodyParam vente_id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam montant numeric required Le montant payé. Example: 10000.00
     * @bodyParam mode_paiement string required Le mode de paiement (especes, cheque, virement, carte_bancaire, mobile_money, credit). Example: mobile_money
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
     *     "paiement_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "reference_paiement": "PAYV-2025-0001",
     *     "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "montant": "10000.00",
     *     "mode_paiement": "mobile_money",
     *     "statut": "valide",
     *     "date_paiement": "2025-01-15T14:30:00.000000Z",
     *     "created_at": "2025-01-15T14:30:00.000000Z",
     *     "vente": {
     *       "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_vente": "VTE-2025-0001",
     *       "montant_net": "25000.00",
     *       "montant_paye": "10000.00",
     *       "montant_restant": "15000.00",
     *       "statut_paiement": "paye_partiellement"
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
            'vente_id' => 'required|uuid|exists:ventes,vente_id',
            'montant' => 'required|numeric|min:0.01|max:9999999999999.99',
            'mode_paiement' => ['required', Rule::in([
                'especes',
                'cheque',
                'virement',
                'carte_bancaire',
                'mobile_money',
                'credit'
            ])],
            'statut' => ['sometimes', Rule::in(['en_attente', 'valide', 'refuse', 'annule'])],
            'date_paiement' => 'required|date',
            'numero_transaction' => 'nullable|string|max:255',
            'numero_cheque' => 'nullable|string|max:255',
            'banque' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ], [
            'vente_id.required' => 'La vente est requise',
            'vente_id.exists' => 'La vente sélectionnée n\'existe pas',
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
        $vente = Vente::find($request->vente_id);
        $montantRestant = $vente->montant_restant;

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
            $paiement = PaiementVente::create($validator->validated());
            $paiement->load('vente:vente_id,numero_vente,montant_net,statut_paiement');

            // Ajouter les informations de paiement
            $vente->refresh();
            $data = $paiement->toArray();
            $data['vente']['montant_paye'] = $vente->montant_paye;
            $data['vente']['montant_restant'] = $vente->montant_restant;

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
     * Récupère les détails d'un paiement spécifique avec sa vente.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du paiement. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détails du paiement récupérés avec succès",
     *   "data": {
     *     "paiement_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "reference_paiement": "PAYV-2025-0001",
     *     "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "montant": "10000.00",
     *     "mode_paiement": "mobile_money",
     *     "statut": "valide",
     *     "date_paiement": "2025-01-15T14:30:00.000000Z",
     *     "is_valide": true,
     *     "vente": {
     *       "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_vente": "VTE-2025-0001",
     *       "montant_net": "25000.00",
     *       "montant_paye": "10000.00",
     *       "montant_restant": "15000.00",
     *       "client": {
     *         "client_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "code": "CLI001",
     *         "name_client": "Entreprise ABC"
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
        $paiement = PaiementVente::with('vente.client:client_id,code,name_client')->find($id);

        if (!$paiement) {
            return response()->json([
                'success' => false,
                'message' => 'Paiement non trouvé'
            ], 404);
        }

        $data = $paiement->toArray();
        $data['is_valide'] = $paiement->isValide();

        // Ajouter les informations de paiement de la vente
        $data['vente']['montant_paye'] = $paiement->vente->montant_paye;
        $data['vente']['montant_restant'] = $paiement->vente->montant_restant;

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
     * Note: La référence de paiement et la vente ne peuvent pas être modifiées.
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
     *   "data": {}
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $paiement = PaiementVente::find($id);

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
                'mobile_money',
                'credit'
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
            $vente = $paiement->vente;
            $montantRestant = $vente->montant_net - ($vente->montant_paye - $paiement->montant);

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
        $paiement->load('vente:vente_id,numero_vente,montant_net,statut_paiement');

        return response()->json([
            'success' => true,
            'message' => 'Paiement mis à jour avec succès',
            'data' => $paiement->fresh(['vente'])
        ]);
    }

    /**
     * Supprimer un paiement
     * 
     * Effectue une suppression logique (soft delete) d'un paiement.
     * Le statut de paiement de la vente est mis à jour automatiquement.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du paiement. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Paiement supprimé avec succès"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $paiement = PaiementVente::find($id);

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
     * @authenticated
     */
    public function trashed(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $paiements = PaiementVente::onlyTrashed()
            ->with('vente:vente_id,numero_vente,montant_net')
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
     * @authenticated
     */
    public function restore(string $id): JsonResponse
    {
        $paiement = PaiementVente::onlyTrashed()->find($id);

        if (!$paiement) {
            return response()->json([
                'success' => false,
                'message' => 'Paiement supprimé non trouvé'
            ], 404);
        }

        $paiement->restore();
        $paiement->load('vente:vente_id,numero_vente,montant_net');

        return response()->json([
            'success' => true,
            'message' => 'Paiement restauré avec succès',
            'data' => $paiement->fresh(['vente'])
        ]);
    }

    /**
     * Paiements d'une vente
     * 
     * Récupère tous les paiements associés à une vente spécifique.
     * 
     * @authenticated
     * 
     * @urlParam vente_id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Paiements de la vente récupérés avec succès",
     *   "data": {
     *     "vente": {
     *       "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_vente": "VTE-2025-0001",
     *       "montant_net": "25000.00",
     *       "montant_paye": "15000.00",
     *       "montant_restant": "10000.00",
     *       "statut_paiement": "paye_partiellement",
     *       "is_totalement_payee": false,
     *       "is_partiellement_payee": true
     *     },
     *     "paiements": [
     *       {
     *         "paiement_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "reference_paiement": "PAYV-2025-0001",
     *         "montant": "10000.00",
     *         "mode_paiement": "mobile_money",
     *         "statut": "valide",
     *         "date_paiement": "2025-01-15T14:30:00.000000Z"
     *       }
     *     ]
     *   }
     * }
     */
    public function paiementsParVente(string $venteId): JsonResponse
    {
        $vente = Vente::find($venteId);

        if (!$vente) {
            return response()->json([
                'success' => false,
                'message' => 'Vente non trouvée'
            ], 404);
        }

        $paiements = PaiementVente::parVente($venteId)
            ->orderBy('date_paiement', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Paiements de la vente récupérés avec succès',
            'data' => [
                'vente' => [
                    'vente_id' => $vente->vente_id,
                    'numero_vente' => $vente->numero_vente,
                    'montant_net' => $vente->montant_net,
                    'montant_paye' => $vente->montant_paye,
                    'montant_restant' => $vente->montant_restant,
                    'statut_paiement' => $vente->statut_paiement,
                    'is_totalement_payee' => $vente->isTotalementPayee(),
                    'is_partiellement_payee' => $vente->isPartiellementPayee(),
                ],
                'paiements' => $paiements
            ]
        ]);
    }
}
