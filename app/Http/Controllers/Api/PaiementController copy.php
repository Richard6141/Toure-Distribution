<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Facture;
use App\Models\Client;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * @group Payments Management
 *
 * APIs pour gérer les paiements des factures
 */
class PaiementController extends Controller
{
    /**
     * Liste tous les paiements
     *
     * Récupère la liste de tous les paiements avec pagination et filtres optionnels.
     *
     * @queryParam page integer Page à récupérer (pagination). Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max: 100). Example: 15
     * @queryParam search string Recherche par référence de paiement. Example: PAY-2025
     * @queryParam facture_id string Filtrer par facture (UUID). Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam client_id string Filtrer par client (UUID). Example: 550e8400-e29b-41d4-a716-446655440001
     * @queryParam payment_method_id string Filtrer par méthode de paiement (UUID). Example: 550e8400-e29b-41d4-a716-446655440002
     * @queryParam statut string Filtrer par statut (pending, completed, failed, refunded). Example: completed
     * @queryParam date_from date Paiements à partir de cette date. Example: 2025-01-01
     * @queryParam date_to date Paiements jusqu'à cette date. Example: 2025-12-31
     * @queryParam with_facture boolean Inclure les informations de la facture. Example: true
     * @queryParam with_client boolean Inclure les informations du client. Example: true
     * @queryParam with_payment_method boolean Inclure les informations de la méthode de paiement. Example: true
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "paiement_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "reference": "PAY-2025-00001",
     *       "facture_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "client_id": "550e8400-e29b-41d4-a716-446655440002",
     *       "payment_method_id": "550e8400-e29b-41d4-a716-446655440003",
     *       "amount": "50000.00",
     *       "payment_date": "2025-01-15T10:30:00Z",
     *       "note": "Paiement partiel",
     *       "statut": "completed",
     *       "user_id": "550e8400-e29b-41d4-a716-446655440004",
     *       "created_at": "2025-01-15T10:30:00Z",
     *       "updated_at": "2025-01-15T10:30:00Z"
     *     }
     *   ],
     *   "meta": {
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 1
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'search' => 'string|max:255',
            'facture_id' => 'uuid|exists:factures,facture_id',
            'client_id' => 'uuid|exists:clients,client_id',
            'payment_method_id' => 'uuid|exists:payment_methods,payment_method_id',
            'statut' => 'in:pending,completed,failed,refunded',
            'date_from' => 'date',
            'date_to' => 'date|after_or_equal:date_from',
            'with_facture' => 'boolean',
            'with_client' => 'boolean',
            'with_payment_method' => 'boolean',
        ]);

        $query = Paiement::query();

        // Recherche par référence
        if (isset($validated['search'])) {
            $query->where('reference', 'like', "%{$validated['search']}%");
        }

        // Filtres
        if (isset($validated['facture_id'])) {
            $query->where('facture_id', $validated['facture_id']);
        }

        if (isset($validated['client_id'])) {
            $query->where('client_id', $validated['client_id']);
        }

        if (isset($validated['payment_method_id'])) {
            $query->where('payment_method_id', $validated['payment_method_id']);
        }

        if (isset($validated['statut'])) {
            $query->where('statut', $validated['statut']);
        }

        // Filtre par date
        if (isset($validated['date_from'])) {
            $query->whereDate('payment_date', '>=', $validated['date_from']);
        }

        if (isset($validated['date_to'])) {
            $query->whereDate('payment_date', '<=', $validated['date_to']);
        }

        // Inclure les relations
        if (isset($validated['with_facture']) && $validated['with_facture']) {
            $query->with('facture');
        }

        if (isset($validated['with_client']) && $validated['with_client']) {
            $query->with('client');
        }

        if (isset($validated['with_payment_method']) && $validated['with_payment_method']) {
            $query->with('paymentMethod');
        }

        $perPage = $validated['per_page'] ?? 15;
        $paiements = $query->orderBy('payment_date', 'desc')->paginate($perPage);

        return response()->json($paiements);
    }

    /**
     * Créer un nouveau paiement
     *
     * Enregistre un nouveau paiement pour une facture.
     * Le montant payé de la facture sera automatiquement mis à jour.
     * La référence du paiement est générée automatiquement.
     *
     * @bodyParam facture_id string required UUID de la facture à payer. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam client_id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam payment_method_id string required UUID de la méthode de paiement. Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam amount number required Montant du paiement. Example: 50000
     * @bodyParam payment_date datetime optionnel Date du paiement (défaut: maintenant). Example: 2025-01-15 10:30:00
     * @bodyParam note string optionnel Note ou commentaire sur le paiement. Example: Paiement en espèces
     * @bodyParam statut string optionnel Statut du paiement (pending, completed, failed, refunded, défaut: completed). Example: completed
     * @bodyParam user_id string required UUID de l'utilisateur enregistrant le paiement. Example: 550e8400-e29b-41d4-a716-446655440003
     *
     * @response 201 {
     *   "data": {
     *     "paiement_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "reference": "PAY-2025-00001",
     *     "facture_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "client_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "payment_method_id": "550e8400-e29b-41d4-a716-446655440003",
     *     "amount": "50000.00",
     *     "payment_date": "2025-01-15T10:30:00Z",
     *     "note": "Paiement en espèces",
     *     "statut": "completed",
     *     "user_id": "550e8400-e29b-41d4-a716-446655440004",
     *     "created_at": "2025-01-15T10:30:00Z",
     *     "updated_at": "2025-01-15T10:30:00Z",
     *     "facture": {
     *       "facture_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "facture_number": "FACT-2025-00001",
     *       "total_amount": "100000.00",
     *       "paid_amount": "50000.00",
     *       "statut": "partially_paid"
     *     }
     *   },
     *   "message": "Paiement enregistré avec succès"
     * }
     * @response 400 {
     *   "message": "Le montant du paiement dépasse le solde restant de la facture",
     *   "data": {
     *     "facture_total": "100000.00",
     *     "already_paid": "80000.00",
     *     "remaining": "20000.00",
     *     "attempted_payment": "30000.00"
     *   }
     * }
     * @response 422 {
     *   "message": "Données de validation échouées",
     *   "errors": {
     *     "facture_id": ["La facture sélectionnée n'existe pas"],
     *     "amount": ["Le montant est requis"]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'facture_id' => 'required|uuid|exists:factures,facture_id',
            'client_id' => 'required|uuid|exists:clients,client_id',
            'payment_method_id' => 'required|uuid|exists:payment_methods,payment_method_id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'nullable|date',
            'note' => 'nullable|string|max:1000',
            'statut' => 'nullable|in:pending,completed,failed,refunded',
            'user_id' => 'required|uuid|exists:users,id',
        ], [
            'facture_id.required' => 'La facture est requise',
            'facture_id.exists' => 'La facture sélectionnée n\'existe pas',
            'client_id.required' => 'Le client est requis',
            'client_id.exists' => 'Le client sélectionné n\'existe pas',
            'payment_method_id.required' => 'La méthode de paiement est requise',
            'payment_method_id.exists' => 'La méthode de paiement sélectionnée n\'existe pas',
            'amount.required' => 'Le montant est requis',
            'amount.min' => 'Le montant doit être supérieur à 0',
            'user_id.required' => 'L\'utilisateur est requis',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas',
        ]);

        DB::beginTransaction();
        try {
            // Récupérer la facture
            $facture = Facture::where('facture_id', $validated['facture_id'])->firstOrFail();

            // Vérifier que le montant ne dépasse pas le solde restant
            $remainingAmount = $facture->total_amount - $facture->paid_amount;
            if ($validated['amount'] > $remainingAmount) {
                return response()->json([
                    'message' => 'Le montant du paiement dépasse le solde restant de la facture',
                    'data' => [
                        'facture_total' => number_format($facture->total_amount, 2, '.', ''),
                        'already_paid' => number_format($facture->paid_amount, 2, '.', ''),
                        'remaining' => number_format($remainingAmount, 2, '.', ''),
                        'attempted_payment' => number_format($validated['amount'], 2, '.', '')
                    ]
                ], 400);
            }

            // Créer le paiement
            $paiement = Paiement::create([
                'facture_id' => $validated['facture_id'],
                'client_id' => $validated['client_id'],
                'payment_method_id' => $validated['payment_method_id'],
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'] ?? now(),
                'note' => $validated['note'] ?? null,
                'statut' => $validated['statut'] ?? 'completed',
                'user_id' => $validated['user_id'],
            ]);

            // Mettre à jour le montant payé de la facture si le paiement est complété
            if ($paiement->statut === 'completed') {
                $newPaidAmount = $facture->paid_amount + $validated['amount'];
                $facture->paid_amount = $newPaidAmount;

                // Mettre à jour le statut de la facture
                if ($newPaidAmount >= $facture->total_amount) {
                    $facture->statut = 'paid';
                } elseif ($newPaidAmount > 0) {
                    $facture->statut = 'partially_paid';
                }

                $facture->save();
            }

            DB::commit();

            $paiement->load(['facture', 'client', 'paymentMethod']);

            return response()->json([
                'data' => $paiement,
                'message' => 'Paiement enregistré avec succès'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de l\'enregistrement du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un paiement spécifique
     *
     * Récupère les détails d'un paiement par son ID.
     *
     * @urlParam id string required L'UUID du paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam with_facture boolean Inclure les informations de la facture. Example: true
     * @queryParam with_client boolean Inclure les informations du client. Example: true
     * @queryParam with_payment_method boolean Inclure les informations de la méthode de paiement. Example: true
     *
     * @response 200 {
     *   "data": {
     *     "paiement_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "reference": "PAY-2025-00001",
     *     "facture": {
     *       "facture_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "facture_number": "FACT-2025-00001"
     *     },
     *     "client": {
     *       "client_id": "550e8400-e29b-41d4-a716-446655440002",
     *       "name_client": "John Doe"
     *     },
     *     "payment_method": {
     *       "payment_method_id": "550e8400-e29b-41d4-a716-446655440003",
     *       "name": "Espèces"
     *     },
     *     "amount": "50000.00",
     *     "payment_date": "2025-01-15T10:30:00Z",
     *     "statut": "completed"
     *   }
     * }
     * @response 404 {
     *   "message": "Paiement non trouvé"
     * }
     */
    public function show(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'with_facture' => 'boolean',
            'with_client' => 'boolean',
            'with_payment_method' => 'boolean',
        ]);

        try {
            $query = Paiement::where('paiement_id', $id);

            if (isset($validated['with_facture']) && $validated['with_facture']) {
                $query->with('facture');
            }

            if (isset($validated['with_client']) && $validated['with_client']) {
                $query->with('client');
            }

            if (isset($validated['with_payment_method']) && $validated['with_payment_method']) {
                $query->with('paymentMethod');
            }

            $paiement = $query->firstOrFail();

            return response()->json([
                'data' => $paiement
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Paiement non trouvé'
            ], 404);
        }
    }

    /**
     * Mettre à jour un paiement
     *
     * Met à jour les informations d'un paiement existant.
     * Note: La modification du montant recalculera le statut de la facture.
     *
     * @urlParam id string required L'UUID du paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam amount number Nouveau montant du paiement. Example: 60000
     * @bodyParam payment_date datetime Date du paiement. Example: 2025-01-16 10:30:00
     * @bodyParam note string Note ou commentaire. Example: Paiement rectifié
     * @bodyParam statut string Statut du paiement (pending, completed, failed, refunded). Example: completed
     *
     * @response 200 {
     *   "data": {
     *     "paiement_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "reference": "PAY-2025-00001",
     *     "amount": "60000.00",
     *     "statut": "completed",
     *     "updated_at": "2025-01-15T11:00:00Z"
     *   },
     *   "message": "Paiement mis à jour avec succès"
     * }
     * @response 404 {
     *   "message": "Paiement non trouvé"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $paiement = Paiement::where('paiement_id', $id)->firstOrFail();

            $validated = $request->validate([
                'amount' => 'nullable|numeric|min:0.01',
                'payment_date' => 'nullable|date',
                'note' => 'nullable|string|max:1000',
                'statut' => 'nullable|in:pending,completed,failed,refunded',
            ]);

            DB::beginTransaction();
            try {
                $oldAmount = $paiement->amount;
                $oldStatut = $paiement->statut;

                $paiement->update($validated);

                // Si le montant ou le statut a changé, recalculer le montant payé de la facture
                if ((isset($validated['amount']) && $validated['amount'] != $oldAmount) ||
                    (isset($validated['statut']) && $validated['statut'] != $oldStatut)) {
                    
                    $facture = $paiement->facture;
                    
                    // Recalculer le montant total payé pour cette facture
                    $totalPaid = $facture->paiements()
                        ->where('statut', 'completed')
                        ->sum('amount');
                    
                    $facture->paid_amount = $totalPaid;
                    
                    // Mettre à jour le statut de la facture
                    if ($totalPaid >= $facture->total_amount) {
                        $facture->statut = 'paid';
                    } elseif ($totalPaid > 0) {
                        $facture->statut = 'partially_paid';
                    } else {
                        $facture->statut = 'pending';
                    }
                    
                    $facture->save();
                }

                DB::commit();

                return response()->json([
                    'data' => $paiement->fresh(),
                    'message' => 'Paiement mis à jour avec succès'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Paiement non trouvé'
            ], 404);
        }
    }

    /**
     * Supprimer un paiement
     *
     * Supprime un paiement et met à jour le montant payé de la facture associée.
     * Cette action est irréversible.
     *
     * @urlParam id string required L'UUID du paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "message": "Paiement supprimé avec succès"
     * }
     * @response 404 {
     *   "message": "Paiement non trouvé"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $paiement = Paiement::where('paiement_id', $id)->firstOrFail();

            DB::beginTransaction();
            try {
                $facture = $paiement->facture;
                $amount = $paiement->amount;
                $statut = $paiement->statut;

                // Supprimer le paiement
                $paiement->delete();

                // Mettre à jour la facture si le paiement était complété
                if ($statut === 'completed') {
                    $facture->paid_amount -= $amount;
                    
                    // Mettre à jour le statut de la facture
                    if ($facture->paid_amount >= $facture->total_amount) {
                        $facture->statut = 'paid';
                    } elseif ($facture->paid_amount > 0) {
                        $facture->statut = 'partially_paid';
                    } else {
                        $facture->statut = 'pending';
                    }
                    
                    $facture->save();
                }

                DB::commit();

                return response()->json([
                    'message' => 'Paiement supprimé avec succès'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Paiement non trouvé'
            ], 404);
        }
    }

    /**
     * Changer le statut d'un paiement
     *
     * Met à jour le statut d'un paiement et recalcule le montant payé de la facture.
     *
     * @urlParam id string required L'UUID du paiement. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam statut string required Nouveau statut (pending, completed, failed, refunded). Example: refunded
     *
     * @response 200 {
     *   "data": {
     *     "paiement_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "statut": "refunded"
     *   },
     *   "message": "Statut du paiement mis à jour avec succès"
     * }
     * @response 404 {
     *   "message": "Paiement non trouvé"
     * }
     */
    public function updateStatus(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'statut' => 'required|in:pending,completed,failed,refunded'
        ]);

        try {
            $paiement = Paiement::where('paiement_id', $id)->firstOrFail();

            DB::beginTransaction();
            try {
                $oldStatut = $paiement->statut;
                $paiement->update(['statut' => $validated['statut']]);

                // Recalculer le montant payé de la facture
                $facture = $paiement->facture;
                $totalPaid = $facture->paiements()
                    ->where('statut', 'completed')
                    ->sum('amount');
                
                $facture->paid_amount = $totalPaid;
                
                // Mettre à jour le statut de la facture
                if ($totalPaid >= $facture->total_amount) {
                    $facture->statut = 'paid';
                } elseif ($totalPaid > 0) {
                    $facture->statut = 'partially_paid';
                } else {
                    $facture->statut = 'pending';
                }
                
                $facture->save();

                DB::commit();

                return response()->json([
                    'data' => [
                        'paiement_id' => $paiement->paiement_id,
                        'statut' => $paiement->statut
                    ],
                    'message' => 'Statut du paiement mis à jour avec succès'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Paiement non trouvé'
            ], 404);
        }
    }

    /**
     * Statistiques des paiements
     *
     * Récupère des statistiques sur les paiements.
     *
     * @queryParam date_from date Statistiques à partir de cette date. Example: 2025-01-01
     * @queryParam date_to date Statistiques jusqu'à cette date. Example: 2025-12-31
     *
     * @response 200 {
     *   "data": {
     *     "total_paiements": 250,
     *     "paiements_completed": 200,
     *     "paiements_pending": 30,
     *     "paiements_failed": 15,
     *     "paiements_refunded": 5,
     *     "total_amount": "12000000.00",
     *     "average_payment_amount": "48000.00",
     *     "payments_by_method": [
     *       {
     *         "payment_method": "Espèces",
     *         "count": 150,
     *         "total_amount": "7000000.00"
     *       },
     *       {
     *         "payment_method": "Mobile Money",
     *         "count": 100,
     *         "total_amount": "5000000.00"
     *       }
     *     ]
     *   }
     * }
     */
    public function statistics(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $query = Paiement::query();

        if (isset($validated['date_from'])) {
            $query->whereDate('payment_date', '>=', $validated['date_from']);
        }

        if (isset($validated['date_to'])) {
            $query->whereDate('payment_date', '<=', $validated['date_to']);
        }

        $stats = [
            'total_paiements' => (clone $query)->count(),
            'paiements_completed' => (clone $query)->where('statut', 'completed')->count(),
            'paiements_pending' => (clone $query)->where('statut', 'pending')->count(),
            'paiements_failed' => (clone $query)->where('statut', 'failed')->count(),
            'paiements_refunded' => (clone $query)->where('statut', 'refunded')->count(),
            'total_amount' => (clone $query)->where('statut', 'completed')->sum('amount'),
            'average_payment_amount' => (clone $query)->where('statut', 'completed')->avg('amount'),
        ];

        // Paiements par méthode de paiement
        $paymentsByMethod = (clone $query)
            ->join('payment_methods', 'paiements.payment_method_id', '=', 'payment_methods.payment_method_id')
            ->where('paiements.statut', 'completed')
            ->groupBy('payment_methods.payment_method_id', 'payment_methods.name')
            ->selectRaw('payment_methods.name as payment_method, COUNT(*) as count, SUM(paiements.amount) as total_amount')
            ->get()
            ->map(function ($item) {
                return [
                    'payment_method' => $item->payment_method,
                    'count' => $item->count,
                    'total_amount' => number_format($item->total_amount, 2, '.', '')
                ];
            });

        $stats['payments_by_method'] = $paymentsByMethod;

        // Formater les nombres
        $stats['total_amount'] = number_format($stats['total_amount'], 2, '.', '');
        $stats['average_payment_amount'] = number_format($stats['average_payment_amount'] ?? 0, 2, '.', '');

        return response()->json([
            'data' => $stats
        ]);
    }
}
