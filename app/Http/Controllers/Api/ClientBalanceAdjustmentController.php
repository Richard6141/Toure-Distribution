<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ClientBalanceAdjustment;
use App\Http\Requests\StoreClientBalanceAdjustmentRequest;
use App\Http\Requests\UpdateClientBalanceAdjustmentRequest;

/**
 * @group Gestion des Ajustements de Solde Client
 *
 * API pour gérer les ajustements de solde des clients.
 * Cette fonctionnalité permet d'enregistrer les dettes des clients migrés
 * depuis l'ancien système et de faire des ajustements de solde avec traçabilité complète.
 *
 * ## Convention du solde client (current_balance)
 *
 * | Situation | Valeur |
 * |-----------|--------|
 * | Le client **doit** à l'entreprise (dette) | **Négatif** (-) |
 * | L'entreprise **doit** au client (avance/crédit) | **Positif** (+) |
 *
 * ## Types d'ajustement disponibles
 *
 * | Type | Description | Effet sur le solde |
 * |------|-------------|-------------------|
 * | `dette_initiale` | Dette importée de l'ancien système | Diminue le solde (-) |
 * | `ajustement_credit` | Augmentation de la dette client | Diminue le solde (-) |
 * | `ajustement_debit` | Diminution de la dette (paiement, avoir) | Augmente le solde (+) |
 * | `correction` | Correction d'erreur (+ ou -) | Selon le signe du montant |
 * | `remise_exceptionnelle` | Remise accordée au client | Augmente le solde (+) |
 *
 * ## Sources possibles
 *
 * | Source | Description |
 * |--------|-------------|
 * | `migration` | Données importées lors de la migration système |
 * | `manuel` | Saisie manuelle par un utilisateur |
 * | `import` | Import via fichier (Excel/CSV) |
 */
