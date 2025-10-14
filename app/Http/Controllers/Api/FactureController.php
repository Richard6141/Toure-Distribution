<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Models\FactureDetail;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

/**
 * @group Invoices Management
 *
 * APIs pour gérer les factures et leurs détails
 */
class FactureController extends Controller
{
    /**
     * Liste toutes les factures
     *
     * Récupère la liste de toutes les factures avec pagination et filtres optionnels.
     *
     * @queryParam page integer Page à récupérer (pagination). Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max: 100). Example: 15
     * @queryParam search string Recherche par numéro de facture ou référence. Example: FACT-2025
     * @queryParam client_id string Filtrer par client (UUID). Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam statut string Filtrer par statut (pending, paid, partially_paid, cancelled, overdue). Example: paid
     * @queryParam date_from date Factures à partir de cette date. Example: 2025-01-01
     * @queryParam date_to date Factures jusqu'à cette date. Example: 2025-12-31
     * @queryParam with_client boolean Inclure les informations du client. Example: true
     * @queryParam with_details boolean Inclure les détails de la facture. Example: true
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "facture_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "facture_number": "FACT-2025-00001",
     *       "reference": "REF-001",
     *       "client_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "facture_date": "2025-01-15T10:30:00Z",
     *       "due_date": "2025-02-15",
     *       "montant_ht": "100000.00",
     *       "taxe_rate": "18.00",
     *       "transport_cost": "5000.00",
     *       "discount_amount": "2000.00",
     *       "total_amount": "121000.00",
     *       "paid_amount": "121000.00",
     *       "statut": "paid",
     *       "delivery_adresse": "123 Rue de la Paix, Cotonou",
     *       "note": "Livraison express",
     *       "user_id": "550e8400-e29b-41d4-a716-446655440002",
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
            'client_id' => 'uuid|exists:clients,client_id',
            'statut' => 'in:pending,paid,partially_paid,cancelled,overdue',
            'date_from' => 'date',
            'date_to' => 'date|after_or_equal:date_from',
            'with_client' => 'boolean',
            'with_details' => 'boolean',
        ]);

        $query = Facture::query();

        // Recherche par numéro ou référence
        if (isset($validated['search'])) {
            $search = $validated['search'];
            $query->where(function ($q) use ($search) {
                $q->where('facture_number', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        // Filtre par client
        if (isset($validated['client_id'])) {
            $query->where('client_id', $validated['client_id']);
        }

        // Filtre par statut
        if (isset($validated['statut'])) {
            $query->where('statut', $validated['statut']);
        }

        // Filtre par date
        if (isset($validated['date_from'])) {
            $query->whereDate('facture_date', '>=', $validated['date_from']);
        }

        if (isset($validated['date_to'])) {
            $query->whereDate('facture_date', '<=', $validated['date_to']);
        }

        // Inclure les relations
        if (isset($validated['with_client']) && $validated['with_client']) {
            $query->with('client');
        }

        if (isset($validated['with_details']) && $validated['with_details']) {
            $query->with('details.product');
        }

        $perPage = $validated['per_page'] ?? 15;
        $factures = $query->orderBy('facture_date', 'desc')->paginate($perPage);

        return response()->json($factures);
    }

    /**
     * Créer une nouvelle facture
     *
     * Crée une nouvelle facture avec ses détails.
     * Le numéro de facture (facture_number) est généré automatiquement.
     *
     * @bodyParam reference string optionnel Référence personnalisée de la facture. Example: REF-2025-001
     * @bodyParam client_id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam facture_date datetime optionnel Date de la facture (défaut: maintenant). Example: 2025-01-15 10:30:00
     * @bodyParam due_date date optionnel Date d'échéance. Example: 2025-02-15
     * @bodyParam taxe_rate number optionnel Taux de taxe en pourcentage (défaut: 0). Example: 18
     * @bodyParam transport_cost number optionnel Coût de transport (défaut: 0). Example: 5000
     * @bodyParam discount_amount number optionnel Montant de réduction (défaut: 0). Example: 2000
     * @bodyParam delivery_adresse string optionnel Adresse de livraison. Example: 123 Rue de la Paix, Cotonou
     * @bodyParam note string optionnel Note ou commentaire. Example: Livraison express
     * @bodyParam user_id string required UUID de l'utilisateur créant la facture. Idéalement l'utilisateur connecté.Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam details array required Détails de la facture (lignes de produits).
     * @bodyParam details[].product_id string required UUID du produit. Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam details[].quantite number required Quantité du produit. Example: 10
     * @bodyParam details[].prix_unitaire number required Prix unitaire. Example: 10000
     * @bodyParam details[].taxe_rate number optionnel Taux de taxe pour ce produit (défaut: 0). Example: 18
     * @bodyParam details[].discount_amount number optionnel Réduction pour ce produit (défaut: 0). Example: 500
     *
     * @response 201 {
     *   "data": {
     *     "facture_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "facture_number": "FACT-2025-00001",
     *     "reference": "REF-2025-001",
     *     "client_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "facture_date": "2025-01-15T10:30:00Z",
     *     "due_date": "2025-02-15",
     *     "montant_ht": "100000.00",
     *     "taxe_rate": "18.00",
     *     "transport_cost": "5000.00",
     *     "discount_amount": "2000.00",
     *     "total_amount": "121000.00",
     *     "paid_amount": "0.00",
     *     "statut": "pending",
     *     "delivery_adresse": "123 Rue de la Paix, Cotonou",
     *     "note": "Livraison express",
     *     "user_id": "550e8400-e29b-41d4-a716-446655440002",
     *     "created_at": "2025-01-15T10:30:00Z",
     *     "updated_at": "2025-01-15T10:30:00Z",
     *     "details": [
     *       {
     *         "facture_detail_id": "550e8400-e29b-41d4-a716-446655440003",
     *         "product_id": "550e8400-e29b-41d4-a716-446655440004",
     *         "quantite": 10,
     *         "prix_unitaire": "10000.00",
     *         "montant_total": "99500.00",
     *         "taxe_rate": "18.00",
     *         "discount_amount": "500.00"
     *       }
     *     ]
     *   },
     *   "message": "Facture créée avec succès"
     * }
     * @response 422 {
     *   "message": "Données de validation échouées",
     *   "errors": {
     *     "client_id": ["Le client sélectionné n'existe pas"],
     *     "details": ["Les détails de la facture sont requis"]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reference' => 'nullable|string|max:255',
            'client_id' => 'required|uuid|exists:clients,client_id',
            'facture_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:facture_date',
            'taxe_rate' => 'nullable|numeric|min:0|max:100',
            'transport_cost' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'delivery_adresse' => 'nullable|string|max:500',
            'note' => 'nullable|string|max:1000',
            'user_id' => 'required|uuid|exists:users,user_id',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|uuid|exists:products,product_id',
            'details.*.quantite' => 'required|numeric|min:0.01',
            'details.*.prix_unitaire' => 'required|numeric|min:0',
            'details.*.taxe_rate' => 'nullable|numeric|min:0|max:100',
            'details.*.discount_amount' => 'nullable|numeric|min:0',
        ], [
            'client_id.required' => 'Le client est requis',
            'client_id.exists' => 'Le client sélectionné n\'existe pas',
            'user_id.required' => 'L\'utilisateur est requis',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas',
            'details.required' => 'Les détails de la facture sont requis',
            'details.min' => 'La facture doit contenir au moins un produit',
            'details.*.product_id.exists' => 'Un des produits sélectionnés n\'existe pas',
            'details.*.quantite.min' => 'La quantité doit être supérieure à 0',
            'details.*.prix_unitaire.min' => 'Le prix unitaire doit être positif',
        ]);

        DB::beginTransaction();
        try {
            // Calculer le montant HT total
            $montantHT = 0;
            foreach ($validated['details'] as $detail) {
                $montantHT += ($detail['quantite'] * $detail['prix_unitaire']) - ($detail['discount_amount'] ?? 0);
            }

            // Calculer le montant total
            $taxeRate = $validated['taxe_rate'] ?? 0;
            $transportCost = $validated['transport_cost'] ?? 0;
            $discountAmount = $validated['discount_amount'] ?? 0;

            $totalAmount = ($montantHT * (1 + $taxeRate / 100)) + $transportCost - $discountAmount;

            // Générer le numéro de facture automatiquement
            $factureNumber = $this->generateFactureNumber();

            // Générer la référence si elle n'est pas fournie
            $reference = $validated['reference'] ?? $this->generateReference();

            // Créer la facture
            $facture = Facture::create([
                'facture_number' => $factureNumber,
                'reference' => $reference,
                'client_id' => $validated['client_id'],
                'facture_date' => $validated['facture_date'] ?? now(),
                'due_date' => $validated['due_date'] ?? null,
                'montant_ht' => $montantHT,
                'taxe_rate' => $taxeRate,
                'transport_cost' => $transportCost,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => 0,
                'statut' => 'pending',
                'delivery_adresse' => $validated['delivery_adresse'] ?? null,
                'note' => $validated['note'] ?? null,
                'user_id' => $validated['user_id'],
            ]);

            // Créer les détails
            foreach ($validated['details'] as $detailData) {
                FactureDetail::create([
                    'facture_id' => $facture->facture_id,
                    'product_id' => $detailData['product_id'],
                    'quantite' => $detailData['quantite'],
                    'prix_unitaire' => $detailData['prix_unitaire'],
                    'taxe_rate' => $detailData['taxe_rate'] ?? 0,
                    'discount_amount' => $detailData['discount_amount'] ?? 0,
                ]);
            }

            DB::commit();

            $facture->load(['details.product', 'client']);

            return response()->json([
                'data' => $facture,
                'message' => 'Facture créée avec succès'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la création de la facture',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Génère une référence unique
     * Format: REF-YYYY-NNNNN (ex: REF-2025-00001)
     *
     * @return string
     */
    private function generateReference(): string
    {
        $prefix = 'REF';
        $year = date('Y');

        // Récupérer la dernière facture avec une référence de l'année en cours
        $lastFacture = Facture::withTrashed()
            ->where('reference', 'like', "{$prefix}-{$year}-%")
            ->orderBy('reference', 'desc')
            ->lockForUpdate()
            ->first();

        if ($lastFacture) {
            // Extraire le numéro de la dernière référence
            $lastNumber = (int) substr($lastFacture->reference, -5);
            $newNumber = $lastNumber + 1;
        } else {
            // Première référence de l'année
            $newNumber = 1;
        }

        // Format: REF-YYYY-NNNNN (5 chiffres)
        return sprintf('%s-%s-%05d', $prefix, $year, $newNumber);
    }

