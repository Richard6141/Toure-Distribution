<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
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
     *     "data": [],
     *     "total": 30
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = PaiementVente::with('vente:vente_id,numero_vente,montant_net,statut_paiement');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('reference_paiement', 'like', "%{$search}%");
        }

        if ($request->filled('vente_id')) {
            $query->parVente($request->input('vente_id'));
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        if ($request->filled('mode_paiement')) {
            $query->where('mode_paiement', $request->input('mode_paiement'));
        }

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
     * Enregistre un nouveau paiement pour une vente spécifique.
     * La référence de paiement est générée automatiquement.
     * Le current_balance du client est diminué du montant payé.
     * 
     * @authenticated
     * 
     * @bodyParam vente_id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam montant numeric required Le montant payé. Example: 10000.00
     * @bodyParam mode_paiement string required Le mode de paiement. Example: mobile_money
     * @bodyParam statut string Le statut du paiement. Par défaut: en_attente. Example: valide
     * @bodyParam date_paiement datetime required La date et heure du paiement. Example: 2025-01-15 14:30:00
     * @bodyParam numero_transaction string Le numéro de transaction. Example: TRX123456789
     * @bodyParam numero_cheque string Le numéro de chèque. Example: CHQ987654
     * @bodyParam banque string La banque émettrice. Example: Bank of Africa
     * @bodyParam note string Des notes. Example: Paiement via MTN Mobile Money
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "Paiement enregistré avec succès",
     *   "data": {}
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
            $paiement = PaiementVente::create($validator->validated());

            // Diminuer le current_balance du client si le paiement est validé
            if ($paiement->statut === 'valide') {
                $client = Client::find($vente->client_id);
                $client->current_balance -= $paiement->montant;
                $client->save();
            }

            $paiement->load('vente:vente_id,numero_vente,montant_net,statut_paiement');

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
     * Versement client
     * 
     * Enregistre un versement général du client qui sera automatiquement appliqué
     * aux factures impayées. Si le versement dépasse le total des impayés,
     * le solde sera créditeur (current_balance négatif = l'entreprise doit au client).
     * 
     * @authenticated
     * 
     * @bodyParam client_id string required L'UUID du client. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c
     * @bodyParam montant numeric required Le montant du versement. Example: 50000.00
     * @bodyParam mode_paiement string required Le mode de paiement. Example: virement
     * @bodyParam date_paiement datetime required La date et heure du paiement. Example: 2025-01-15 14:30:00
     * @bodyParam numero_transaction string Le numéro de transaction. Example: TRX123456789
     * @bodyParam numero_cheque string Le numéro de chèque. Example: CHQ987654
     * @bodyParam banque string La banque émettrice. Example: Bank of Africa
     * @bodyParam note string Des notes. Example: Versement pour régularisation des factures
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "Versement traité avec succès. 2 facture(s) payée(s).",
     *   "data": {
     *     "montant_verse": "50000.00",
     *     "montant_applique": "45000.00",
     *     "solde_restant": "-5000.00",
     *     "client_current_balance": "-5000.00",
     *     "paiements_crees": [
     *       {
     *         "paiement_vente_id": "uuid",
     *         "reference_paiement": "PAYV-2025-0001",
     *         "vente_id": "uuid",
     *         "numero_vente": "VTE-2025-0001",
     *         "montant": "25000.00"
     *       }
     *     ]
     *   }
     * }
     */
    public function versement(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|uuid|exists:clients,client_id',
            'montant' => 'required|numeric|min:0.01|max:9999999999999.99',
            'mode_paiement' => ['required', Rule::in([
                'especes',
                'cheque',
                'virement',
                'carte_bancaire',
                'mobile_money',
                'credit'
            ])],
            'date_paiement' => 'required|date',
            'numero_transaction' => 'nullable|string|max:255',
            'numero_cheque' => 'nullable|string|max:255',
            'banque' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ], [
            'client_id.required' => 'Le client est requis',
            'client_id.exists' => 'Le client sélectionné n\'existe pas',
            'montant.required' => 'Le montant est requis',
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

        DB::beginTransaction();
        try {
            $client = Client::find($request->client_id);
            $montantDisponible = $request->montant;
            $paiementsCrees = [];

            // Récupérer les ventes impayées ou partiellement payées, triées par date
            $ventesImpayes = Vente::where('client_id', $client->client_id)
                ->where('status', 'validee')
                ->whereIn('statut_paiement', ['non_paye', 'paye_partiellement'])
                ->orderBy('date_vente', 'asc')
                ->get();

            // Appliquer le versement aux factures impayées
            foreach ($ventesImpayes as $vente) {
                if ($montantDisponible <= 0) {
                    break;
                }

                $montantRestant = $vente->montant_restant;
                $montantAPayer = min($montantDisponible, $montantRestant);

                // Créer le paiement
                $paiement = PaiementVente::create([
                    'vente_id' => $vente->vente_id,
                    'montant' => $montantAPayer,
                    'mode_paiement' => $request->mode_paiement,
                    'statut' => 'valide',
                    'date_paiement' => $request->date_paiement,
                    'numero_transaction' => $request->numero_transaction,
                    'numero_cheque' => $request->numero_cheque,
                    'banque' => $request->banque,
                    'note' => $request->note ?? "Paiement automatique suite au versement",
                ]);

                $paiementsCrees[] = [
                    'paiement_vente_id' => $paiement->paiement_vente_id,
                    'reference_paiement' => $paiement->reference_paiement,
                    'vente_id' => $vente->vente_id,
                    'numero_vente' => $vente->numero_vente,
                    'montant' => $montantAPayer,
                    'montant_restant_facture' => $montantRestant - $montantAPayer
                ];

                $montantDisponible -= $montantAPayer;
            }

            // Mettre à jour le current_balance du client
            // Si montantDisponible > 0, le client a un crédit (current_balance négatif)
            $montantApplique = $request->montant - $montantDisponible;
            $client->current_balance -= $request->montant;
            $client->save();

            DB::commit();

            $nombreFactures = count($paiementsCrees);
            $message = $nombreFactures > 0
                ? "Versement traité avec succès. {$nombreFactures} facture(s) payée(s)."
                : "Versement enregistré. Aucune facture impayée. Le client a maintenant un crédit.";

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'montant_verse' => $request->montant,
                    'montant_applique' => $montantApplique,
                    'solde_restant' => $montantDisponible,
                    'client_current_balance' => $client->current_balance,
                    'paiements_crees' => $paiementsCrees
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement du versement',
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
     *   "data": {}
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
     * Si le statut ou le montant change, le current_balance du client est ajusté.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du paiement. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

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

        DB::beginTransaction();
        try {
            $client = Client::find($paiement->vente->client_id);
            $oldMontant = $paiement->montant;
            $oldStatut = $paiement->statut;

            $paiement->update($validator->validated());

            // Ajuster le current_balance selon les changements
            $newStatut = $paiement->statut;
            $newMontant = $paiement->montant;

            // Cas 1: Changement de statut
            if ($oldStatut !== $newStatut) {
                if ($oldStatut === 'valide' && $newStatut !== 'valide') {
                    // Annulation d'un paiement validé : augmenter la dette
                    $client->current_balance += $oldMontant;
                } elseif ($oldStatut !== 'valide' && $newStatut === 'valide') {
                    // Validation d'un paiement : diminuer la dette
                    $client->current_balance -= $newMontant;
                }
            }

            // Cas 2: Changement de montant sur paiement validé
            if ($newStatut === 'valide' && $oldStatut === 'valide' && $oldMontant != $newMontant) {
                $difference = $newMontant - $oldMontant;
                $client->current_balance -= $difference;
            }

            $client->save();

            $paiement->load('vente:vente_id,numero_vente,montant_net,statut_paiement');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement mis à jour avec succès',
                'data' => $paiement->fresh(['vente'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Paiements d'un client
     * 
     * Récupère tous les paiements associés à un client spécifique avec statistiques.
     * 
     * @authenticated
     * 
     * @urlParam client_id string required L'UUID du client. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c
     * @queryParam statut string Filtrer par statut (en_attente, valide, refuse, annule). Example: valide
     * @queryParam mode_paiement string Filtrer par mode de paiement. Example: mobile_money
     * @queryParam date_debut date Filtrer par date minimum. Example: 2025-01-01
     * @queryParam date_fin date Filtrer par date maximum. Example: 2025-12-31
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Paiements du client récupérés avec succès",
     *   "data": {
     *     "client": {
     *       "client_id": "uuid",
     *       "code": "CLI-001",
     *       "name_client": "Nom du client",
     *       "current_balance": 50000.00
     *     },
     *     "statistiques": {
     *       "nombre_paiements": 15,
     *       "total_paye": 150000.00,
     *       "total_valide": 140000.00,
     *       "total_en_attente": 10000.00
     *     },
     *     "paiements": []
     *   }
     * }
     */
    public function paiementsParClient(Request $request, string $clientId): JsonResponse
    {
        $client = Client::find($clientId);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client non trouvé'
            ], 404);
        }

        // Construire la requête de base
        $query = PaiementVente::whereHas('vente', function ($q) use ($clientId) {
            $q->where('client_id', $clientId);
        })->with(['vente:vente_id,numero_vente,montant_net,statut_paiement,client_id']);

        // Appliquer les filtres optionnels
        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        if ($request->filled('mode_paiement')) {
            $query->where('mode_paiement', $request->input('mode_paiement'));
        }

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

        $paiements = $query->orderBy('date_paiement', 'desc')->get();

        // Calculer les statistiques
        $statistiques = [
            'nombre_paiements' => $paiements->count(),
            'total_paye' => $paiements->sum('montant'),
            'total_valide' => $paiements->where('statut', 'valide')->sum('montant'),
            'total_en_attente' => $paiements->where('statut', 'en_attente')->sum('montant'),
            'total_refuse' => $paiements->where('statut', 'refuse')->sum('montant'),
            'total_annule' => $paiements->where('statut', 'annule')->sum('montant'),
            'par_mode_paiement' => $paiements->groupBy('mode_paiement')->map(function ($group) {
                return [
                    'nombre' => $group->count(),
                    'montant' => $group->sum('montant')
                ];
            })
        ];

        return response()->json([
            'success' => true,
            'message' => 'Paiements du client récupérés avec succès',
            'data' => [
                'client' => [
                    'client_id' => $client->client_id,
                    'code' => $client->code,
                    'name_client' => $client->name_client,
                    'current_balance' => $client->current_balance,
                    'email' => $client->email,
                    'telephone' => $client->telephone
                ],
                'statistiques' => $statistiques,
                'paiements' => $paiements
            ]
        ]);
    }

    /**
     * Supprimer un paiement
     * 
     * Effectue une suppression logique d'un paiement.
     * Si le paiement était validé, le current_balance du client est augmenté.
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

        DB::beginTransaction();
        try {
            // Augmenter le current_balance si le paiement était validé
            if ($paiement->statut === 'valide') {
                $client = Client::find($paiement->vente->client_id);
                $client->current_balance += $paiement->montant;
                $client->save();
            }

            $paiement->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
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

        DB::beginTransaction();
        try {
            $paiement->restore();

            // Diminuer le current_balance si le paiement était validé
            if ($paiement->statut === 'valide') {
                $client = Client::find($paiement->vente->client_id);
                $client->current_balance -= $paiement->montant;
                $client->save();
            }

            $paiement->load('vente:vente_id,numero_vente,montant_net');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement restauré avec succès',
                'data' => $paiement->fresh(['vente'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration',
                'error' => $e->getMessage()
            ], 500);
        }
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
     *   "data": {}
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
