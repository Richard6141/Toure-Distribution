<?php

namespace App\Http\Controllers\Api;

use App\Models\BanqueAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * @group Gestion des Comptes Bancaires
 * 
 * APIs pour gérer les comptes bancaires du système.
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
class BanqueAccountController extends Controller
{
    /**
     * Lister tous les comptes bancaires
     *
     * Récupère la liste complète de tous les comptes avec leurs banques associées.
     *
     * @group Gestion des Comptes Bancaires
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
     *       "banque_account_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "banque_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "account_number": "BJ066001010100100100100100",
     *       "account_name": "Compte Principal",
     *       "account_type": "courant",
     *       "titulaire": "Entreprise ABC SARL",
     *       "balance": 15500000.00,
     *       "statut": "actif",
     *       "date_ouverture": "2024-01-15",
     *       "isActive": true,
     *       "created_at": "2025-01-15T10:30:00.000000Z",
     *       "updated_at": "2025-01-15T10:30:00.000000Z",
     *       "deleted_at": null,
     *       "banque": {
     *         "banque_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *         "name": "Ecobank Bénin",
     *         "code": "BNQ-ECO001"
     *       }
     *     }
     *   ],
     *   "message": "Liste des comptes bancaires"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function index(): JsonResponse
    {
        $accounts = BanqueAccount::with('banque')->get();

        return response()->json([
            'data' => $accounts,
            'message' => 'Liste des comptes bancaires'
        ]);
    }

    /**
     * Créer un nouveau compte bancaire
     *
     * Crée un nouveau compte bancaire dans le système.
     *
     * @group Gestion des Comptes Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @bodyParam banque_id string required UUID de la banque. Example: "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b"
     * @bodyParam account_number string required Numéro de compte (unique). Example: "BJ066001010100100100100100"
     * @bodyParam account_name string required Nom du compte. Example: "Compte Principal"
     * @bodyParam account_type string optional Type de compte (courant, epargne, depot). Example: "courant"
     * @bodyParam titulaire string required Nom du titulaire du compte. Example: "Entreprise ABC SARL"
     * @bodyParam balance numeric optional Solde initial (par défaut: 0). Example: 15500000.00
     * @bodyParam statut string optional Statut (actif, inactif, suspendu, cloture). Example: "actif"
     * @bodyParam date_ouverture date required Date d'ouverture du compte (format: YYYY-MM-DD). Example: "2024-01-15"
     * @bodyParam isActive boolean optional Indique si le compte est actif (par défaut: true). Example: true
     *
     * @response 201 scenario="Compte créé avec succès" {
     *   "data": {
     *     "banque_account_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "banque_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "account_number": "BJ066001010100100100100100",
     *     "account_name": "Compte Principal",
     *     "account_type": "courant",
     *     "titulaire": "Entreprise ABC SARL",
     *     "balance": 15500000.00,
     *     "statut": "actif",
     *     "date_ouverture": "2024-01-15",
     *     "isActive": true,
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null,
     *     "banque": {
     *       "banque_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "name": "Ecobank Bénin",
     *       "code": "BNQ-ECO001"
     *     }
     *   },
     *   "message": "Compte bancaire créé avec succès"
     * }
     *
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "account_number": ["Ce numéro de compte existe déjà"],
     *     "banque_id": ["La banque sélectionnée n'existe pas"]
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
            'banque_id' => 'required|uuid|exists:banques,banque_id',
            'account_number' => 'required|string|max:255|unique:banque_accounts,account_number',
            'account_name' => 'required|string|max:255',
            'account_type' => 'nullable|in:courant,epargne,depot',
            'titulaire' => 'required|string|max:255',
            'balance' => 'nullable|numeric|min:0',
            'statut' => 'nullable|in:actif,inactif,suspendu,cloture',
            'date_ouverture' => 'required|date',
            'isActive' => 'boolean',
        ];

        $messages = [
            'banque_id.required' => 'La banque est obligatoire',
            'banque_id.exists' => 'La banque sélectionnée n\'existe pas',
            'account_number.required' => 'Le numéro de compte est obligatoire',
            'account_number.unique' => 'Ce numéro de compte existe déjà',
            'account_name.required' => 'Le nom du compte est obligatoire',
            'titulaire.required' => 'Le titulaire du compte est obligatoire',
            'date_ouverture.required' => 'La date d\'ouverture est obligatoire',
            'date_ouverture.date' => 'La date d\'ouverture doit être une date valide',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account = BanqueAccount::create($validator->validated());
        $account->load('banque');

        return response()->json([
            'data' => $account,
            'message' => 'Compte bancaire créé avec succès'
        ], 201);
    }

    /**
     * Afficher un compte bancaire spécifique
     *
     * Récupère les détails complets d'un compte avec ses transactions.
     *
     * @group Gestion des Comptes Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du compte bancaire. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     *
     * @response 200 scenario="Compte trouvé" {
     *   "data": {
     *     "banque_account_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "banque_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "account_number": "BJ066001010100100100100100",
     *     "account_name": "Compte Principal",
     *     "account_type": "courant",
     *     "titulaire": "Entreprise ABC SARL",
     *     "balance": 15500000.00,
     *     "statut": "actif",
     *     "date_ouverture": "2024-01-15",
     *     "isActive": true,
     *     "banque": {
     *       "banque_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *       "name": "Ecobank Bénin"
     *     },
     *     "transactions": []
     *   },
     *   "message": "Détails du compte bancaire"
     * }
     * 
     * @response 404 scenario="Compte non trouvé" {
     *   "message": "No query results for model [App\\Models\\BanqueAccount]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function show(string $id): JsonResponse
    {
        $account = BanqueAccount::with(['banque', 'transactions'])->findOrFail($id);

        return response()->json([
            'data' => $account,
            'message' => 'Détails du compte bancaire'
        ]);
    }

    /**
     * Mettre à jour un compte bancaire
     *
     * Met à jour les informations d'un compte bancaire existant.
     *
     * @group Gestion des Comptes Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du compte bancaire à mettre à jour. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     *
     * @bodyParam banque_id string required UUID de la banque. Example: "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b"
     * @bodyParam account_number string required Numéro de compte (unique). Example: "BJ066001010100100100100100"
     * @bodyParam account_name string required Nom du compte. Example: "Compte Principal Modifié"
     * @bodyParam account_type string optional Type de compte. Example: "courant"
     * @bodyParam titulaire string required Titulaire du compte. Example: "Entreprise ABC SARL"
     * @bodyParam balance numeric optional Solde du compte. Example: 16000000.00
     * @bodyParam statut string optional Statut du compte. Example: "actif"
     * @bodyParam date_ouverture date required Date d'ouverture. Example: "2024-01-15"
     * @bodyParam isActive boolean optional Statut actif. Example: true
     *
     * @response 200 scenario="Mise à jour réussie" {
     *   "data": {
     *     "banque_account_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "banque_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *     "account_number": "BJ066001010100100100100100",
     *     "account_name": "Compte Principal Modifié",
     *     "account_type": "courant",
     *     "titulaire": "Entreprise ABC SARL",
     *     "balance": 16000000.00,
     *     "statut": "actif",
     *     "date_ouverture": "2024-01-15",
     *     "isActive": true,
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-16T15:45:00.000000Z",
     *     "deleted_at": null
     *   },
     *   "message": "Compte bancaire mis à jour avec succès"
     * }
     * 
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "account_number": ["Ce numéro de compte existe déjà"]
     *   }
     * }
     * 
     * @response 404 scenario="Compte non trouvé" {
     *   "message": "No query results for model [App\\Models\\BanqueAccount]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $account = BanqueAccount::findOrFail($id);

        $rules = [
            'banque_id' => 'required|uuid|exists:banques,banque_id',
            'account_number' => 'required|string|max:255|unique:banque_accounts,account_number,' . $account->banque_account_id . ',banque_account_id',
            'account_name' => 'required|string|max:255',
            'account_type' => 'nullable|in:courant,epargne,depot',
            'titulaire' => 'required|string|max:255',
            'balance' => 'nullable|numeric|min:0',
            'statut' => 'nullable|in:actif,inactif,suspendu,cloture',
            'date_ouverture' => 'required|date',
            'isActive' => 'boolean',
        ];

        $messages = [
            'banque_id.required' => 'La banque est obligatoire',
            'banque_id.exists' => 'La banque sélectionnée n\'existe pas',
            'account_number.required' => 'Le numéro de compte est obligatoire',
            'account_number.unique' => 'Ce numéro de compte existe déjà',
            'account_name.required' => 'Le nom du compte est obligatoire',
            'titulaire.required' => 'Le titulaire du compte est obligatoire',
            'date_ouverture.required' => 'La date d\'ouverture est obligatoire',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account->update($validator->validated());
        $account->load('banque');

        return response()->json([
            'data' => $account,
            'message' => 'Compte bancaire mis à jour avec succès'
        ]);
    }

    /**
     * Supprimer un compte bancaire (soft delete)
     *
     * Effectue une suppression logique du compte bancaire.
     *
     * @group Gestion des Comptes Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du compte à supprimer. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Suppression réussie" {
     *   "message": "Compte bancaire supprimé avec succès"
     * }
     * 
     * @response 404 scenario="Compte non trouvé" {
     *   "message": "No query results for model [App\\Models\\BanqueAccount]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $account = BanqueAccount::findOrFail($id);
        $account->delete();

        return response()->json([
            'message' => 'Compte bancaire supprimé avec succès'
        ]);
    }

    /**
     * Restaurer un compte bancaire supprimé
     *
     * Restaure un compte bancaire supprimé logiquement.
     *
     * @group Gestion des Comptes Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du compte à restaurer. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     * 
     * @response 200 scenario="Restauration réussie" {
     *   "data": {
     *     "banque_account_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "account_number": "BJ066001010100100100100100",
     *     "account_name": "Compte Principal",
     *     "balance": 15500000.00,
     *     "deleted_at": null
     *   },
     *   "message": "Compte bancaire restauré avec succès"
     * }
     * 
     * @response 404 scenario="Compte non trouvé" {
     *   "message": "No query results for model [App\\Models\\BanqueAccount]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $account = BanqueAccount::withTrashed()->findOrFail($id);
        $account->restore();

        return response()->json([
            'data' => $account,
            'message' => 'Compte bancaire restauré avec succès'
        ]);
    }

    /**
     * Lister les comptes supprimés
     *
     * Récupère la liste de tous les comptes supprimés logiquement.
     *
     * @group Gestion des Comptes Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     *
     * @response 200 scenario="Succès" {
     *   "data": [],
     *   "message": "Liste des comptes supprimés"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function trashed(): JsonResponse
    {
        $accounts = BanqueAccount::onlyTrashed()->with('banque')->get();

        return response()->json([
            'data' => $accounts,
            'message' => 'Liste des comptes supprimés'
        ]);
    }

    /**
     * Débiter un compte
     *
     * Effectue un débit sur le compte bancaire.
     *
     * @group Gestion des Comptes Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du compte. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     *
     * @bodyParam montant numeric required Montant à débiter. Example: 500000.00
     *
     * @response 200 scenario="Débit réussi" {
     *   "data": {
     *     "banque_account_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "account_number": "BJ066001010100100100100100",
     *     "balance": 15000000.00,
     *     "previous_balance": 15500000.00,
     *     "montant_debite": 500000.00
     *   },
     *   "message": "Compte débité avec succès"
     * }
     * 
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "montant": ["Le montant est obligatoire"]
     *   }
     * }
     * 
     * @response 404 scenario="Compte non trouvé" {
     *   "message": "No query results for model [App\\Models\\BanqueAccount]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function debit(Request $request, string $id): JsonResponse
    {
        $account = BanqueAccount::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'montant' => 'required|numeric|min:0'
        ], [
            'montant.required' => 'Le montant est obligatoire',
            'montant.numeric' => 'Le montant doit être un nombre',
            'montant.min' => 'Le montant doit être positif'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $previousBalance = $account->balance;
        $account->debit($request->montant);

        return response()->json([
            'data' => [
                'banque_account_id' => $account->banque_account_id,
                'account_number' => $account->account_number,
                'balance' => $account->balance,
                'previous_balance' => $previousBalance,
                'montant_debite' => $request->montant
            ],
            'message' => 'Compte débité avec succès'
        ]);
    }

    /**
     * Créditer un compte
     *
     * Effectue un crédit sur le compte bancaire.
     *
     * @group Gestion des Comptes Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du compte. Example: 9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a
     *
     * @bodyParam montant numeric required Montant à créditer. Example: 750000.00
     *
     * @response 200 scenario="Crédit réussi" {
     *   "data": {
     *     "banque_account_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *     "account_number": "BJ066001010100100100100100",
     *     "balance": 16250000.00,
     *     "previous_balance": 15500000.00,
     *     "montant_credite": 750000.00
     *   },
     *   "message": "Compte crédité avec succès"
     * }
     * 
     * @response 422 scenario="Erreurs de validation" {
     *   "errors": {
     *     "montant": ["Le montant est obligatoire"]
     *   }
     * }
     * 
     * @response 404 scenario="Compte non trouvé" {
     *   "message": "No query results for model [App\\Models\\BanqueAccount]"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function credit(Request $request, string $id): JsonResponse
    {
        $account = BanqueAccount::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'montant' => 'required|numeric|min:0'
        ], [
            'montant.required' => 'Le montant est obligatoire',
            'montant.numeric' => 'Le montant doit être un nombre',
            'montant.min' => 'Le montant doit être positif'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $previousBalance = $account->balance;
        $account->credit($request->montant);

        return response()->json([
            'data' => [
                'banque_account_id' => $account->banque_account_id,
                'account_number' => $account->account_number,
                'balance' => $account->balance,
                'previous_balance' => $previousBalance,
                'montant_credite' => $request->montant
            ],
            'message' => 'Compte crédité avec succès'
        ]);
    }

    /**
     * Lister les comptes par banque
     *
     * Récupère tous les comptes d'une banque spécifique.
     *
     * @group Gestion des Comptes Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam banqueId string required UUID de la banque. Example: 8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "banque_account_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "account_number": "BJ066001010100100100100100",
     *       "account_name": "Compte Principal",
     *       "balance": 15500000.00,
     *       "statut": "actif"
     *     }
     *   ],
     *   "message": "Comptes de la banque"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function byBanque(string $banqueId): JsonResponse
    {
        $accounts = BanqueAccount::where('banque_id', $banqueId)
            ->with('banque')
            ->get();

        return response()->json([
            'data' => $accounts,
            'message' => 'Comptes de la banque'
        ]);
    }

    /**
     * Lister les comptes par statut
     *
     * Récupère tous les comptes ayant un statut spécifique.
     *
     * @group Gestion des Comptes Bancaires
     * 
     * @authenticated
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam statut string required Statut du compte (actif, inactif, suspendu, cloture). Example: actif
     *
     * @response 200 scenario="Succès" {
     *   "data": [
     *     {
     *       "banque_account_id": "9d4f2e8a-1b3c-4d5e-6f7a-8b9c0d1e2f3a",
     *       "account_number": "BJ066001010100100100100100",
     *       "account_name": "Compte Principal",
     *       "statut": "actif"
     *     }
     *   ],
     *   "message": "Comptes avec le statut: actif"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function byStatut(string $statut): JsonResponse
    {
        $accounts = BanqueAccount::byStatut($statut)
            ->with('banque')
            ->get();

        return response()->json([
            'data' => $accounts,
            'message' => "Comptes avec le statut: {$statut}"
        ]);
    }
}