    /**
     * Génère un numéro de facture unique
     * Format: FACT-YYYY-NNNNN (ex: FACT-2025-00001)
     *
     * @return string
     */
    private function generateFactureNumber(): string
    {
        $prefix = 'FACT';
        $year = date('Y');

        // Récupérer la dernière facture de l'année en cours
        $lastFacture = Facture::withTrashed()
            ->where('facture_number', 'like', "{$prefix}-{$year}-%")
            ->orderBy('facture_number', 'desc')
            ->lockForUpdate() // Verrouillage pour éviter les doublons en cas de requêtes simultanées
            ->first();

        if ($lastFacture) {
            // Extraire le numéro de la dernière facture
            $lastNumber = (int) substr($lastFacture->facture_number, -5);
            $newNumber = $lastNumber + 1;
        } else {
            // Première facture de l'année
            $newNumber = 1;
        }

        // Format: FACT-YYYY-NNNNN (5 chiffres)
        return sprintf('%s-%s-%05d', $prefix, $year, $newNumber);
    }

    /**
     * Afficher une facture spécifique
     *
     * Récupère les détails d'une facture par son ID.
     *
     * @urlParam id string required L'UUID de la facture. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam with_client boolean Inclure les informations du client. Example: true
     * @queryParam with_details boolean Inclure les détails de la facture. Example: true
     * @queryParam with_payments boolean Inclure les paiements associés. Example: true
     *
     * @response 200 {
     *   "data": {
     *     "facture_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "facture_number": "FACT-2025-00001",
     *     "reference": "REF-2025-001",
     *     "client": {
     *       "client_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "name_client": "John Doe",
     *       "email": "john@example.com"
     *     },
     *     "facture_date": "2025-01-15T10:30:00Z",
     *     "due_date": "2025-02-15",
     *     "total_amount": "121000.00",
     *     "paid_amount": "50000.00",
     *     "statut": "partially_paid",
     *     "details": [],
     *     "payments": []
     *   }
     * }
     * @response 404 {
     *   "message": "Facture non trouvée"
     * }
     */
    public function show(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'with_client' => 'boolean',
            'with_details' => 'boolean',
            'with_payments' => 'boolean',
        ]);

        try {
            $query = Facture::where('facture_id', $id);

            if (isset($validated['with_client']) && $validated['with_client']) {
                $query->with('client');
            }

            if (isset($validated['with_details']) && $validated['with_details']) {
                $query->with('details.product');
            }

            if (isset($validated['with_payments']) && $validated['with_payments']) {
                $query->with('paiements.paymentMethod');
            }

            $facture = $query->firstOrFail();

            return response()->json([
                'data' => $facture
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Facture non trouvée'
            ], 404);
        }
    }

    /**
     * Mettre à jour une facture
     *
     * Met à jour les informations d'une facture existante.
     * Note: Les détails de la facture doivent être mis à jour séparément.
     * Le numéro de facture (facture_number) ne peut pas être modifié.
     *
     * @urlParam id string required L'UUID de la facture. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam reference string Référence de la facture. Example: REF-2025-001-UPDATED
     * @bodyParam due_date date Date d'échéance. Example: 2025-03-15
     * @bodyParam taxe_rate number Taux de taxe. Example: 20
     * @bodyParam transport_cost number Coût de transport. Example: 7000
     * @bodyParam discount_amount number Montant de réduction. Example: 3000
     * @bodyParam delivery_adresse string Adresse de livraison. Example: 456 Avenue des Palmiers
     * @bodyParam note string Note ou commentaire. Example: Livraison urgente
     * @bodyParam statut string Statut de la facture (pending, paid, partially_paid, cancelled, overdue). Example: paid
     *
     * @response 200 {
     *   "data": {
     *     "facture_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "facture_number": "FACT-2025-00001",
     *     "reference": "REF-2025-001-UPDATED",
     *     "statut": "paid",
     *     "updated_at": "2025-01-15T11:00:00Z"
     *   },
     *   "message": "Facture mise à jour avec succès"
     * }
     * @response 404 {
     *   "message": "Facture non trouvée"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $facture = Facture::where('facture_id', $id)->firstOrFail();

            $validated = $request->validate([
                'reference' => 'nullable|string|max:255',
                'due_date' => 'nullable|date',
                'taxe_rate' => 'nullable|numeric|min:0|max:100',
                'transport_cost' => 'nullable|numeric|min:0',
                'discount_amount' => 'nullable|numeric|min:0',
                'delivery_adresse' => 'nullable|string|max:500',
                'note' => 'nullable|string|max:1000',
                'statut' => 'nullable|in:pending,paid,partially_paid,cancelled,overdue',
            ]);

            // Recalculer le total si les valeurs de taxe, transport ou remise changent
            if (isset($validated['taxe_rate']) || isset($validated['transport_cost']) || isset($validated['discount_amount'])) {
                $taxeRate = $validated['taxe_rate'] ?? $facture->taxe_rate;
                $transportCost = $validated['transport_cost'] ?? $facture->transport_cost;
                $discountAmount = $validated['discount_amount'] ?? $facture->discount_amount;

                $validated['total_amount'] = ($facture->montant_ht * (1 + $taxeRate / 100)) + $transportCost - $discountAmount;
            }

            $facture->update($validated);

            return response()->json([
                'data' => $facture->fresh(),
                'message' => 'Facture mise à jour avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Facture non trouvée'
            ], 404);
        }
    }

    /**
     * Supprimer une facture
     *
     * Supprime une facture et tous ses détails.
     * Cette action est irréversible.
     *
     * @urlParam id string required L'UUID de la facture. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "message": "Facture supprimée avec succès"
     * }
     * @response 400 {
     *   "message": "Impossible de supprimer une facture déjà payée"
     * }
     * @response 404 {
     *   "message": "Facture non trouvée"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $facture = Facture::where('facture_id', $id)->firstOrFail();

            // Empêcher la suppression d'une facture payée
            if ($facture->statut === 'paid' || $facture->paid_amount > 0) {
                return response()->json([
                    'message' => 'Impossible de supprimer une facture déjà payée'
                ], 400);
            }

            DB::beginTransaction();
            try {
                // Supprimer les détails
                $facture->details()->delete();

                // Supprimer la facture
                $facture->delete();

                DB::commit();

                return response()->json([
                    'message' => 'Facture supprimée avec succès'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Facture non trouvée'
            ], 404);
        }
    }

    /**
     * Changer le statut d'une facture
     *
     * Met à jour le statut d'une facture.
     *
     * @urlParam id string required L'UUID de la facture. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam statut string required Nouveau statut (pending, paid, partially_paid, cancelled, overdue). Example: cancelled
     *
     * @response 200 {
     *   "data": {
     *     "facture_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "statut": "cancelled"
     *   },
     *   "message": "Statut de la facture mis à jour avec succès"
     * }
     * @response 404 {
     *   "message": "Facture non trouvée"
     * }
     */
    public function updateStatus(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'statut' => 'required|in:pending,paid,partially_paid,cancelled,overdue'
        ]);

        try {
            $facture = Facture::where('facture_id', $id)->firstOrFail();
            $facture->update(['statut' => $validated['statut']]);

            return response()->json([
                'data' => [
                    'facture_id' => $facture->facture_id,
                    'statut' => $facture->statut
                ],
                'message' => 'Statut de la facture mis à jour avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Facture non trouvée'
            ], 404);
        }
    }

    /**
     * Statistiques des factures
     *
     * Récupère des statistiques sur les factures.
     *
     * @queryParam date_from date Statistiques à partir de cette date. Example: 2025-01-01
     * @queryParam date_to date Statistiques jusqu'à cette date. Example: 2025-12-31
     *
     * @response 200 {
     *   "data": {
     *     "total_factures": 150,
     *     "factures_pending": 30,
     *     "factures_paid": 100,
     *     "factures_partially_paid": 15,
     *     "factures_cancelled": 3,
     *     "factures_overdue": 2,
     *     "total_amount": "15000000.00",
     *     "total_paid": "12000000.00",
     *     "total_pending": "3000000.00",
     *     "average_invoice_amount": "100000.00"
     *   }
     * }
     */
    public function statistics(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $query = Facture::query();

        if (isset($validated['date_from'])) {
            $query->whereDate('facture_date', '>=', $validated['date_from']);
        }

        if (isset($validated['date_to'])) {
            $query->whereDate('facture_date', '<=', $validated['date_to']);
        }

        $stats = [
            'total_factures' => (clone $query)->count(),
            'factures_pending' => (clone $query)->where('statut', 'pending')->count(),
            'factures_paid' => (clone $query)->where('statut', 'paid')->count(),
            'factures_partially_paid' => (clone $query)->where('statut', 'partially_paid')->count(),
            'factures_cancelled' => (clone $query)->where('statut', 'cancelled')->count(),
            'factures_overdue' => (clone $query)->where('statut', 'overdue')->count(),
            'total_amount' => (clone $query)->sum('total_amount'),
            'total_paid' => (clone $query)->sum('paid_amount'),
            'average_invoice_amount' => (clone $query)->avg('total_amount'),
        ];

        $stats['total_pending'] = $stats['total_amount'] - $stats['total_paid'];

        // Formater les nombres
        $stats['total_amount'] = number_format($stats['total_amount'], 2, '.', '');
        $stats['total_paid'] = number_format($stats['total_paid'], 2, '.', '');
        $stats['total_pending'] = number_format($stats['total_pending'], 2, '.', '');
        $stats['average_invoice_amount'] = number_format($stats['average_invoice_amount'] ?? 0, 2, '.', '');

        return response()->json([
            'data' => $stats
        ]);
    }
}