class ClientBalanceAdjustmentController extends Controller
{
    /**
     * Lister les ajustements de solde
     *
     * Récupère la liste paginée des ajustements de solde avec possibilité de filtrage.
     *
     * @queryParam client_id string UUID du client pour filtrer. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam type string Type d'ajustement (dette_initiale, ajustement_credit, ajustement_debit, correction, remise_exceptionnelle). Example: dette_initiale
     * @queryParam source string Source de l'ajustement (migration, manuel, import). Example: migration
     * @queryParam date_debut date Date de début pour filtrer par période (format: Y-m-d). Example: 2024-01-01
     * @queryParam date_fin date Date de fin pour filtrer par période (format: Y-m-d). Example: 2024-12-31
     * @queryParam search string Recherche par référence, motif ou nom/code client. Example: ADJ-2024
     * @queryParam sort_by string Colonne de tri (created_at, date_ajustement, montant). Example: created_at
     * @queryParam sort_order string Ordre de tri (asc, desc). Example: desc
     * @queryParam per_page integer Nombre d'éléments par page (défaut: 15). Example: 20
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des ajustements de solde",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "adjustment_id": "550e8400-e29b-41d4-a716-446655440000",
     *         "reference": "ADJ-2024-0001",
     *         "client_id": "...",
     *         "type": "dette_initiale",
     *         "montant": "150000.00",
     *         "ancien_solde": "0.00",
     *         "nouveau_solde": "150000.00",
     *         "motif": "Dette migrée de l'ancien système",
     *         "source": "migration",
     *         "date_ajustement": "2024-01-15T10:30:00.000000Z",
     *         "client": { "client_id": "...", "name_client": "Client ABC" },
     *         "user": { "user_id": "...", "name": "Admin" }
     *       }
     *     ],
     *     "per_page": 15,
     *     "total": 50
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $query = ClientBalanceAdjustment::with(['client', 'user']);

        // Filtre par client
        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filtre par type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par source
        if ($request->has('source')) {
            $query->where('source', $request->source);
        }

        // Filtre par période
        if ($request->has('date_debut') && $request->has('date_fin')) {
            $query->whereBetween('date_ajustement', [$request->date_debut, $request->date_fin]);
        }

        // Recherche par référence, motif ou client
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('motif', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($q) use ($search) {
                      $q->where('name_client', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $adjustments = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des ajustements de solde',
            'data' => $adjustments
        ]);
    }

    /**
     * Créer un ajustement de solde
     *
     * Enregistre un nouvel ajustement de solde pour un client.
     * Le solde du client est automatiquement mis à jour.
     *
     * ## Comportement selon le type
     *
     * - **dette_initiale** / **ajustement_credit** : Diminue le solde (le client doit plus)
     * - **ajustement_debit** / **remise_exceptionnelle** : Augmente le solde (le client doit moins)
     * - **correction** : Le signe du montant est conservé tel que saisi
     *
     * > **Note** : Le montant saisi est toujours en valeur absolue. Le système applique automatiquement le signe correct.
     *
     * @bodyParam client_id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam type string required Type d'ajustement. Example: dette_initiale
     * @bodyParam montant numeric required Montant de l'ajustement (différent de 0). Example: 150000
     * @bodyParam motif string required Raison de l'ajustement (max 255 caractères). Example: Dette migrée de l'ancien système
     * @bodyParam note string Informations supplémentaires (max 1000 caractères). Example: Référence ancien système: CLI-2023-456
     * @bodyParam source string Source de l'ajustement (migration, manuel, import). Défaut: manuel. Example: migration
     * @bodyParam date_ajustement datetime Date de l'ajustement. Défaut: maintenant. Example: 2024-01-15 10:30:00
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Ajustement de solde enregistré avec succès",
     *   "data": {
     *     "adjustment": {
     *       "adjustment_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "reference": "ADJ-2024-0001",
     *       "client_id": "...",
     *       "type": "dette_initiale",
     *       "montant": "150000.00",
     *       "ancien_solde": "0.00",
     *       "nouveau_solde": "150000.00",
     *       "motif": "Dette migrée de l'ancien système",
     *       "source": "migration",
     *       "date_ajustement": "2024-01-15T10:30:00.000000Z"
     *     },
     *     "client": {
     *       "client_id": "...",
     *       "name_client": "Client ABC",
     *       "ancien_solde": 0,
     *       "nouveau_solde": 150000,
     *       "formatted_ancien_solde": "0,00 FCFA",
     *       "formatted_nouveau_solde": "150 000,00 FCFA"
     *     }
     *   }
     * }
     *
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation des données",
     *   "errors": {
     *     "client_id": ["Le client sélectionné n'existe pas"],
     *     "montant": ["Le montant ne peut pas être égal à zéro"]
     *   }
     * }
     *
     * @response 500 {
     *   "success": false,
     *   "message": "Erreur lors de l'enregistrement de l'ajustement",
     *   "error": "Message d'erreur détaillé"
     * }
     */
    public function store(StoreClientBalanceAdjustmentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Récupérer le client
            $client = Client::findOrFail($request->client_id);
            $ancienSolde = $client->current_balance;

            // Déterminer le montant selon le type d'ajustement
            // Convention: solde négatif = client doit à l'entreprise (dette)
            //             solde positif = entreprise doit au client (avance/crédit)
            $montant = $request->montant;

            // Pour les types qui augmentent la dette (diminuent le solde), on applique un montant négatif
            if (in_array($request->type, ['dette_initiale', 'ajustement_credit'])) {
                $montant = -abs($montant);
            }
            // Pour les types qui diminuent la dette (augmentent le solde), on applique un montant positif
            elseif (in_array($request->type, ['ajustement_debit', 'remise_exceptionnelle'])) {
                $montant = abs($montant);
            }
            // Pour les corrections, on garde le signe du montant saisi

            // Calculer le nouveau solde
            $nouveauSolde = $ancienSolde + $montant;

            // Créer l'ajustement
            $adjustment = ClientBalanceAdjustment::create([
                'client_id' => $request->client_id,
                'type' => $request->type,
                'montant' => $montant,
                'ancien_solde' => $ancienSolde,
                'nouveau_solde' => $nouveauSolde,
                'motif' => $request->motif,
                'note' => $request->note,
                'source' => $request->source ?? 'manuel',
                'date_ajustement' => $request->date_ajustement ?? now(),
                'user_id' => auth()->id(),
            ]);

            // Mettre à jour le solde du client
            $client->current_balance = $nouveauSolde;
            $client->save();

            DB::commit();

            // Charger les relations
            $adjustment->load(['client', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Ajustement de solde enregistré avec succès',
                'data' => [
                    'adjustment' => $adjustment,
                    'client' => [
                        'client_id' => $client->client_id,
                        'name_client' => $client->name_client,
                        'ancien_solde' => $ancienSolde,
                        'nouveau_solde' => $nouveauSolde,
                        'formatted_ancien_solde' => number_format($ancienSolde, 2, ',', ' ') . ' FCFA',
                        'formatted_nouveau_solde' => number_format($nouveauSolde, 2, ',', ' ') . ' FCFA',
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement de l\'ajustement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un ajustement
     *
     * Récupère les détails d'un ajustement de solde spécifique.
     *
     * @urlParam id string required UUID de l'ajustement. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "adjustment_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "reference": "ADJ-2024-0001",
     *     "client_id": "...",
     *     "type": "dette_initiale",
     *     "montant": "150000.00",
     *     "ancien_solde": "0.00",
     *     "nouveau_solde": "150000.00",
     *     "motif": "Dette migrée de l'ancien système",
     *     "note": "Référence ancien système: CLI-2023-456",
     *     "source": "migration",
     *     "date_ajustement": "2024-01-15T10:30:00.000000Z",
     *     "client": { "client_id": "...", "name_client": "Client ABC", "code": "CLI001" },
     *     "user": { "user_id": "...", "name": "Admin" }
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Ajustement non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $adjustment = ClientBalanceAdjustment::with(['client', 'user'])->find($id);

        if (!$adjustment) {
            return response()->json([
                'success' => false,
                'message' => 'Ajustement non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $adjustment
        ]);
    }

    /**
     * Modifier un ajustement
     *
     * Met à jour les informations d'un ajustement existant.
     *
     * **Important** : Seuls le motif et la note peuvent être modifiés.
     * Le montant et le type ne peuvent pas être changés pour préserver l'intégrité comptable.
     * Pour corriger un montant erroné, annulez l'ajustement et créez-en un nouveau.
     *
     * @urlParam id string required UUID de l'ajustement. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @bodyParam motif string Nouvelle raison de l'ajustement (max 255 caractères). Example: Correction du motif
     * @bodyParam note string Nouvelles informations supplémentaires (max 1000 caractères). Example: Note mise à jour
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Ajustement mis à jour avec succès",
     *   "data": {
     *     "adjustment_id": "...",
     *     "reference": "ADJ-2024-0001",
     *     "motif": "Correction du motif",
     *     "note": "Note mise à jour",
     *     "client": { ... },
     *     "user": { ... }
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Ajustement non trouvé"
     * }
     */
    public function update(UpdateClientBalanceAdjustmentRequest $request, string $id): JsonResponse
    {
        $adjustment = ClientBalanceAdjustment::find($id);

        if (!$adjustment) {
            return response()->json([
                'success' => false,
                'message' => 'Ajustement non trouvé'
            ], 404);
        }

        // On ne peut modifier que le motif et la note
        $adjustment->update($request->only(['motif', 'note']));

        return response()->json([
            'success' => true,
            'message' => 'Ajustement mis à jour avec succès',
            'data' => $adjustment->load(['client', 'user'])
        ]);
    }

    /**
     * Annuler un ajustement
     *
     * Annule un ajustement de solde (soft delete).
     * Le solde du client est automatiquement recalculé pour annuler l'effet de l'ajustement.
     *
     * **Attention** : Cette action inverse l'effet de l'ajustement sur le solde du client.
     *
     * @urlParam id string required UUID de l'ajustement à annuler. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Ajustement annulé avec succès",
     *   "data": {
     *     "adjustment_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "client_nouveau_solde": 0
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Ajustement non trouvé"
     * }
     *
     * @response 500 {
     *   "success": false,
     *   "message": "Erreur lors de l'annulation de l'ajustement",
     *   "error": "Message d'erreur détaillé"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $adjustment = ClientBalanceAdjustment::find($id);

            if (!$adjustment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ajustement non trouvé'
                ], 404);
            }

            // Récupérer le client et annuler l'effet de l'ajustement
            $client = Client::find($adjustment->client_id);
            if ($client) {
                // Inverser l'ajustement
                $client->current_balance -= $adjustment->montant;
                $client->save();
            }

            // Soft delete
            $adjustment->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ajustement annulé avec succès',
                'data' => [
                    'adjustment_id' => $id,
                    'client_nouveau_solde' => $client ? $client->current_balance : null
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'annulation de l\'ajustement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restaurer un ajustement annulé
     *
     * Restaure un ajustement précédemment annulé et ré-applique son effet sur le solde du client.
     *
     * @urlParam id string required UUID de l'ajustement à restaurer. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Ajustement restauré avec succès",
     *   "data": {
     *     "adjustment_id": "...",
     *     "reference": "ADJ-2024-0001",
     *     "client": { ... },
     *     "user": { ... }
     *   }
     * }
     *
     * @response 400 {
     *   "success": false,
     *   "message": "Cet ajustement n'est pas supprimé"
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Ajustement non trouvé"
     * }
     */
    public function restore(string $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $adjustment = ClientBalanceAdjustment::withTrashed()->find($id);

            if (!$adjustment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ajustement non trouvé'
                ], 404);
            }

            if (!$adjustment->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cet ajustement n\'est pas supprimé'
                ], 400);
            }

            // Ré-appliquer l'ajustement au solde du client
            $client = Client::find($adjustment->client_id);
            if ($client) {
                $client->current_balance += $adjustment->montant;
                $client->save();
            }

            $adjustment->restore();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ajustement restauré avec succès',
                'data' => $adjustment->load(['client', 'user'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration de l\'ajustement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lister les ajustements annulés
     *
     * Récupère la liste des ajustements qui ont été annulés (soft deleted).
     *
     * @queryParam client_id string UUID du client pour filtrer. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam per_page integer Nombre d'éléments par page (défaut: 15). Example: 20
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des ajustements supprimés",
     *   "data": {
     *     "current_page": 1,
     *     "data": [ ... ],
     *     "per_page": 15,
     *     "total": 5
     *   }
     * }
     */
    public function trashed(Request $request): JsonResponse
    {
        $query = ClientBalanceAdjustment::onlyTrashed()->with(['client', 'user']);

        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $perPage = $request->get('per_page', 15);
        $adjustments = $query->orderBy('deleted_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des ajustements supprimés',
            'data' => $adjustments
        ]);
    }

    /**
     * Historique des ajustements d'un client
     *
     * Récupère l'historique complet des ajustements de solde pour un client spécifique,
     * avec un résumé de son solde actuel et de sa dette initiale.
     *
     * @urlParam client_id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Historique des ajustements du client",
     *   "data": {
     *     "client": {
     *       "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "code": "CLI001",
     *       "name_client": "Client ABC",
     *       "current_balance": 150000,
     *       "formatted_current_balance": "150 000,00 FCFA"
     *     },
     *     "adjustments": [
     *       {
     *         "adjustment_id": "...",
     *         "reference": "ADJ-2024-0001",
     *         "type": "dette_initiale",
     *         "montant": "150000.00",
     *         "motif": "Dette migrée",
     *         "date_ajustement": "2024-01-15T10:30:00.000000Z",
     *         "user": { "name": "Admin" }
     *       }
     *     ],
     *     "total_adjustments": 1,
     *     "total_dette_initiale": 150000
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Client non trouvé"
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

        $adjustments = ClientBalanceAdjustment::with('user')
            ->where('client_id', $clientId)
            ->orderBy('date_ajustement', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Historique des ajustements du client',
            'data' => [
                'client' => [
                    'client_id' => $client->client_id,
                    'code' => $client->code,
                    'name_client' => $client->name_client,
                    'current_balance' => $client->current_balance,
                    'formatted_current_balance' => $client->formatted_current_balance,
                ],
                'adjustments' => $adjustments,
                'total_adjustments' => $adjustments->count(),
                'total_dette_initiale' => $adjustments->where('type', 'dette_initiale')->sum('montant'),
            ]
        ]);
    }

    /**
     * Import en masse des dettes (Migration)
     *
     * Permet d'importer plusieurs dettes initiales en une seule requête.
     * Idéal pour la migration des données depuis l'ancien système.
     *
     * Toutes les dettes sont enregistrées avec :
     * - type: `dette_initiale`
     * - source: `migration`
     *
     * @bodyParam adjustments array required Liste des ajustements à créer.
     * @bodyParam adjustments[].client_id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam adjustments[].montant numeric required Montant de la dette (sera converti en positif). Example: 150000
     * @bodyParam adjustments[].motif string Motif personnalisé (défaut: "Dette migrée de l'ancien système"). Example: Dette 2023
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Import des dettes terminé",
     *   "data": {
     *     "total_processed": 3,
     *     "total_errors": 0,
     *     "results": [
     *       {
     *         "client_id": "...",
     *         "client_name": "Client ABC",
     *         "adjustment_id": "...",
     *         "montant": 150000,
     *         "nouveau_solde": 150000
     *       }
     *     ],
     *     "errors": []
     *   }
     * }
     *
     * @response 207 {
     *   "success": true,
     *   "message": "Import des dettes terminé",
     *   "data": {
     *     "total_processed": 2,
     *     "total_errors": 1,
     *     "results": [ ... ],
     *     "errors": [
     *       {
     *         "index": 2,
     *         "client_id": "invalid-uuid",
     *         "error": "Client non trouvé"
     *       }
     *     ]
     *   }
     * }
     *
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": { ... }
     * }
     */
    public function bulkStore(Request $request): JsonResponse
    {
        $request->validate([
            'adjustments' => 'required|array|min:1',
            'adjustments.*.client_id' => 'required|uuid|exists:clients,client_id',
            'adjustments.*.montant' => 'required|numeric|not_in:0',
            'adjustments.*.motif' => 'nullable|string|max:255',
        ], [
            'adjustments.required' => 'La liste des ajustements est requise',
            'adjustments.array' => 'La liste des ajustements doit être un tableau',
            'adjustments.min' => 'Au moins un ajustement est requis',
            'adjustments.*.client_id.required' => 'L\'identifiant du client est requis pour chaque ajustement',
            'adjustments.*.client_id.uuid' => 'L\'identifiant du client doit être un UUID valide',
            'adjustments.*.client_id.exists' => 'Le client spécifié n\'existe pas',
            'adjustments.*.montant.required' => 'Le montant est requis pour chaque ajustement',
            'adjustments.*.montant.numeric' => 'Le montant doit être un nombre',
            'adjustments.*.montant.not_in' => 'Le montant ne peut pas être égal à zéro',
        ]);

        try {
            DB::beginTransaction();

            $results = [];
            $errors = [];

            foreach ($request->adjustments as $index => $adjustmentData) {
                try {
                    $client = Client::find($adjustmentData['client_id']);
                    $ancienSolde = $client->current_balance;
                    // Dette = montant négatif (diminue le solde car le client doit à l'entreprise)
                    $montant = -abs($adjustmentData['montant']);
                    $nouveauSolde = $ancienSolde + $montant;

                    $adjustment = ClientBalanceAdjustment::create([
                        'client_id' => $adjustmentData['client_id'],
                        'type' => 'dette_initiale',
                        'montant' => $montant,
                        'ancien_solde' => $ancienSolde,
                        'nouveau_solde' => $nouveauSolde,
                        'motif' => $adjustmentData['motif'] ?? 'Dette migrée de l\'ancien système',
                        'source' => 'migration',
                        'date_ajustement' => now(),
                        'user_id' => auth()->id(),
                    ]);

                    $client->current_balance = $nouveauSolde;
                    $client->save();

                    $results[] = [
                        'index' => $index,
                        'client_id' => $client->client_id,
                        'client_name' => $client->name_client,
                        'client_code' => $client->code,
                        'adjustment_id' => $adjustment->adjustment_id,
                        'reference' => $adjustment->reference,
                        'montant' => $montant,
                        'ancien_solde' => $ancienSolde,
                        'nouveau_solde' => $nouveauSolde,
                    ];

                } catch (\Exception $e) {
                    $errors[] = [
                        'index' => $index,
                        'client_id' => $adjustmentData['client_id'] ?? null,
                        'error' => $e->getMessage()
                    ];
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Import des dettes terminé',
                'data' => [
                    'total_processed' => count($results),
                    'total_errors' => count($errors),
                    'results' => $results,
                    'errors' => $errors,
                ]
            ], count($errors) > 0 ? 207 : 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'import des dettes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Statistiques des ajustements
     *
     * Récupère des statistiques globales sur les ajustements de solde.
     *
     * @queryParam date_debut date Date de début pour filtrer (format: Y-m-d). Example: 2024-01-01
     * @queryParam date_fin date Date de fin pour filtrer (format: Y-m-d). Example: 2024-12-31
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Statistiques des ajustements",
     *   "data": {
     *     "total_adjustments": 150,
     *     "total_dettes_initiales": 5000000,
     *     "total_credits": 200000,
     *     "total_debits": -150000,
     *     "total_corrections": 50000,
     *     "total_remises": -100000,
     *     "by_source": {
     *       "migration": 100,
     *       "manuel": 45,
     *       "import": 5
     *     },
     *     "clients_with_migration_debt": 80,
     *     "total_client_balance": 4800000,
     *     "formatted_total_dettes_initiales": "5 000 000,00 FCFA",
     *     "formatted_total_client_balance": "4 800 000,00 FCFA"
     *   }
     * }
     */
    public function statistics(Request $request): JsonResponse
    {
        $query = ClientBalanceAdjustment::query();

        // Filtre par période
        if ($request->has('date_debut') && $request->has('date_fin')) {
            $query->whereBetween('date_ajustement', [$request->date_debut, $request->date_fin]);
        }

        // Statistiques globales
        $totalDettesInitiales = (clone $query)->where('type', 'dette_initiale')->sum('montant');
        $totalCredits = (clone $query)->where('type', 'ajustement_credit')->sum('montant');
        $totalDebits = (clone $query)->where('type', 'ajustement_debit')->sum('montant');
        $totalCorrections = (clone $query)->where('type', 'correction')->sum('montant');
        $totalRemises = (clone $query)->where('type', 'remise_exceptionnelle')->sum('montant');
        $totalClientBalance = Client::sum('current_balance');

        $stats = [
            'total_adjustments' => $query->count(),
            'total_dettes_initiales' => $totalDettesInitiales,
            'total_credits' => $totalCredits,
            'total_debits' => $totalDebits,
            'total_corrections' => $totalCorrections,
            'total_remises' => $totalRemises,
            'by_source' => [
                'migration' => (clone $query)->where('source', 'migration')->count(),
                'manuel' => (clone $query)->where('source', 'manuel')->count(),
                'import' => (clone $query)->where('source', 'import')->count(),
            ],
            'by_type' => [
                'dette_initiale' => (clone $query)->where('type', 'dette_initiale')->count(),
                'ajustement_credit' => (clone $query)->where('type', 'ajustement_credit')->count(),
                'ajustement_debit' => (clone $query)->where('type', 'ajustement_debit')->count(),
                'correction' => (clone $query)->where('type', 'correction')->count(),
                'remise_exceptionnelle' => (clone $query)->where('type', 'remise_exceptionnelle')->count(),
            ],
            'clients_with_migration_debt' => Client::whereHas('balanceAdjustments', function ($q) {
                $q->where('type', 'dette_initiale')->where('source', 'migration');
            })->count(),
            'total_client_balance' => $totalClientBalance,
            // Valeurs formatées
            'formatted_total_dettes_initiales' => number_format($totalDettesInitiales, 2, ',', ' ') . ' FCFA',
            'formatted_total_credits' => number_format($totalCredits, 2, ',', ' ') . ' FCFA',
            'formatted_total_debits' => number_format($totalDebits, 2, ',', ' ') . ' FCFA',
            'formatted_total_corrections' => number_format($totalCorrections, 2, ',', ' ') . ' FCFA',
            'formatted_total_remises' => number_format($totalRemises, 2, ',', ' ') . ' FCFA',
            'formatted_total_client_balance' => number_format($totalClientBalance, 2, ',', ' ') . ' FCFA',
        ];

        return response()->json([
            'success' => true,
            'message' => 'Statistiques des ajustements',
            'data' => $stats
        ]);
    }

    /**
     * Types et sources disponibles
     *
     * Retourne la liste des types d'ajustement et des sources disponibles.
     * Utile pour alimenter les listes déroulantes dans l'interface utilisateur.
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "types": {
     *       "dette_initiale": "Dette initiale (Migration)",
     *       "ajustement_credit": "Ajustement crédit",
     *       "ajustement_debit": "Ajustement débit",
     *       "correction": "Correction",
     *       "remise_exceptionnelle": "Remise exceptionnelle"
     *     },
     *     "sources": {
     *       "migration": "Migration système",
     *       "manuel": "Saisie manuelle",
     *       "import": "Import fichier"
     *     },
     *     "type_effects": {
     *       "dette_initiale": "Augmente le solde (+)",
     *       "ajustement_credit": "Augmente le solde (+)",
     *       "ajustement_debit": "Diminue le solde (-)",
     *       "correction": "Selon le signe du montant",
     *       "remise_exceptionnelle": "Diminue le solde (-)"
     *     }
     *   }
     * }
     */
    public function types(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'types' => ClientBalanceAdjustment::getTypes(),
                'sources' => ClientBalanceAdjustment::getSources(),
                'type_effects' => [
                    'dette_initiale' => 'Diminue le solde (-) - Le client doit plus',
                    'ajustement_credit' => 'Diminue le solde (-) - Le client doit plus',
                    'ajustement_debit' => 'Augmente le solde (+) - Le client doit moins',
                    'correction' => 'Selon le signe du montant saisi',
                    'remise_exceptionnelle' => 'Augmente le solde (+) - Le client doit moins',
                ],
                'balance_convention' => [
                    'negative' => 'Le client doit à l\'entreprise (dette)',
                    'positive' => 'L\'entreprise doit au client (avance/crédit)',
                    'zero' => 'Aucune dette ni crédit',
                ]
            ]
        ]);
    }
}
