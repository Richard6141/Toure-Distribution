<?php

namespace App\Http\Controllers\Api;

use App\Models\BanqueTransaction;
use App\Models\BanqueAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * @group Gestion des Transactions Bancaires
 * 
 * APIs pour gérer les transactions bancaires du système.
 * 
 * **Authentification requise**: Toutes les routes nécessitent un Bearer Token.
 * 
 * **Header requis pour toutes les requêtes:**
 * ```
 * Authorization: Bearer {votre_token}
 * Content-Type: application/json
 * Accept: application/json
 * ```
 */
class BanqueTransactionController extends Controller
{
    /**
     * Lister toutes les transactions
     *
     * Récupère la liste complète de toutes les transactions avec leurs comptes associés.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "banque_account_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "transaction_number": "TRX-2025-001",
     *       "transaction_date": "2025-01-15",
     *       "transaction_type": "credit",
     *       "montant": 5000000.00,
     *       "libelle": "Virement reçu - Facture #FAC-2025-001",
     *       "reference_externe": "VIR123456789",
     *       "tiers": "Client ABC SARL",
     *       "status": "valide",
     *       "created_at": "2025-01-15T10:30:00.000000Z",
     *       "updated_at": "2025-01-15T10:30:00.000000Z",
     *       "deleted_at": null,
     *       "account": {
     *         "banque_account_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *         "account_number": "BJ066001010100100100100100",
     *         "account_name": "Compte Principal"
     *       }
     *     }
     *   ],
     *   "message": "Liste des transactions"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function index(): JsonResponse
    {
        $transactions = BanqueTransaction::with('account.banque')->get();

        return response()->json([
            'data' => $transactions,
            'message' => 'Liste des transactions'
        ]);
    }

    /**
     * Créer une nouvelle transaction
     *
     * Crée une nouvelle transaction bancaire et met à jour le solde du compte.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @bodyParam banque_account_id string required UUID du compte bancaire. Example: "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b"
     * @bodyParam transaction_number string required Numéro unique de la transaction. Example: "TRX-2025-001"
     * @bodyParam transaction_date date required Date de la transaction (YYYY-MM-DD). Example: "2025-01-15"
     * @bodyParam transaction_type string required Type (debit, credit, virement, cheque, retrait, depot). Example: "credit"
     * @bodyParam montant numeric required Montant de la transaction. Example: 5000000.00
     * @bodyParam libelle string required Description de la transaction. Example: "Virement reçu - Facture #FAC-2025-001"
     * @bodyParam reference_externe string optional Référence externe (numéro chèque, référence virement). Example: "VIR123456789"
     * @bodyParam tiers string optional Nom du tiers (destinataire ou émetteur). Example: "Client ABC SARL"
     * @bodyParam status string optional Statut (en_attente, valide, rejete, annule). Example: "valide"
     *
     * @response 201 scenario="Transaction créée avec succès" {
     *   "data": {
     *     "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "banque_account_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "transaction_number": "TRX-2025-001",
     *     "transaction_date": "2025-01-15",
     *     "transaction_type": "credit",
     *     "montant": 5000000.00,
     *     "libelle": "Virement reçu - Facture #FAC-2025-001",
     *     "reference_externe": "VIR123456789",
     *     "tiers": "Client ABC SARL",
     *     "status": "valide",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null,
     *     "account": {
     *       "banque_account_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "account_number": "BJ066001010100100100100100",
     *       "balance": 20500000.00
     *     }
     *   },
     *   "message": "Transaction créée avec succès"
     * }
     *
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "transaction_number": ["Ce numéro de transaction existe déjà"],
     *     "banque_account_id": ["Le compte bancaire sélectionné n'existe pas"]
     *   }
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'banque_account_id' => 'required|uuid|exists:banque_accounts,banque_account_id',
            'transaction_number' => 'required|string|max:255|unique:banque_transactions,transaction_number',
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:debit,credit,virement,cheque,retrait,depot',
            'montant' => 'required|numeric|min:0',
            'libelle' => 'required|string',
            'reference_externe' => 'nullable|string|max:255',
            'tiers' => 'nullable|string|max:255',
            'status' => 'nullable|in:en_attente,valide,rejete,annule',
        ];

        $messages = [
            'banque_account_id.required' => 'Le compte bancaire est obligatoire',
            'banque_account_id.exists' => 'Le compte bancaire sélectionné n\'existe pas',
            'transaction_number.required' => 'Le numéro de transaction est obligatoire',
            'transaction_number.unique' => 'Ce numéro de transaction existe déjà',
            'transaction_date.required' => 'La date de transaction est obligatoire',
            'transaction_type.required' => 'Le type de transaction est obligatoire',
            'montant.required' => 'Le montant est obligatoire',
            'montant.min' => 'Le montant doit être positif',
            'libelle.required' => 'Le libellé est obligatoire',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $transaction = BanqueTransaction::create($validator->validated());

            // Mettre à jour le solde si la transaction est validée
            if ($transaction->status === 'valide') {
                $account = BanqueAccount::findOrFail($transaction->banque_account_id);

                if (in_array($transaction->transaction_type, ['credit', 'depot'])) {
                    $account->credit($transaction->montant);
                } elseif (in_array($transaction->transaction_type, ['debit', 'retrait', 'cheque'])) {
                    $account->debit($transaction->montant);
                }
            }

            $transaction->load('account');
            DB::commit();

            return response()->json([
                'data' => $transaction,
                'message' => 'Transaction créée avec succès'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la création de la transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher une transaction spécifique
     *
     * Récupère les détails complets d'une transaction.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID de la transaction. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     *
     * @response 200 scenario="Transaction trouvée" {
     *   "data": {
     *     "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "banque_account_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "transaction_number": "TRX-2025-001",
     *     "transaction_date": "2025-01-15",
     *     "transaction_type": "credit",
     *     "montant": 5000000.00,
     *     "libelle": "Virement reçu - Facture #FAC-2025-001",
     *     "reference_externe": "VIR
     * 123456789",
     *     "tiers": "Client ABC SARL",
     *     "status": "valide",
     *     "account": {
     *       "banque_account_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "account_number": "BJ066001010100100100100100",
     *       "account_name": "Compte Principal",
     *       "balance": 20500000.00
     *     }
     *   },
     *   "message": "Détails de la transaction"
     * }
     * 
     * @response 404 scenario="Transaction non trouvée" {
     *   "message": "No query results for model [App\\Models\\BanqueTransaction]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function show(string $id): JsonResponse
    {
        $transaction = BanqueTransaction::with('account.banque')->findOrFail($id);

        return response()->json([
            'data' => $transaction,
            'message' => 'Détails de la transaction'
        ]);
    }

    /**
     * Mettre à jour une transaction
     *
     * Met à jour les informations d'une transaction existante.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID de la transaction à mettre à jour. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     *
     * @bodyParam banque_account_id string required UUID du compte bancaire. Example: "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b"
     * @bodyParam transaction_number string required Numéro de transaction (unique). Example: "TRX-2025-001"
     * @bodyParam transaction_date date required Date de la transaction. Example: "2025-01-15"
     * @bodyParam transaction_type string required Type de transaction. Example: "credit"
     * @bodyParam montant numeric required Montant. Example: 5500000.00
     * @bodyParam libelle string required Description. Example: "Virement reçu - Facture #FAC-2025-001 (modifié)"
     * @bodyParam reference_externe string optional Référence externe. Example: "VIR123456789"
     * @bodyParam tiers string optional Tiers. Example: "Client ABC SARL"
     * @bodyParam status string optional Statut. Example: "valide"
     *
     * @response 200 scenario="Mise à jour réussie" {
     *   "data": {
     *     "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "banque_account_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "transaction_number": "TRX-2025-001",
     *     "transaction_date": "2025-01-15",
     *     "transaction_type": "credit",
     *     "montant": 5500000.00,
     *     "libelle": "Virement reçu - Facture #FAC-2025-001 (modifié)",
     *     "status": "valide",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-16T15:45:00.000000Z"
     *   },
     *   "message": "Transaction mise à jour avec succès"
     * }
     * 
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "transaction_number": ["Ce numéro de transaction existe déjà"]
     *   }
     * }
     * 
     * @response 404 scenario="Transaction non trouvée" {
     *   "message": "No query results for model [App\\Models\\BanqueTransaction]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $transaction = BanqueTransaction::findOrFail($id);

        $rules = [
            'banque_account_id' => 'required|uuid|exists:banque_accounts,banque_account_id',
            'transaction_number' => 'required|string|max:255|unique:banque_transactions,transaction_number,' . $transaction->banque_transaction_id . ',banque_transaction_id',
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:debit,credit,virement,cheque,retrait,depot',
            'montant' => 'required|numeric|min:0',
            'libelle' => 'required|string',
            'reference_externe' => 'nullable|string|max:255',
            'tiers' => 'nullable|string|max:255',
            'status' => 'nullable|in:en_attente,valide,rejete,annule',
        ];

        $messages = [
            'banque_account_id.required' => 'Le compte bancaire est obligatoire',
            'banque_account_id.exists' => 'Le compte bancaire sélectionné n\'existe pas',
            'transaction_number.required' => 'Le numéro de transaction est obligatoire',
            'transaction_number.unique' => 'Ce numéro de transaction existe déjà',
            'transaction_date.required' => 'La date de transaction est obligatoire',
            'transaction_type.required' => 'Le type de transaction est obligatoire',
            'montant.required' => 'Le montant est obligatoire',
            'libelle.required' => 'Le libellé est obligatoire',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transaction->update($validator->validated());
        $transaction->load('account');

        return response()->json([
            'data' => $transaction,
            'message' => 'Transaction mise à jour avec succès'
        ]);
    }

    /**
     * Supprimer une transaction (soft delete)
     *
     * Effectue une suppression logique de la transaction.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID de la transaction à supprimer. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Suppression réussie" {
     *   "message": "Transaction supprimée avec succès"
     * }
     * 
     * @response 404 scenario="Transaction non trouvée" {
     *   "message": "No query results for model [App\\Models\\BanqueTransaction]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $transaction = BanqueTransaction::findOrFail($id);
        $transaction->delete();

        return response()->json([
            'message' => 'Transaction supprimée avec succès'
        ]);
    }

    /**
     * Restaurer une transaction supprimée
     *
     * Restaure une transaction supprimée logiquement.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID de la transaction à restaurer. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Restauration réussie" {
     *   "data": {
     *     "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "transaction_number": "TRX-2025-001",
     *     "montant": 5000000.00,
     *     "deleted_at": null
     *   },
     *   "message": "Transaction restaurée avec succès"
     * }
     * 
     * @response 404 scenario="Transaction non trouvée" {
     *   "message": "No query results for model [App\\Models\\BanqueTransaction]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $transaction = BanqueTransaction::withTrashed()->findOrFail($id);
        $transaction->restore();

        return response()->json([
            'data' => $transaction,
            'message' => 'Transaction restaurée avec succès'
        ]);
    }

    /**
     * Lister les transactions supprimées
     *
     * Récupère la liste de toutes les transactions supprimées logiquement.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @response 200 scenario="Succès" {
     *   "data": [],
     *   "message": "Liste des transactions supprimées"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function trashed(): JsonResponse
    {
        $transactions = BanqueTransaction::onlyTrashed()->with('account')->get();

        return response()->json([
            'data' => $transactions,
            'message' => 'Liste des transactions supprimées'
        ]);
    }

    /**
     * Valider une transaction
     *
     * Change le statut d'une transaction en "valide" et met à jour le solde du compte.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID de la transaction. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Validation réussie" {
     *   "data": {
     *     "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "transaction_number": "TRX-2025-001",
     *     "status": "valide",
     *     "account": {
     *       "balance": 20500000.00
     *     }
     *   },
     *   "message": "Transaction validée avec succès"
     * }
     * 
     * @response 422 scenario="Transaction déjà validée" {
     *   "message": "Cette transaction est déjà validée"
     * }
     * 
     * @response 404 scenario="Transaction non trouvée" {
     *   "message": "No query results for model [App\\Models\\BanqueTransaction]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function validate(string $id): JsonResponse
    {
        $transaction = BanqueTransaction::findOrFail($id);

        if ($transaction->status === 'valide') {
            return response()->json([
                'message' => 'Cette transaction est déjà validée'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $transaction->status = 'valide';
            $transaction->save();

            $account = BanqueAccount::findOrFail($transaction->banque_account_id);

            if (in_array($transaction->transaction_type, ['credit', 'depot'])) {
                $account->credit($transaction->montant);
            } elseif (in_array($transaction->transaction_type, ['debit', 'retrait', 'cheque'])) {
                $account->debit($transaction->montant);
            }

            $transaction->load('account');
            DB::commit();

            return response()->json([
                'data' => $transaction,
                'message' => 'Transaction validée avec succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la validation de la transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Annuler une transaction
     *
     * Change le statut d'une transaction en "annule" et ajuste le solde du compte si nécessaire.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID de la transaction. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Annulation réussie" {
     *   "data": {
     *     "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "transaction_number": "TRX-2025-001",
     *     "status": "annule"
     *   },
     *   "message": "Transaction annulée avec succès"
     * }
     * 
     * @response 422 scenario="Transaction déjà annulée" {
     *   "message": "Cette transaction est déjà annulée"
     * }
     * 
     * @response 404 scenario="Transaction non trouvée" {
     *   "message": "No query results for model [App\\Models\\BanqueTransaction]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function cancel(string $id): JsonResponse
    {
        $transaction = BanqueTransaction::findOrFail($id);

        if ($transaction->status === 'annule') {
            return response()->json([
                'message' => 'Cette transaction est déjà annulée'
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Si la transaction était validée, on inverse l'opération sur le compte
            if ($transaction->status === 'valide') {
                $account = BanqueAccount::findOrFail($transaction->banque_account_id);

                if (in_array($transaction->transaction_type, ['credit', 'depot'])) {
                    $account->debit($transaction->montant);
                } elseif (in_array($transaction->transaction_type, ['debit', 'retrait', 'cheque'])) {
                    $account->credit($transaction->montant);
                }
            }

            $transaction->status = 'annule';
            $transaction->save();
            $transaction->load('account');

            DB::commit();

            return response()->json([
                'data' => $transaction,
                'message' => 'Transaction annulée avec succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de l\'annulation de la transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lister les transactions par compte
     *
     * Récupère toutes les transactions d'un compte spécifique.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam accountId string required UUID du compte. Example: 8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "transaction_number": "TRX-2025-001",
     *       "transaction_date": "2025-01-15",
     *       "transaction_type": "credit",
     *       "montant": 5000000.00,
     *       "status": "valide"
     *     }
     *   ],
     *   "message": "Transactions du compte"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function byAccount(string $accountId): JsonResponse
    {
        $transactions = BanqueTransaction::where('banque_account_id', $accountId)
            ->with('account')
            ->orderBy('transaction_date', 'desc')
            ->get();

        return response()->json([
            'data' => $transactions,
            'message' => 'Transactions du compte'
        ]);
    }

    /**
     * Lister les transactions par type
     *
     * Récupère toutes les transactions d'un type spécifique.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam type string required Type de transaction (debit, credit, virement, cheque, retrait, depot). Example: credit
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "transaction_number": "TRX-2025-001",
     *       "transaction_type": "credit",
     *       "montant": 5000000.00
     *     }
     *   ],
     *   "message": "Transactions de type: credit"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function byType(string $type): JsonResponse
    {
        $transactions = BanqueTransaction::byType($type)
            ->with('account')
            ->get();

        return response()->json([
            'data' => $transactions,
            'message' => "Transactions de type: {$type}"
        ]);
    }

    /**
     * Lister les transactions par statut
     *
     * Récupère toutes les transactions ayant un statut spécifique.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam status string required Statut (en_attente, valide, rejete, annule). Example: valide
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "transaction_number": "TRX-2025-001",
     *       "status": "valide",
     *       "montant": 5000000.00
     *     }
     *   ],
     *   "message": "Transactions avec le statut: valide"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function byStatus(string $status): JsonResponse
    {
        $transactions = BanqueTransaction::byStatus($status)
            ->with('account')
            ->get();

        return response()->json([
            'data' => $transactions,
            'message' => "Transactions avec le statut: {$status}"
        ]);
    }

    /**
     * Lister les transactions par période
     *
     * Récupère toutes les transactions entre deux dates.
     *
     * @group Gestion des Transactions Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @bodyParam start_date date required Date de début (YYYY-MM-DD). Example: "2025-01-01"
     * @bodyParam end_date date required Date de fin (YYYY-MM-DD). Example: "2025-01-31"
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "banque_transaction_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "transaction_number": "TRX-2025-001",
     *       "transaction_date": "2025-01-15",
     *       "montant": 5000000.00
     *     }
     *   ],
     *   "message": "Transactions entre 2025-01-01 et 2025-01-31"
     * }
     * 
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "start_date": ["La date de début est obligatoire"],
     *     "end_date": ["La date de fin est obligatoire"]
     *   }
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function byPeriod(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ], [
            'start_date.required' => 'La date de début est obligatoire',
            'end_date.required' => 'La date de fin est obligatoire',
            'end_date.after_or_equal' => 'La date de fin doit être après ou égale à la date de début'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transactions = BanqueTransaction::betweenDates(
            $request->start_date,
            $request->end_date
        )->with('account')->get();

        return response()->json([
            'data' => $transactions,
            'message' => "Transactions entre {$request->start_date} et {$request->end_date}"
        ]);
    }
}
