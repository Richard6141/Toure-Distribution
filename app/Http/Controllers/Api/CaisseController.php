<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\ClientPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientPaymentRequest;

/**
 * @group Caisse - Gestion des paiements clients
 *
 * API pour la caisse permettant de gérer les paiements des clients.
 * La caissière peut :
 * - Rechercher un client par nom, code, téléphone
 * - Voir les informations et le solde du client
 * - Enregistrer un paiement qui ajuste automatiquement le solde
 *
 * ## Convention du solde client (current_balance)
 *
 * | Situation | Valeur |
 * |-----------|--------|
 * | Le client **doit** à l'entreprise (dette) | **Négatif** (-) |
 * | L'entreprise **doit** au client (avance/crédit) | **Positif** (+) |
 *
 * ## Effet d'un paiement
 *
 * Quand un client paie à la caisse, son solde augmente (devient moins négatif ou plus positif).
 * Un paiement de 10 000 FCFA sur un solde de -50 000 FCFA donnera un nouveau solde de -40 000 FCFA.
 */
class CaisseController extends Controller
{
    /**
     * Rechercher un client
     *
     * Permet à la caissière de rechercher un client par différents critères.
     * Retourne les informations essentielles du client et son solde actuel.
     *
     * @queryParam search string required Terme de recherche (nom, code, téléphone, email). Example: CLI001
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Résultats de la recherche",
     *   "data": [
     *     {
     *       "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "code": "CLI001",
     *       "name_client": "Client ABC",
     *       "phonenumber": "97000000",
     *       "email": "client@example.com",
     *       "current_balance": -50000,
     *       "formatted_current_balance": "-50 000,00 FCFA",
     *       "has_debt": true,
     *       "dette_actuelle": 50000,
     *       "formatted_dette_actuelle": "50 000,00 FCFA",
     *       "client_type": { "name": "Grossiste" }
     *     }
     *   ]
     * }
     */
    public function searchClient(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'required|string|min:2',
        ], [
            'search.required' => 'Le terme de recherche est requis',
            'search.min' => 'Le terme de recherche doit contenir au moins 2 caractères',
        ]);

        $search = $request->search;

        $clients = Client::with('clientType')
            ->where('is_active', true)
            ->where(function ($query) use ($search) {
                $query->where('name_client', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('phonenumber', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('name_representant', 'like', "%{$search}%");
            })
            ->select([
                'client_id',
                'code',
                'name_client',
                'name_representant',
                'phonenumber',
                'email',
                'adresse',
                'city',
                'current_balance',
                'credit_limit',
                'client_type_id',
            ])
            ->limit(20)
            ->get()
            ->map(function ($client) {
                return [
                    'client_id' => $client->client_id,
                    'code' => $client->code,
                    'name_client' => $client->name_client,
                    'name_representant' => $client->name_representant,
                    'phonenumber' => $client->phonenumber,
                    'email' => $client->email,
                    'adresse' => $client->adresse,
                    'city' => $client->city,
                    'current_balance' => $client->current_balance,
                    'formatted_current_balance' => $client->formatted_current_balance,
                    'credit_limit' => $client->credit_limit,
                    'formatted_credit_limit' => $client->formatted_credit_limit,
                    'has_debt' => $client->hasDebt(),
                    'dette_actuelle' => $client->dette_actuelle,
                    'formatted_dette_actuelle' => $client->formatted_dette_actuelle,
                    'client_type' => $client->clientType ? [
                        'client_type_id' => $client->clientType->client_type_id,
                        'name' => $client->clientType->name,
                    ] : null,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Résultats de la recherche',
            'data' => $clients,
            'count' => $clients->count(),
        ]);
    }

    /**
     * Obtenir les informations d'un client
     *
     * Récupère les informations détaillées d'un client avec son solde,
     * son historique récent de paiements et ses statistiques.
     *
     * @urlParam client_id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "client": {
     *       "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "code": "CLI001",
     *       "name_client": "Client ABC",
     *       "phonenumber": "97000000",
     *       "current_balance": -50000,
     *       "formatted_current_balance": "-50 000,00 FCFA",
     *       "has_debt": true,
     *       "dette_actuelle": 50000,
     *       "formatted_dette_actuelle": "50 000,00 FCFA"
     *     },
     *     "recent_payments": [...],
     *     "statistics": {
     *       "total_payments": 5,
     *       "total_amount_paid": 100000,
     *       "formatted_total_amount_paid": "100 000,00 FCFA"
     *     }
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Client non trouvé"
     * }
     */
    public function getClientInfo(string $clientId): JsonResponse
    {
        $client = Client::with('clientType')->find($clientId);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client non trouvé'
            ], 404);
        }

        // Récupérer les paiements récents
        $recentPayments = ClientPayment::with('caissier:user_id,firstname,lastname')
            ->where('client_id', $clientId)
            ->orderBy('date_paiement', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($payment) {
                return [
                    'payment_id' => $payment->payment_id,
                    'reference' => $payment->reference,
                    'montant' => $payment->montant,
                    'formatted_montant' => $payment->formatted_montant,
                    'mode_paiement' => $payment->mode_paiement,
                    'mode_paiement_label' => $payment->mode_paiement_label,
                    'date_paiement' => $payment->date_paiement,
                    'caissier' => $payment->caissier ? $payment->caissier->firstname . ' ' . $payment->caissier->lastname : null,
                ];
            });

        // Statistiques des paiements
        $totalPayments = ClientPayment::where('client_id', $clientId)->count();
        $totalAmountPaid = ClientPayment::where('client_id', $clientId)->sum('montant');

        return response()->json([
            'success' => true,
            'data' => [
                'client' => [
                    'client_id' => $client->client_id,
                    'code' => $client->code,
                    'name_client' => $client->name_client,
                    'name_representant' => $client->name_representant,
                    'phonenumber' => $client->phonenumber,
                    'email' => $client->email,
                    'adresse' => $client->adresse,
                    'city' => $client->city,
                    'current_balance' => $client->current_balance,
                    'formatted_current_balance' => $client->formatted_current_balance,
                    'credit_limit' => $client->credit_limit,
                    'formatted_credit_limit' => $client->formatted_credit_limit,
                    'has_debt' => $client->hasDebt(),
                    'has_credit' => $client->hasCredit(),
                    'dette_actuelle' => $client->dette_actuelle,
                    'formatted_dette_actuelle' => $client->formatted_dette_actuelle,
                    'is_active' => $client->is_active,
                    'client_type' => $client->clientType ? [
                        'client_type_id' => $client->clientType->client_type_id,
                        'name' => $client->clientType->name,
                    ] : null,
                ],
                'recent_payments' => $recentPayments,
                'statistics' => [
                    'total_payments' => $totalPayments,
                    'total_amount_paid' => $totalAmountPaid,
                    'formatted_total_amount_paid' => number_format($totalAmountPaid, 2, ',', ' ') . ' FCFA',
                ],
            ]
        ]);
    }

    /**
     * Enregistrer un paiement client
     *
     * Enregistre un paiement effectué par un client à la caisse.
     * Le solde du client est automatiquement mis à jour (augmenté du montant payé).
     *
     * @bodyParam client_id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam montant numeric required Montant du paiement (doit être positif). Example: 25000
     * @bodyParam mode_paiement string required Mode de paiement (especes, cheque, virement, mobile_money, carte). Example: especes
     * @bodyParam numero_transaction string Numéro de transaction (pour mobile_money ou virement). Example: TRX123456
     * @bodyParam numero_cheque string Numéro du chèque (pour cheque). Example: CHQ789012
     * @bodyParam banque string Banque émettrice (pour cheque ou virement). Example: BANK OF AFRICA
     * @bodyParam note string Note ou commentaire. Example: Paiement partiel de la dette
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Paiement enregistré avec succès",
     *   "data": {
     *     "payment": {
     *       "payment_id": "...",
     *       "reference": "PAY-CLI-2024-0001",
     *       "montant": 25000,
     *       "formatted_montant": "25 000,00 FCFA",
     *       "mode_paiement": "especes",
     *       "date_paiement": "2024-01-15T14:30:00.000000Z"
     *     },
     *     "client": {
     *       "client_id": "...",
     *       "name_client": "Client ABC",
     *       "ancien_solde": -50000,
     *       "nouveau_solde": -25000,
     *       "formatted_ancien_solde": "-50 000,00 FCFA",
     *       "formatted_nouveau_solde": "-25 000,00 FCFA"
     *     }
     *   }
     * }
     *
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": { ... }
     * }
     */
    public function storePayment(StoreClientPaymentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Récupérer le client
            $client = Client::findOrFail($request->client_id);
            $ancienSolde = $client->current_balance;

            // Le paiement augmente le solde (réduit la dette)
            $montant = abs($request->montant);
            $nouveauSolde = $ancienSolde + $montant;

            // Créer le paiement
            $payment = ClientPayment::create([
                'client_id' => $request->client_id,
                'montant' => $montant,
                'ancien_solde' => $ancienSolde,
                'nouveau_solde' => $nouveauSolde,
                'mode_paiement' => $request->mode_paiement,
                'numero_transaction' => $request->numero_transaction,
                'numero_cheque' => $request->numero_cheque,
                'banque' => $request->banque,
                'note' => $request->note,
                'date_paiement' => $request->date_paiement ?? now(),
                'caissier_id' => auth()->id(),
            ]);

            // Mettre à jour le solde du client
            $client->current_balance = $nouveauSolde;
            $client->save();

            DB::commit();

            // Charger les relations
            $payment->load(['client', 'caissier:user_id,firstname,lastname']);

            return response()->json([
                'success' => true,
                'message' => 'Paiement enregistré avec succès',
                'data' => [
                    'payment' => [
                        'payment_id' => $payment->payment_id,
                        'reference' => $payment->reference,
                        'montant' => $payment->montant,
                        'formatted_montant' => $payment->formatted_montant,
                        'mode_paiement' => $payment->mode_paiement,
                        'mode_paiement_label' => $payment->mode_paiement_label,
                        'numero_transaction' => $payment->numero_transaction,
                        'numero_cheque' => $payment->numero_cheque,
                        'banque' => $payment->banque,
                        'note' => $payment->note,
                        'date_paiement' => $payment->date_paiement,
                        'caissier' => $payment->caissier ? $payment->caissier->firstname . ' ' . $payment->caissier->lastname : null,
                    ],
                    'client' => [
                        'client_id' => $client->client_id,
                        'code' => $client->code,
                        'name_client' => $client->name_client,
                        'ancien_solde' => $ancienSolde,
                        'nouveau_solde' => $nouveauSolde,
                        'formatted_ancien_solde' => number_format($ancienSolde, 2, ',', ' ') . ' FCFA',
                        'formatted_nouveau_solde' => number_format($nouveauSolde, 2, ',', ' ') . ' FCFA',
                        'dette_restante' => $nouveauSolde < 0 ? abs($nouveauSolde) : 0,
                        'formatted_dette_restante' => $nouveauSolde < 0
                            ? number_format(abs($nouveauSolde), 2, ',', ' ') . ' FCFA'
                            : '0,00 FCFA',
                    ]
                ]
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
     * Lister les paiements
     *
     * Liste tous les paiements avec possibilité de filtrage.
     *
     * @queryParam client_id string UUID du client pour filtrer. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam mode_paiement string Mode de paiement (especes, cheque, virement, mobile_money, carte). Example: especes
     * @queryParam date_debut date Date de début (format: Y-m-d). Example: 2024-01-01
     * @queryParam date_fin date Date de fin (format: Y-m-d). Example: 2024-12-31
     * @queryParam caissier_id string UUID du caissier. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam search string Recherche par référence, nom client ou code client. Example: PAY-CLI
     * @queryParam per_page integer Nombre d'éléments par page (défaut: 15). Example: 20
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des paiements",
     *   "data": { ... }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $query = ClientPayment::with(['client:client_id,code,name_client,phonenumber', 'caissier:user_id,firstname,lastname']);

        // Filtre par client
        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filtre par mode de paiement
        if ($request->has('mode_paiement')) {
            $query->where('mode_paiement', $request->mode_paiement);
        }

        // Filtre par période
        if ($request->has('date_debut') && $request->has('date_fin')) {
            $query->whereBetween('date_paiement', [$request->date_debut . ' 00:00:00', $request->date_fin . ' 23:59:59']);
        } elseif ($request->has('date_debut')) {
            $query->where('date_paiement', '>=', $request->date_debut . ' 00:00:00');
        } elseif ($request->has('date_fin')) {
            $query->where('date_paiement', '<=', $request->date_fin . ' 23:59:59');
        }

        // Filtre par caissier
        if ($request->has('caissier_id')) {
            $query->where('caissier_id', $request->caissier_id);
        }

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('name_client', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'date_paiement');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = min($request->get('per_page', 15), 100);
        $payments = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des paiements',
            'data' => $payments
        ]);
    }

    /**
     * Afficher un paiement
     *
     * Récupère les détails d'un paiement spécifique.
     *
     * @urlParam id string required UUID du paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "data": { ... }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Paiement non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $payment = ClientPayment::with(['client', 'caissier:user_id,firstname,lastname'])->find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Paiement non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payment
        ]);
    }

    /**
     * Annuler un paiement
     *
     * Annule un paiement et inverse son effet sur le solde du client.
     *
     * @urlParam id string required UUID du paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Paiement annulé avec succès",
     *   "data": {
     *     "payment_id": "...",
     *     "client_nouveau_solde": -50000
     *   }
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $payment = ClientPayment::find($id);

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paiement non trouvé'
                ], 404);
            }

            // Récupérer le client et annuler l'effet du paiement
            $client = Client::find($payment->client_id);
            if ($client) {
                // Inverser le paiement (soustraire le montant)
                $client->current_balance -= $payment->montant;
                $client->save();
            }

            // Soft delete
            $payment->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement annulé avec succès',
                'data' => [
                    'payment_id' => $id,
                    'client_nouveau_solde' => $client ? $client->current_balance : null,
                    'formatted_client_nouveau_solde' => $client
                        ? number_format($client->current_balance, 2, ',', ' ') . ' FCFA'
                        : null
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'annulation du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Historique des paiements d'un client
     *
     * Récupère l'historique complet des paiements pour un client spécifique.
     *
     * @urlParam client_id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Historique des paiements du client",
     *   "data": { ... }
     * }
     */
    public function clientHistory(string $clientId): JsonResponse
    {
        $client = Client::find($clientId);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client non trouvé'
            ], 404);
        }

        $payments = ClientPayment::with('caissier:user_id,firstname,lastname')
            ->where('client_id', $clientId)
            ->orderBy('date_paiement', 'desc')
            ->get();

        // Statistiques
        $totalPayments = $payments->count();
        $totalAmountPaid = $payments->sum('montant');
        $paymentsByMode = $payments->groupBy('mode_paiement')->map->sum('montant');

        return response()->json([
            'success' => true,
            'message' => 'Historique des paiements du client',
            'data' => [
                'client' => [
                    'client_id' => $client->client_id,
                    'code' => $client->code,
                    'name_client' => $client->name_client,
                    'current_balance' => $client->current_balance,
                    'formatted_current_balance' => $client->formatted_current_balance,
                    'has_debt' => $client->hasDebt(),
                    'dette_actuelle' => $client->dette_actuelle,
                    'formatted_dette_actuelle' => $client->formatted_dette_actuelle,
                ],
                'payments' => $payments,
                'statistics' => [
                    'total_payments' => $totalPayments,
                    'total_amount_paid' => $totalAmountPaid,
                    'formatted_total_amount_paid' => number_format($totalAmountPaid, 2, ',', ' ') . ' FCFA',
                    'by_mode' => $paymentsByMode,
                ],
            ]
        ]);
    }

    /**
     * Statistiques de la caisse
     *
     * Récupère les statistiques de la caisse (paiements du jour, totaux par mode, etc.)
     *
     * @queryParam date_debut date Date de début (format: Y-m-d). Example: 2024-01-01
     * @queryParam date_fin date Date de fin (format: Y-m-d). Example: 2024-12-31
     * @queryParam caissier_id string UUID du caissier pour filtrer. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Statistiques de la caisse",
     *   "data": {
     *     "today": {
     *       "total_payments": 10,
     *       "total_amount": 500000,
     *       "formatted_total_amount": "500 000,00 FCFA"
     *     },
     *     "period": {
     *       "total_payments": 150,
     *       "total_amount": 5000000,
     *       "formatted_total_amount": "5 000 000,00 FCFA"
     *     },
     *     "by_mode": {
     *       "especes": 3000000,
     *       "cheque": 1000000,
     *       "mobile_money": 1000000
     *     }
     *   }
     * }
     */
    public function statistics(Request $request): JsonResponse
    {
        // Statistiques du jour
        $todayQuery = ClientPayment::whereDate('date_paiement', today());

        // Statistiques de la période
        $periodQuery = ClientPayment::query();

        if ($request->has('date_debut') && $request->has('date_fin')) {
            $periodQuery->whereBetween('date_paiement', [$request->date_debut . ' 00:00:00', $request->date_fin . ' 23:59:59']);
        }

        if ($request->has('caissier_id')) {
            $todayQuery->where('caissier_id', $request->caissier_id);
            $periodQuery->where('caissier_id', $request->caissier_id);
        }

        // Statistiques du jour
        $todayTotal = (clone $todayQuery)->sum('montant');
        $todayCount = (clone $todayQuery)->count();

        // Statistiques de la période
        $periodTotal = (clone $periodQuery)->sum('montant');
        $periodCount = (clone $periodQuery)->count();

        // Par mode de paiement (période)
        $byMode = (clone $periodQuery)
            ->select('mode_paiement', DB::raw('SUM(montant) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('mode_paiement')
            ->get()
            ->keyBy('mode_paiement');

        // Clients uniques servis
        $uniqueClientsToday = (clone $todayQuery)->distinct('client_id')->count('client_id');
        $uniqueClientsPeriod = (clone $periodQuery)->distinct('client_id')->count('client_id');

        return response()->json([
            'success' => true,
            'message' => 'Statistiques de la caisse',
            'data' => [
                'today' => [
                    'total_payments' => $todayCount,
                    'total_amount' => $todayTotal,
                    'formatted_total_amount' => number_format($todayTotal, 2, ',', ' ') . ' FCFA',
                    'unique_clients' => $uniqueClientsToday,
                ],
                'period' => [
                    'total_payments' => $periodCount,
                    'total_amount' => $periodTotal,
                    'formatted_total_amount' => number_format($periodTotal, 2, ',', ' ') . ' FCFA',
                    'unique_clients' => $uniqueClientsPeriod,
                ],
                'by_mode' => $byMode,
                'modes_paiement' => ClientPayment::getModesPaiement(),
            ]
        ]);
    }

    /**
     * Paiements supprimés
     *
     * Liste des paiements annulés (soft deleted).
     *
     * @queryParam per_page integer Nombre d'éléments par page. Example: 15
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des paiements annulés",
     *   "data": { ... }
     * }
     */
    public function trashed(Request $request): JsonResponse
    {
        $query = ClientPayment::onlyTrashed()
            ->with(['client:client_id,code,name_client', 'caissier:user_id,firstname,lastname']);

        $perPage = $request->get('per_page', 15);
        $payments = $query->orderBy('deleted_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des paiements annulés',
            'data' => $payments
        ]);
    }

    /**
     * Restaurer un paiement annulé
     *
     * Restaure un paiement précédemment annulé et ré-applique son effet sur le solde.
     *
     * @urlParam id string required UUID du paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Paiement restauré avec succès",
     *   "data": { ... }
     * }
     */
    public function restore(string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $payment = ClientPayment::withTrashed()->find($id);

            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paiement non trouvé'
                ], 404);
            }

            if (!$payment->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce paiement n\'est pas annulé'
                ], 400);
            }

            // Ré-appliquer le paiement au solde du client
            $client = Client::find($payment->client_id);
            if ($client) {
                $client->current_balance += $payment->montant;
                $client->save();
            }

            $payment->restore();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement restauré avec succès',
                'data' => [
                    'payment' => $payment->load(['client', 'caissier:user_id,firstname,lastname']),
                    'client_nouveau_solde' => $client ? $client->current_balance : null,
                    'formatted_client_nouveau_solde' => $client
                        ? number_format($client->current_balance, 2, ',', ' ') . ' FCFA'
                        : null
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Liste des clients débiteurs
     *
     * Récupère la liste des clients ayant une dette (solde négatif),
     * triée par montant de dette décroissant.
     *
     * @queryParam min_debt numeric Montant minimum de dette. Example: 10000
     * @queryParam per_page integer Nombre d'éléments par page. Example: 20
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des clients débiteurs",
     *   "data": {
     *     "clients": [...],
     *     "total_debt": 5000000,
     *     "formatted_total_debt": "5 000 000,00 FCFA",
     *     "count": 50
     *   }
     * }
     */
    public function debtors(Request $request): JsonResponse
    {
        $query = Client::with('clientType')
            ->where('is_active', true)
            ->where('current_balance', '<', 0)
            ->orderBy('current_balance', 'asc'); // Plus grande dette en premier

        // Filtre par dette minimum
        if ($request->has('min_debt')) {
            $minDebt = -abs($request->min_debt);
            $query->where('current_balance', '<=', $minDebt);
        }

        $perPage = $request->get('per_page', 20);
        $clients = $query->paginate($perPage);

        // Total de la dette
        $totalDebt = Client::where('is_active', true)
            ->where('current_balance', '<', 0)
            ->sum('current_balance');

        return response()->json([
            'success' => true,
            'message' => 'Liste des clients débiteurs',
            'data' => [
                'clients' => $clients,
                'total_debt' => abs($totalDebt),
                'formatted_total_debt' => number_format(abs($totalDebt), 2, ',', ' ') . ' FCFA',
                'count' => Client::where('is_active', true)->where('current_balance', '<', 0)->count(),
            ]
        ]);
    }
}
