<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * @group Clients Management
 *
 * APIs pour gérer les clients
 */
class ClientController extends Controller
{
    /**
     * Liste tous les clients
     *
     * Récupère la liste de tous les clients avec pagination et filtres optionnels.
     * Vous pouvez filtrer par nom, email, code, ville, IFU, marketteur, statut et type de client.
     *
     * @queryParam page integer Page à récupérer (pagination). Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max: 100). Example: 15
     * @queryParam search string Recherche globale (nom, email, code, IFU, représentant, marketteur). Example: John
     * @queryParam name string Rechercher par nom de client. Example: John Doe
     * @queryParam email string Rechercher par email. Example: john@example.com
     * @queryParam code string Rechercher par code client. Example: CLI-ABC123
     * @queryParam city string Rechercher par ville. Example: Cotonou
     * @queryParam ifu string Rechercher par numéro IFU. Example: 1234567890123
     * @queryParam marketteur string Rechercher par marketteur. Example: Marie Dupont
     * @queryParam client_type_id string Filtrer par type de client (UUID). Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam is_active boolean Filtrer par statut actif. Example: true
     * @queryParam with_client_type boolean Inclure les informations du type de client. Example: true
     * @queryParam balance_filter string Filtrer par solde (positive, negative, zero). Example: positive
     *
     * @response 200 scenario="Succès" {
     *   "success": true,
     *   "data": [
     *     {
     *       "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "code": "CLI-ABC123",
     *       "name_client": "John Doe",
     *       "name_representant": "Jane Smith",
     *       "marketteur": "Marie Dupont",
     *       "client_type_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "adresse": "123 Rue de la Paix",
     *       "city": "Cotonou",
     *       "email": "john.doe@example.com",
     *       "ifu": "1234567890123",
     *       "phonenumber": "+229 12 34 56 78",
     *       "credit_limit": "500000.00",
     *       "current_balance": "150000.00",
     *       "base_reduction": "5.00",
     *       "is_active": true,
     *       "created_at": "2024-01-15T10:30:00Z",
     *       "updated_at": "2024-01-15T10:30:00Z"
     *     }
     *   ]
     * }
     * 
     * @response 422 scenario="Erreur de validation" {
     *   "success": false,
     *   "error": {
     *     "code": "VALIDATION_ERROR",
     *     "message": "Les données fournies sont invalides",
     *     "details": {
     *       "per_page": ["Le champ per_page ne peut pas dépasser 100."]
     *     }
     *   }
     * }
     * 
     * @response 500 scenario="Erreur serveur" {
     *   "success": false,
     *   "error": {
     *     "code": "DATABASE_ERROR",
     *     "message": "Une erreur est survenue lors de la récupération des clients",
     *     "details": "Erreur de connexion à la base de données"
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Validation des paramètres
            $validated = $request->validate([
                'page' => 'integer|min:1',
                'per_page' => 'integer|min:1|max:100',
                'search' => 'string|max:255',
                'name' => 'string|max:255',
                'email' => 'string|max:255',
                'code' => 'string|max:255',
                'city' => 'string|max:255',
                'ifu' => 'string|max:255',
                'marketteur' => 'string|max:255',
                'client_type_id' => 'uuid|exists:client_types,client_type_id',
                'is_active' => 'boolean',
                'with_client_type' => 'boolean',
                'balance_filter' => 'in:positive,negative,zero'
            ]);

            $query = Client::query();

            // Recherche globale (correction du bug orWhere->byEmail)
            if (isset($validated['search'])) {
                $search = $validated['search'];
                $query->where(function ($q) use ($search) {
                    $q->where('name_client', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('ifu', 'like', "%{$search}%")
                        ->orWhere('name_representant', 'like', "%{$search}%")
                        ->orWhere('marketteur', 'like', "%{$search}%");
                });
            }

            // Filtres spécifiques
            if (isset($validated['name'])) {
                $query->where('name_client', 'like', "%{$validated['name']}%");
            }

            if (isset($validated['email'])) {
                $query->where('email', 'like', "%{$validated['email']}%");
            }

            if (isset($validated['code'])) {
                $query->where('code', 'like', "%{$validated['code']}%");
            }

            if (isset($validated['city'])) {
                $query->where('city', 'like', "%{$validated['city']}%");
            }

            if (isset($validated['ifu'])) {
                $query->where('ifu', 'like', "%{$validated['ifu']}%");
            }

            if (isset($validated['marketteur'])) {
                $query->where('marketteur', 'like', "%{$validated['marketteur']}%");
            }

            if (isset($validated['client_type_id'])) {
                $query->where('client_type_id', $validated['client_type_id']);
            }

            if (isset($validated['is_active'])) {
                $query->where('is_active', $validated['is_active']);
            }

            // Filtre par solde
            if (isset($validated['balance_filter'])) {
                switch ($validated['balance_filter']) {
                    case 'positive':
                        $query->where('current_balance', '>', 0);
                        break;
                    case 'negative':
                        $query->where('current_balance', '<', 0);
                        break;
                    case 'zero':
                        $query->where('current_balance', 0);
                        break;
                }
            }

            // Inclure le type de client si demandé
            if (isset($validated['with_client_type']) && $validated['with_client_type']) {
                $query->with('clientType');
            }

            $perPage = $validated['per_page'] ?? 15;
            $clients = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $clients->items(),
                'meta' => [
                    'current_page' => $clients->currentPage(),
                    'last_page' => $clients->lastPage(),
                    'per_page' => $clients->perPage(),
                    'total' => $clients->total(),
                    'from' => $clients->firstItem(),
                    'to' => $clients->lastItem()
                ]
            ], 200);
        } catch (ValidationException $e) {
            Log::warning('Erreur de validation dans index clients', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => 'Les données fournies sont invalides',
                    'details' => $e->errors()
                ]
            ], 422);
        } catch (QueryException $e) {
            Log::error('Erreur de base de données dans index clients', [
                'message' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'DATABASE_ERROR',
                    'message' => 'Une erreur est survenue lors de la récupération des clients',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur de base de données'
                ]
            ], 500);
        } catch (Exception $e) {
            Log::error('Erreur inattendue dans index clients', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'INTERNAL_ERROR',
                    'message' => 'Une erreur inattendue est survenue',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur interne du serveur'
                ]
            ], 500);
        }
    }

    /**
     * Créer un nouveau client
     *
     * Crée un nouveau client avec les informations fournies.
     * L'UUID et le code client sont générés automatiquement si non fournis.
     *
     * @bodyParam name_client string required Nom complet du client. Example: John Doe
     * @bodyParam name_representant string optionnel Nom du représentant du client. Example: Jane Smith
     * @bodyParam marketteur string optionnel Nom du marketteur associé au client. Example: Marie Dupont
     * @bodyParam client_type_id string optionnel UUID du type de client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam adresse string optionnel Adresse du client. Example: 123 Rue de la Paix
     * @bodyParam city string optionnel Ville du client. Example: Cotonou
     * @bodyParam email string optionnel Email unique du client. Example: john.doe@example.com
     * @bodyParam ifu string optionnel Numéro IFU (Identifiant Fiscal Unique). Example: 1234567890123
     * @bodyParam phonenumber string optionnel Numéro de téléphone. Example: +229 12 34 56 78
     * @bodyParam credit_limit number optionnel Limite de crédit (défaut: 0). Example: 500000
     * @bodyParam current_balance number optionnel Solde actuel (défaut: 0). Example: 0
     * @bodyParam base_reduction number optionnel Réduction de base en pourcentage (0-100, défaut: 0). Example: 5
     * @bodyParam is_active boolean optionnel Statut actif (défaut: true). Example: true
     *
     * @response 201 scenario="Succès" {
     *   "success": true,
     *   "message": "Client créé avec succès",
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "code": "CLI00001",
     *     "name_client": "John Doe",
     *     "email": "john.doe@example.com"
     *   }
     * }
     * 
     * @response 422 scenario="Email déjà utilisé" {
     *   "success": false,
     *   "error": {
     *     "code": "DUPLICATE_EMAIL",
     *     "message": "Cet email est déjà utilisé par un autre client",
     *     "field": "email"
     *   }
     * }
     * 
     * @response 500 scenario="Erreur lors de la création" {
     *   "success": false,
     *   "error": {
     *     "code": "CREATE_ERROR",
     *     "message": "Impossible de créer le client",
     *     "details": "Erreur lors de l'enregistrement"
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Validation des données
            $validated = $request->validate([
                'name_client' => 'required|string|max:255',
                'name_representant' => 'nullable|string|max:255',
                'marketteur' => 'nullable|string|max:255',
                'client_type_id' => 'nullable|uuid|exists:client_types,client_type_id',
                'adresse' => 'nullable|string|max:500',
                'city' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:clients,email|max:255',
                'ifu' => 'nullable|string|max:13|unique:clients,ifu',
                'phonenumber' => 'nullable|string|max:20',
                'credit_limit' => 'nullable|numeric|min:0',
                'current_balance' => 'nullable|numeric',
                'base_reduction' => 'nullable|numeric|min:0|max:100',
                'is_active' => 'boolean'
            ], [
                'name_client.required' => 'Le nom du client est obligatoire',
                'name_client.max' => 'Le nom du client ne peut pas dépasser 255 caractères',
                'email.email' => 'L\'adresse email doit être valide',
                'email.unique' => 'Cet email est déjà utilisé par un autre client',
                'ifu.unique' => 'Ce numéro IFU est déjà utilisé par un autre client',
                'ifu.max' => 'Le numéro IFU ne peut pas dépasser 13 caractères',
                'client_type_id.exists' => 'Le type de client spécifié n\'existe pas',
                'credit_limit.min' => 'La limite de crédit ne peut pas être négative',
                'base_reduction.min' => 'La réduction de base doit être comprise entre 0 et 100',
                'base_reduction.max' => 'La réduction de base doit être comprise entre 0 et 100'
            ]);

            // Vérification supplémentaire du type de client si fourni
            if (isset($validated['client_type_id'])) {
                $clientType = ClientType::find($validated['client_type_id']);
                if (!$clientType) {
                    throw new Exception('Le type de client spécifié n\'existe pas');
                }
            }

            // Création du client
            $client = Client::create($validated);

            DB::commit();

            Log::info('Client créé avec succès', [
                'client_id' => $client->client_id,
                'name' => $client->name_client,
                'created_by' => auth()->user()->id ?? 'system'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Client créé avec succès',
                'data' => $client
            ], 201);
        } catch (ValidationException $e) {
            DB::rollBack();

            Log::warning('Erreur de validation lors de la création d\'un client', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => 'Les données fournies sont invalides',
                    'details' => $e->errors()
                ]
            ], 422);
        } catch (QueryException $e) {
            DB::rollBack();

            // Gestion des erreurs de contrainte unique
            if ($e->getCode() === '23000') {
                Log::warning('Tentative de création d\'un client avec des données en double', [
                    'message' => $e->getMessage(),
                    'request' => $request->all()
                ]);

                $errorMessage = 'Un client avec ces informations existe déjà';
                $field = null;

                if (str_contains($e->getMessage(), 'email')) {
                    $errorMessage = 'Cet email est déjà utilisé par un autre client';
                    $field = 'email';
                } elseif (str_contains($e->getMessage(), 'ifu')) {
                    $errorMessage = 'Ce numéro IFU est déjà utilisé par un autre client';
                    $field = 'ifu';
                }

                return response()->json([
                    'success' => false,
                    'error' => [
                        'code' => 'DUPLICATE_ENTRY',
                        'message' => $errorMessage,
                        'field' => $field
                    ]
                ], 422);
            }

            Log::error('Erreur de base de données lors de la création d\'un client', [
                'message' => $e->getMessage(),
                'sql' => $e->getSql()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'DATABASE_ERROR',
                    'message' => 'Impossible de créer le client',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur de base de données'
                ]
            ], 500);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erreur inattendue lors de la création d\'un client', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'CREATE_ERROR',
                    'message' => 'Une erreur est survenue lors de la création du client',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur interne du serveur'
                ]
            ], 500);
        }
    }

    /**
     * Afficher un client spécifique
     *
     * @urlParam id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 scenario="Succès" {
     *   "success": true,
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "code": "CLI-ABC123",
     *     "name_client": "John Doe",
     *     "email": "john.doe@example.com"
     *   }
     * }
     * 
     * @response 404 scenario="Client non trouvé" {
     *   "success": false,
     *   "error": {
     *     "code": "NOT_FOUND",
     *     "message": "Client non trouvé",
     *     "details": "Aucun client ne correspond à l'ID fourni"
     *   }
     * }
     */
    public function show(string $id): JsonResponse
    {
        try {
            $client = Client::with('clientType')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $client
            ], 200);
        } catch (ModelNotFoundException $e) {
            Log::warning('Tentative d\'accès à un client inexistant', [
                'client_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'Client non trouvé',
                    'details' => 'Aucun client ne correspond à l\'ID fourni'
                ]
            ], 404);
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération d\'un client', [
                'client_id' => $id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'RETRIEVAL_ERROR',
                    'message' => 'Impossible de récupérer les informations du client',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur interne du serveur'
                ]
            ], 500);
        }
    }

    /**
     * Mettre à jour un client
     *
     * @urlParam id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 scenario="Succès" {
     *   "success": true,
     *   "message": "Client mis à jour avec succès",
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "name_client": "John Doe Updated"
     *   }
     * }
     * 
     * @response 404 scenario="Client non trouvé" {
     *   "success": false,
     *   "error": {
     *     "code": "NOT_FOUND",
     *     "message": "Client non trouvé"
     *   }
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Recherche du client
            $client = Client::findOrFail($id);

            // Validation des données
            $validated = $request->validate([
                'name_client' => 'sometimes|required|string|max:255',
                'name_representant' => 'nullable|string|max:255',
                'marketteur' => 'nullable|string|max:255',
                'client_type_id' => 'nullable|uuid|exists:client_types,client_type_id',
                'adresse' => 'nullable|string|max:500',
                'city' => 'nullable|string|max:255',
                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                    Rule::unique('clients')->ignore($id, 'client_id')
                ],
                'ifu' => [
                    'nullable',
                    'string',
                    'max:13',
                    Rule::unique('clients')->ignore($id, 'client_id')
                ],
                'phonenumber' => 'nullable|string|max:20',
                'credit_limit' => 'nullable|numeric|min:0',
                'current_balance' => 'nullable|numeric',
                'base_reduction' => 'nullable|numeric|min:0|max:100',
                'is_active' => 'boolean'
            ], [
                'name_client.required' => 'Le nom du client est obligatoire',
                'email.unique' => 'Cet email est déjà utilisé par un autre client',
                'ifu.unique' => 'Ce numéro IFU est déjà utilisé par un autre client',
                'client_type_id.exists' => 'Le type de client spécifié n\'existe pas',
                'credit_limit.min' => 'La limite de crédit ne peut pas être négative',
                'base_reduction.min' => 'La réduction de base doit être comprise entre 0 et 100',
                'base_reduction.max' => 'La réduction de base doit être comprise entre 0 et 100'
            ]);

            // Mise à jour du client
            $client->update($validated);

            DB::commit();

            Log::info('Client mis à jour avec succès', [
                'client_id' => $client->client_id,
                'updated_fields' => array_keys($validated),
                'updated_by' => auth()->user()->id ?? 'system'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Client mis à jour avec succès',
                'data' => $client->fresh()
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            Log::warning('Tentative de mise à jour d\'un client inexistant', [
                'client_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'Client non trouvé',
                    'details' => 'Aucun client ne correspond à l\'ID fourni'
                ]
            ], 404);
        } catch (ValidationException $e) {
            DB::rollBack();

            Log::warning('Erreur de validation lors de la mise à jour d\'un client', [
                'client_id' => $id,
                'errors' => $e->errors()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => 'Les données fournies sont invalides',
                    'details' => $e->errors()
                ]
            ], 422);
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() === '23000') {
                Log::warning('Tentative de mise à jour avec des données en double', [
                    'client_id' => $id,
                    'message' => $e->getMessage()
                ]);

                $errorMessage = 'Ces informations sont déjà utilisées par un autre client';
                $field = null;

                if (str_contains($e->getMessage(), 'email')) {
                    $errorMessage = 'Cet email est déjà utilisé par un autre client';
                    $field = 'email';
                } elseif (str_contains($e->getMessage(), 'ifu')) {
                    $errorMessage = 'Ce numéro IFU est déjà utilisé par un autre client';
                    $field = 'ifu';
                }

                return response()->json([
                    'success' => false,
                    'error' => [
                        'code' => 'DUPLICATE_ENTRY',
                        'message' => $errorMessage,
                        'field' => $field
                    ]
                ], 422);
            }

            Log::error('Erreur de base de données lors de la mise à jour d\'un client', [
                'client_id' => $id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'DATABASE_ERROR',
                    'message' => 'Impossible de mettre à jour le client',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur de base de données'
                ]
            ], 500);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erreur inattendue lors de la mise à jour d\'un client', [
                'client_id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'UPDATE_ERROR',
                    'message' => 'Une erreur est survenue lors de la mise à jour du client',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur interne du serveur'
                ]
            ], 500);
        }
    }

    /**
     * Supprimer un client (soft delete)
     *
     * @urlParam id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 scenario="Succès" {
     *   "success": true,
     *   "message": "Client supprimé avec succès"
     * }
     * 
     * @response 404 scenario="Client non trouvé" {
     *   "success": false,
     *   "error": {
     *     "code": "NOT_FOUND",
     *     "message": "Client non trouvé"
     *   }
     * }
     * 
     * @response 409 scenario="Client avec transactions" {
     *   "success": false,
     *   "error": {
     *     "code": "CANNOT_DELETE",
     *     "message": "Impossible de supprimer ce client car il possède des transactions",
     *     "details": "Veuillez d'abord supprimer ou archiver les transactions associées"
     *   }
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $client = Client::findOrFail($id);

            // Vérifier si le client a des relations qui l'empêchent d'être supprimé
            // (transactions, commandes, etc.)
            // Cette vérification dépend de votre modèle de données
            if ($client->hasActiveTransactions()) {
                Log::warning('Tentative de suppression d\'un client avec des transactions actives', [
                    'client_id' => $id
                ]);

                return response()->json([
                    'success' => false,
                    'error' => [
                        'code' => 'CANNOT_DELETE',
                        'message' => 'Impossible de supprimer ce client car il possède des transactions actives',
                        'details' => 'Veuillez d\'abord clôturer ou supprimer les transactions associées'
                    ]
                ], 409);
            }

            // Soft delete
            $client->delete();

            DB::commit();

            Log::info('Client supprimé avec succès', [
                'client_id' => $id,
                'deleted_by' => auth()->user()->id ?? 'system'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Client supprimé avec succès'
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            Log::warning('Tentative de suppression d\'un client inexistant', [
                'client_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'Client non trouvé',
                    'details' => 'Aucun client ne correspond à l\'ID fourni'
                ]
            ], 404);
        } catch (QueryException $e) {
            DB::rollBack();

            // Erreur de contrainte de clé étrangère
            if ($e->getCode() === '23000') {
                Log::warning('Tentative de suppression d\'un client avec des dépendances', [
                    'client_id' => $id,
                    'message' => $e->getMessage()
                ]);

                return response()->json([
                    'success' => false,
                    'error' => [
                        'code' => 'CONSTRAINT_VIOLATION',
                        'message' => 'Impossible de supprimer ce client car il est référencé par d\'autres entités',
                        'details' => 'Ce client possède des enregistrements associés qui l\'empêchent d\'être supprimé'
                    ]
                ], 409);
            }

            Log::error('Erreur de base de données lors de la suppression d\'un client', [
                'client_id' => $id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'DATABASE_ERROR',
                    'message' => 'Impossible de supprimer le client',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur de base de données'
                ]
            ], 500);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erreur inattendue lors de la suppression d\'un client', [
                'client_id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'DELETE_ERROR',
                    'message' => 'Une erreur est survenue lors de la suppression du client',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur interne du serveur'
                ]
            ], 500);
        }
    }

    /**
     * Mettre à jour le solde d'un client
     *
     * @urlParam id string required UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam amount number required Montant à ajouter au solde (peut être négatif). Example: 50000
     * @bodyParam description string optionnel Description de l'opération. Example: Paiement facture INV-001
     *
     * @response 200 scenario="Succès" {
     *   "success": true,
     *   "message": "Solde mis à jour avec succès",
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "previous_balance": "150000.00",
     *     "new_balance": "200000.00",
     *     "amount_added": "50000.00",
     *     "available_credit": "300000.00"
     *   }
     * }
     * 
     * @response 404 scenario="Client non trouvé" {
     *   "success": false,
     *   "error": {
     *     "code": "NOT_FOUND",
     *     "message": "Client non trouvé"
     *   }
     * }
     * 
     * @response 422 scenario="Dépassement de limite de crédit" {
     *   "success": false,
     *   "error": {
     *     "code": "CREDIT_LIMIT_EXCEEDED",
     *     "message": "Cette opération dépasserait la limite de crédit autorisée",
     *     "details": {
     *       "current_balance": "150000.00",
     *       "credit_limit": "500000.00",
     *       "attempted_amount": "400000.00",
     *       "available_credit": "350000.00"
     *     }
     *   }
     * }
     */
    public function updateBalance(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Validation
            $validated = $request->validate([
                'amount' => 'required|numeric',
                'description' => 'nullable|string|max:500'
            ], [
                'amount.required' => 'Le montant est obligatoire',
                'amount.numeric' => 'Le montant doit être un nombre valide',
                'description.max' => 'La description ne peut pas dépasser 500 caractères'
            ]);

            // Recherche du client
            $client = Client::findOrFail($id);

            // Sauvegarder l'ancien solde
            $previousBalance = $client->current_balance;

            // Calculer le nouveau solde
            $newBalance = $previousBalance + $validated['amount'];

            // Vérifier si la limite de crédit serait dépassée
            if ($newBalance > $client->credit_limit && $validated['amount'] > 0) {
                Log::warning('Tentative de dépassement de la limite de crédit', [
                    'client_id' => $id,
                    'current_balance' => $previousBalance,
                    'credit_limit' => $client->credit_limit,
                    'attempted_amount' => $validated['amount'],
                    'would_be_balance' => $newBalance
                ]);

                return response()->json([
                    'success' => false,
                    'error' => [
                        'code' => 'CREDIT_LIMIT_EXCEEDED',
                        'message' => 'Cette opération dépasserait la limite de crédit autorisée',
                        'details' => [
                            'current_balance' => number_format($previousBalance, 2, '.', ''),
                            'credit_limit' => number_format($client->credit_limit, 2, '.', ''),
                            'attempted_amount' => number_format($validated['amount'], 2, '.', ''),
                            'available_credit' => number_format($client->credit_limit - $previousBalance, 2, '.', '')
                        ]
                    ]
                ], 422);
            }

            // Mise à jour du solde
            $client->current_balance = $newBalance;
            $client->save();

            DB::commit();

            Log::info('Solde client mis à jour avec succès', [
                'client_id' => $id,
                'previous_balance' => $previousBalance,
                'new_balance' => $newBalance,
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? null,
                'updated_by' => auth()->user()->id ?? 'system'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Solde mis à jour avec succès',
                'data' => [
                    'client_id' => $client->client_id,
                    'previous_balance' => number_format($previousBalance, 2, '.', ''),
                    'new_balance' => number_format($client->current_balance, 2, '.', ''),
                    'amount_added' => number_format($validated['amount'], 2, '.', ''),
                    'available_credit' => number_format($client->credit_limit - $client->current_balance, 2, '.', ''),
                    'description' => $validated['description'] ?? null
                ]
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            Log::warning('Tentative de mise à jour du solde d\'un client inexistant', [
                'client_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'Client non trouvé',
                    'details' => 'Aucun client ne correspond à l\'ID fourni'
                ]
            ], 404);
        } catch (ValidationException $e) {
            DB::rollBack();

            Log::warning('Erreur de validation lors de la mise à jour du solde', [
                'client_id' => $id,
                'errors' => $e->errors()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => 'Les données fournies sont invalides',
                    'details' => $e->errors()
                ]
            ], 422);
        } catch (QueryException $e) {
            DB::rollBack();

            Log::error('Erreur de base de données lors de la mise à jour du solde', [
                'client_id' => $id,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'DATABASE_ERROR',
                    'message' => 'Impossible de mettre à jour le solde',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur de base de données'
                ]
            ], 500);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erreur inattendue lors de la mise à jour du solde', [
                'client_id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'UPDATE_BALANCE_ERROR',
                    'message' => 'Une erreur est survenue lors de la mise à jour du solde',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur interne du serveur'
                ]
            ], 500);
        }
    }

    /**
     * Statistiques des clients
     *
     * Récupère des statistiques générales sur les clients.
     *
     * @response 200 scenario="Succès" {
     *   "success": true,
     *   "data": {
     *     "total_clients": 150,
     *     "active_clients": 120,
     *     "inactive_clients": 30
     *   }
     * }
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total_clients' => Client::count(),
                'active_clients' => Client::where('is_active', true)->count(),
                'inactive_clients' => Client::where('is_active', false)->count(),
                'deleted_clients' => Client::onlyTrashed()->count(),
                'clients_with_positive_balance' => Client::where('current_balance', '>', 0)->count(),
                'clients_with_negative_balance' => Client::where('current_balance', '<', 0)->count(),
                'clients_with_zero_balance' => Client::where('current_balance', 0)->count(),
                'total_credit_limit' => Client::sum('credit_limit'),
                'total_current_balance' => Client::sum('current_balance'),
                'average_credit_limit' => Client::avg('credit_limit'),
                'average_current_balance' => Client::avg('current_balance'),
                'average_base_reduction' => Client::avg('base_reduction')
            ];

            // Calculer le crédit disponible total
            $stats['total_available_credit'] = $stats['total_credit_limit'] - $stats['total_current_balance'];

            // Formater les nombres
            $stats['total_credit_limit'] = number_format($stats['total_credit_limit'], 2, '.', '');
            $stats['total_current_balance'] = number_format($stats['total_current_balance'], 2, '.', '');
            $stats['total_available_credit'] = number_format($stats['total_available_credit'], 2, '.', '');
            $stats['average_credit_limit'] = number_format($stats['average_credit_limit'] ?? 0, 2, '.', '');
            $stats['average_current_balance'] = number_format($stats['average_current_balance'] ?? 0, 2, '.', '');
            $stats['average_base_reduction'] = number_format($stats['average_base_reduction'] ?? 0, 2, '.', '');

            return response()->json([
                'success' => true,
                'data' => $stats
            ], 200);
        } catch (QueryException $e) {
            Log::error('Erreur de base de données lors du calcul des statistiques', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'DATABASE_ERROR',
                    'message' => 'Impossible de calculer les statistiques',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur de base de données'
                ]
            ], 500);
        } catch (Exception $e) {
            Log::error('Erreur inattendue lors du calcul des statistiques', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'STATISTICS_ERROR',
                    'message' => 'Une erreur est survenue lors du calcul des statistiques',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur interne du serveur'
                ]
            ], 500);
        }
    }

    /**
     * Rechercher des clients
     *
     * Recherche avancée de clients avec de multiples critères.
     *
     * @bodyParam query string required Terme de recherche. Example: John
     * @bodyParam fields array optionnel Champs à rechercher. Example: ["name_client", "email"]
     * @bodyParam client_type_id string optionnel Filtrer par type de client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam is_active boolean optionnel Filtrer par statut. Example: true
     * @bodyParam page integer optionnel Page à récupérer. Example: 1
     * @bodyParam per_page integer optionnel Éléments par page. Example: 20
     *
     * @response 200 scenario="Succès" {
     *   "success": true,
     *   "data": [],
     *   "meta": {
     *     "total": 0,
     *     "per_page": 20,
     *     "current_page": 1
     *   }
     * }
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'query' => 'required|string|min:1|max:255',
                'fields' => 'array',
                'fields.*' => 'in:name_client,email,code,city,phonenumber,ifu,name_representant,marketteur',
                'client_type_id' => 'nullable|uuid|exists:client_types,client_type_id',
                'is_active' => 'boolean',
                'credit_min' => 'nullable|numeric|min:0',
                'credit_max' => 'nullable|numeric|min:0',
                'balance_min' => 'nullable|numeric',
                'balance_max' => 'nullable|numeric',
                'reduction_min' => 'nullable|numeric|min:0|max:100',
                'reduction_max' => 'nullable|numeric|min:0|max:100',
                'page' => 'integer|min:1',
                'per_page' => 'integer|min:1|max:100'
            ], [
                'query.required' => 'Le terme de recherche est obligatoire',
                'query.min' => 'Le terme de recherche doit contenir au moins 1 caractère',
                'fields.*.in' => 'Un ou plusieurs champs de recherche sont invalides',
                'client_type_id.exists' => 'Le type de client spécifié n\'existe pas',
                'per_page.max' => 'Le nombre d\'éléments par page ne peut pas dépasser 100'
            ]);

            $query = Client::query();
            $searchQuery = $validated['query'];
            $searchFields = $validated['fields'] ?? ['name_client', 'email', 'code', 'ifu'];

            // Recherche dans les champs spécifiés
            $query->where(function ($q) use ($searchQuery, $searchFields) {
                foreach ($searchFields as $field) {
                    $q->orWhere($field, 'like', "%{$searchQuery}%");
                }
            });

            // Filtres additionnels
            if (isset($validated['client_type_id'])) {
                $query->where('client_type_id', $validated['client_type_id']);
            }

            if (isset($validated['is_active'])) {
                $query->where('is_active', $validated['is_active']);
            }

            if (isset($validated['credit_min'])) {
                $query->where('credit_limit', '>=', $validated['credit_min']);
            }

            if (isset($validated['credit_max'])) {
                $query->where('credit_limit', '<=', $validated['credit_max']);
            }

            if (isset($validated['balance_min'])) {
                $query->where('current_balance', '>=', $validated['balance_min']);
            }

            if (isset($validated['balance_max'])) {
                $query->where('current_balance', '<=', $validated['balance_max']);
            }

            if (isset($validated['reduction_min'])) {
                $query->where('base_reduction', '>=', $validated['reduction_min']);
            }

            if (isset($validated['reduction_max'])) {
                $query->where('base_reduction', '<=', $validated['reduction_max']);
            }

            $perPage = $validated['per_page'] ?? 20;
            $clients = $query->with('clientType')
                ->orderBy('name_client')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $clients->items(),
                'meta' => [
                    'total' => $clients->total(),
                    'per_page' => $clients->perPage(),
                    'current_page' => $clients->currentPage(),
                    'last_page' => $clients->lastPage(),
                    'from' => $clients->firstItem(),
                    'to' => $clients->lastItem()
                ]
            ], 200);
        } catch (ValidationException $e) {
            Log::warning('Erreur de validation lors de la recherche de clients', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => 'Les paramètres de recherche sont invalides',
                    'details' => $e->errors()
                ]
            ], 422);
        } catch (QueryException $e) {
            Log::error('Erreur de base de données lors de la recherche de clients', [
                'message' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'DATABASE_ERROR',
                    'message' => 'Une erreur est survenue lors de la recherche',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur de base de données'
                ]
            ], 500);
        } catch (Exception $e) {
            Log::error('Erreur inattendue lors de la recherche de clients', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'SEARCH_ERROR',
                    'message' => 'Une erreur est survenue lors de la recherche',
                    'details' => config('app.debug') ? $e->getMessage() : 'Erreur interne du serveur'
                ]
            ], 500);
        }
    }
}
