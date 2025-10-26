<?php

namespace App\Http\Controllers\Api;

use Log;
use App\Models\Client;
use App\Models\ClientType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @response 200 {
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
     *       "updated_at": "2024-01-15T10:30:00Z",
     *       "formatted_credit_limit": "500 000,00 FCFA",
     *       "formatted_current_balance": "150 000,00 FCFA",
     *       "available_credit": "350000.00",
     *       "formatted_available_credit": "350 000,00 FCFA",
     *       "formatted_base_reduction": "5,00 %"
     *     }
     *   ]
     * }
     */
    public function index(Request $request): JsonResponse
    {
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

        // ❌ ERREUR CORRIGÉE : Lignes 91-101
        // Syntaxe incorrecte : ->orWhere->byEmail($search)
        // Cette syntaxe n'existe pas en Laravel/PHP

        // Recherche globale - VERSION CORRIGÉE
        if (isset($validated['search'])) {
            $search = $validated['search'];
            $query->where(function ($q) use ($search) {
                // Option 1 : Si byName, byEmail, byCode, byIfu sont des query scopes locaux
                $q->byName($search)
                    ->orWhere(function ($subQ) use ($search) {
                        $subQ->byEmail($search);
                    })
                    ->orWhere(function ($subQ) use ($search) {
                        $subQ->byCode($search);
                    })
                    ->orWhere(function ($subQ) use ($search) {
                        $subQ->byIfu($search);
                    })
                    ->orWhere('name_representant', 'like', "%{$search}%")
                    ->orWhere('marketteur', 'like', "%{$search}%");

                // Option 2 : Si ce sont des scopes globaux avec support de orWhere
                // Vérifiez votre modèle Client pour la définition exacte des scopes
                // Sinon utilisez directement les colonnes :
                /*
                $q->where('name_client', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('ifu', 'like', "%{$search}%")
                    ->orWhere('name_representant', 'like', "%{$search}%")
                    ->orWhere('marketteur', 'like', "%{$search}%");
                */
            });
        }

        // Filtres spécifiques
        if (isset($validated['name'])) {
            $query->byName($validated['name']);
        }

        if (isset($validated['email'])) {
            $query->byEmail($validated['email']);
        }

        if (isset($validated['code'])) {
            $query->byCode($validated['code']);
        }

        if (isset($validated['city'])) {
            $query->byCity($validated['city']);
        }

        if (isset($validated['ifu'])) {
            $query->byIfu($validated['ifu']);
        }

        if (isset($validated['marketteur'])) {
            $query->where('marketteur', 'like', "%{$validated['marketteur']}%");
        }

        if (isset($validated['client_type_id'])) {
            $query->byClientType($validated['client_type_id']);
        }

        if (isset($validated['is_active'])) {
            if ($validated['is_active']) {
                $query->active();
            } else {
                $query->inactive();
            }
        }

        // Filtre par solde
        if (isset($validated['balance_filter'])) {
            switch ($validated['balance_filter']) {
                case 'positive':
                    $query->withPositiveBalance();
                    break;
                case 'negative':
                    $query->withNegativeBalance();
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

        return response()->json($clients);
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
     * @response 201 {
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "code": "CLI00001",
     *     "name_client": "John Doe",
     *     "name_representant": "Jane Smith",
     *     "marketteur": "Marie Dupont",
     *     "client_type_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "adresse": "123 Rue de la Paix",
     *     "city": "Cotonou",
     *     "email": "john.doe@example.com",
     *     "ifu": "1234567890123",
     *     "phonenumber": "+229 12 34 56 78",
     *     "credit_limit": "500000.00",
     *     "current_balance": "0.00",
     *     "base_reduction": "5.00",
     *     "is_active": true,
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T10:30:00Z"
     *   },
     *   "message": "Client créé avec succès"
     * }
     * @response 422 {
     *   "message": "Données de validation échouées",
     *   "errors": {
     *     "email": ["Cette adresse email est déjà utilisée"],
     *     "ifu": ["Ce numéro IFU est déjà utilisé"]
     *   }
     * }
     */
    public function store(StoreClientRequest $request): JsonResponse
    {
        Log::info('Store method called', ['user' => auth()->user(), 'request' => $request->all()]);

        try {
            // Les données sont déjà validées par StoreClientRequest
            $validated = $request->validated();

            // Récupérer le numéro maximum existant (incluant soft deleted)
            $maxNumber = Client::withTrashed()
                ->selectRaw("MAX(CAST(SUBSTRING(code, 4) AS UNSIGNED)) as max_number")
                ->value('max_number') ?? 0;

            // Générer le nouveau code
            $newCode = 'CLI' . str_pad($maxNumber + 1, 5, '0', STR_PAD_LEFT);

            $validated['code'] = $newCode;

            $client = Client::create($validated);
            $client->load('clientType');

            return response()->json([
                'success' => true,
                'message' => 'Client créé avec succès',
                'data' => $client
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du client',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un client spécifique
     *
     * Récupère les détails d'un client par son ID.
     *
     * @urlParam client_id string required L'UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam with_client_type boolean Inclure les informations du type de client. Example: true
     *
     * @response 200 {
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "code": "CLI00001",
     *     "name_client": "John Doe",
     *     "name_representant": "Jane Smith",
     *     "marketteur": "Marie Dupont",
     *     "client_type_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "adresse": "123 Rue de la Paix",
     *     "city": "Cotonou",
     *     "email": "john.doe@example.com",
     *     "ifu": "1234567890123",
     *     "phonenumber": "+229 12 34 56 78",
     *     "credit_limit": "500000.00",
     *     "current_balance": "150000.00",
     *     "base_reduction": "5.00",
     *     "is_active": true,
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T10:30:00Z"
     *   }
     * }
     * @response 404 {
     *   "message": "Client non trouvé"
     * }
     */
    public function show(Request $request, string $client_id): JsonResponse
    {
        $validated = $request->validate([
            'with_client_type' => 'boolean'
        ]);
        try {
            $query = Client::where('client_id', $client_id);

            if (isset($validated['with_client_type']) && $validated['with_client_type']) {
                $query->with('clientType');
            }

            $client = $query->firstOrFail();

            return response()->json([
                'data' => $client
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Client non trouvé'
            ], 404);
        }
    }

    /**
     * Mettre à jour un client
     *
     * Met à jour les informations d'un client existant.
     * Seuls les champs fournis seront mis à jour.
     *
     * @urlParam client_id string required L'UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam code string Code client unique. Example: CLI-UPDATED
     * @bodyParam name_client string Nom complet du client. Example: Jane Doe
     * @bodyParam name_representant string Nom du représentant du client. Example: John Smith
     * @bodyParam marketteur string Nom du marketteur associé. Example: Pierre Martin
     * @bodyParam client_type_id string UUID du type de client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam adresse string Adresse du client. Example: 456 Avenue des Palmiers
     * @bodyParam city string Ville du client. Example: Porto-Novo
     * @bodyParam email string Email unique du client. Example: jane.doe@example.com
     * @bodyParam ifu string Numéro IFU unique. Example: 9876543210987
     * @bodyParam phonenumber string Numéro de téléphone. Example: +229 87 65 43 21
     * @bodyParam credit_limit number Limite de crédit. Example: 750000
     * @bodyParam current_balance number Solde actuel. Example: 200000
     * @bodyParam base_reduction number Réduction de base en pourcentage (0-100). Example: 10
     * @bodyParam is_active boolean Statut actif. Example: false
     *
     * @response 200 {
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "code": "CLI-UPDATED",
     *     "name_client": "Jane Doe",
     *     "name_representant": "John Smith",
     *     "marketteur": "Pierre Martin",
     *     "client_type_id": "550e8400-e29b-41d4-a716-446655440001",
     *     "adresse": "456 Avenue des Palmiers",
     *     "city": "Porto-Novo",
     *     "email": "jane.doe@example.com",
     *     "ifu": "9876543210987",
     *     "phonenumber": "+229 87 65 43 21",
     *     "credit_limit": "750000.00",
     *     "current_balance": "200000.00",
     *     "base_reduction": "10.00",
     *     "is_active": false,
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T11:00:00Z"
     *   },
     *   "message": "Client mis à jour avec succès"
     * }
     * @response 404 {
     *   "message": "Client non trouvé"
     * }
     * @response 422 {
     *   "message": "Données de validation échouées",
     *   "errors": {
     *     "email": ["Cette adresse email est déjà utilisée"],
     *     "ifu": ["Ce numéro IFU est déjà utilisé"]
     *   }
     * }
     */
    public function update(Request $request, string $client_id): JsonResponse
    {
        try {
            $client = Client::where('client_id', $client_id)->firstOrFail();

            $validated = $request->validate([
                'code' => ['nullable', 'string', 'max:50', Rule::unique('clients', 'code')->ignore($client->client_id, 'client_id')],
                'name_client' => 'sometimes|required|string|max:255',
                'name_representant' => 'nullable|string|max:255',
                'marketteur' => 'nullable|string|max:255',
                'client_type_id' => 'nullable|uuid|exists:client_types,client_type_id',
                'adresse' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'email' => ['nullable', 'email', 'max:255', Rule::unique('clients', 'email')->ignore($client->client_id, 'client_id')],
                'ifu' => ['nullable', 'string', 'max:50', Rule::unique('clients', 'ifu')->ignore($client->client_id, 'client_id')],
                'phonenumber' => 'nullable|string|max:20',
                'credit_limit' => 'nullable|numeric|min:0|max:999999999999.99',
                'current_balance' => 'nullable|numeric|min:-999999999999.99|max:999999999999.99',
                'base_reduction' => 'nullable|numeric|min:0|max:100',
                'is_active' => 'boolean'
            ], [
                'client_type_id.exists' => 'Le type de client sélectionné n\'existe pas',
                'email.unique' => 'Cette adresse email est déjà utilisée',
                'email.email' => 'L\'adresse email doit être valide',
                'ifu.unique' => 'Ce numéro IFU est déjà utilisé',
                'code.unique' => 'Ce code client existe déjà',
                'credit_limit.min' => 'La limite de crédit doit être positive',
                'base_reduction.min' => 'La réduction de base doit être positive',
                'base_reduction.max' => 'La réduction de base ne peut pas dépasser 100%',
                'phonenumber.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères'
            ]);

            $client->update($validated);
            $client->load('clientType');

            return response()->json([
                'data' => $client->fresh(),
                'message' => 'Client mis à jour avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Client non trouvé'
            ], 404);
        }
    }

    /**
     * Supprimer un client
     *
     * Supprime un client (soft delete).
     * Le client sera marqué comme supprimé mais restera dans la base de données.
     *
     * @urlParam client_id string required L'UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "message": "Client supprimé avec succès"
     * }
     * @response 404 {
     *   "message": "Client non trouvé"
     * }
     */
    public function destroy(string $client_id): JsonResponse
    {
        try {
            $client = Client::where('client_id', $client_id)->firstOrFail();
            $client->delete();

            return response()->json([
                'message' => 'Client supprimé avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Client non trouvé'
            ], 404);
        }
    }

    /**
     * Restaurer un client supprimé
     *
     * Restaure un client qui a été supprimé avec soft delete.
     *
     * @urlParam client_id string required L'UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response 200 {
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "code": "CLI-ABC123",
     *     "name_client": "John Doe",
     *     "deleted_at": null
     *   },
     *   "message": "Client restauré avec succès"
     * }
     * @response 400 {
     *   "message": "Ce client n'est pas supprimé"
     * }
     * @response 404 {
     *   "message": "Client non trouvé"
     * }
     */
    public function restore(string $client_id): JsonResponse
    {
        try {
            $client = Client::withTrashed()
                ->where('client_id', $client_id)
                ->firstOrFail();

            if (!$client->trashed()) {
                return response()->json([
                    'message' => 'Ce client n\'est pas supprimé'
                ], 400);
            }

            $client->restore();

            return response()->json([
                'data' => $client->fresh(),
                'message' => 'Client restauré avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Client non trouvé'
            ], 404);
        }
    }

    /**
     * Lister les clients supprimés
     *
     * Récupère la liste des clients supprimés (soft delete).
     *
     * @queryParam page integer Page à récupérer. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page. Example: 15
     * @queryParam with_client_type boolean Inclure les informations du type de client. Example: true
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "code": "CLI-DEL123",
     *       "name_client": "Client Supprimé",
     *       "email": "deleted@example.com",
     *       "created_at": "2024-01-15T10:30:00Z",
     *       "updated_at": "2024-01-15T10:30:00Z",
     *       "deleted_at": "2024-01-15T12:00:00Z"
     *     }
     *   ]
     * }
     */
    public function trashed(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'with_client_type' => 'boolean'
        ]);

        $query = Client::onlyTrashed();

        if (isset($validated['with_client_type']) && $validated['with_client_type']) {
            $query->with('clientType');
        }

        $perPage = $validated['per_page'] ?? 15;
        $clients = $query->orderBy('deleted_at', 'desc')->paginate($perPage);

        return response()->json($clients);
    }

    /**
     * Activer/Désactiver un client
     *
     * Change le statut actif d'un client.
     *
     * @urlParam client_id string required L'UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam is_active boolean required Nouveau statut actif. Example: false
     *
     * @response 200 {
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "is_active": false
     *   },
     *   "message": "Statut du client mis à jour avec succès"
     * }
     * @response 404 {
     *   "message": "Client non trouvé"
     * }
     */
    public function toggleStatus(Request $request, string $client_id): JsonResponse
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean'
        ]);

        try {
            $client = Client::where('client_id', $client_id)->firstOrFail();
            $client->update(['is_active' => $validated['is_active']]);

            return response()->json([
                'data' => [
                    'client_id' => $client->client_id,
                    'is_active' => $client->is_active
                ],
                'message' => 'Statut du client mis à jour avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Client non trouvé'
            ], 404);
        }
    }

    /**
     * Mettre à jour le solde d'un client
     *
     * Ajoute ou soustrait un montant au solde actuel du client.
     *
     * @urlParam client_id string required L'UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam amount number required Montant à ajouter (positif) ou soustraire (négatif). Example: 50000
     * @bodyParam description string optionnel Description de l'opération. Example: Paiement facture
     *
     * @response 200 {
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "previous_balance": "150000.00",
     *     "new_balance": "200000.00",
     *     "amount_added": "50000.00",
     *     "available_credit": "300000.00",
     *     "description": "Paiement facture"
     *   },
     *   "message": "Solde mis à jour avec succès"
     * }
     * @response 400 {
     *   "message": "Le montant dépasserait la limite de crédit autorisée",
     *   "data": {
     *     "current_balance": "150000.00",
     *     "credit_limit": "500000.00",
     *     "available_credit": "350000.00",
     *     "requested_amount": "400000.00"
     *   }
     * }
     * @response 404 {
     *   "message": "Client non trouvé"
     * }
     */
    public function updateBalance(Request $request, string $client_id): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|not_in:0',
            'description' => 'nullable|string|max:255'
        ], [
            'amount.required' => 'Le montant est requis',
            'amount.not_in' => 'Le montant ne peut pas être zéro',
            'amount.numeric' => 'Le montant doit être un nombre'
        ]);

        try {
            $client = Client::where('client_id', $client_id)->firstOrFail();

            $previousBalance = $client->current_balance;
            $newBalance = $previousBalance + $validated['amount'];

            // Vérifier la limite de crédit si c'est un ajout
            if ($validated['amount'] > 0 && $newBalance > $client->credit_limit) {
                return response()->json([
                    'message' => 'Le montant dépasserait la limite de crédit autorisée',
                    'data' => [
                        'current_balance' => $client->current_balance,
                        'credit_limit' => $client->credit_limit,
                        'available_credit' => $client->available_credit,
                        'requested_amount' => $validated['amount']
                    ]
                ], 400);
            }

            $client->updateBalance($validated['amount']);

            return response()->json([
                'data' => [
                    'client_id' => $client->client_id,
                    'previous_balance' => number_format($previousBalance, 2, '.', ''),
                    'new_balance' => number_format($client->current_balance, 2, '.', ''),
                    'amount_added' => number_format($validated['amount'], 2, '.', ''),
                    'available_credit' => number_format($client->available_credit, 2, '.', ''),
                    'description' => $validated['description'] ?? null
                ],
                'message' => 'Solde mis à jour avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Client non trouvé'
            ], 404);
        }
    }

    /**
     * Statistiques des clients
     *
     * Récupère des statistiques générales sur les clients.
     *
     * @response 200 {
     *   "data": {
     *     "total_clients": 150,
     *     "active_clients": 120,
     *     "inactive_clients": 30,
     *     "deleted_clients": 5,
     *     "clients_with_positive_balance": 80,
     *     "clients_with_negative_balance": 25,
     *     "clients_with_zero_balance": 45,
     *     "total_credit_limit": "75000000.00",
     *     "total_current_balance": "12500000.00",
     *     "total_available_credit": "62500000.00",
     *     "average_credit_limit": "500000.00",
     *     "average_current_balance": "83333.33",
     *     "average_base_reduction": "5.25"
     *   }
     * }
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_clients' => Client::count(),
            'active_clients' => Client::active()->count(),
            'inactive_clients' => Client::inactive()->count(),
            'deleted_clients' => Client::onlyTrashed()->count(),
            'clients_with_positive_balance' => Client::withPositiveBalance()->count(),
            'clients_with_negative_balance' => Client::withNegativeBalance()->count(),
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
            'data' => $stats
        ]);
    }

    /**
     * Rechercher des clients
     *
     * Recherche avancée de clients avec de multiples critères.
     *
     * @bodyParam query string required Terme de recherche. Example: John
     * @bodyParam fields array optionnel Champs à rechercher (name_client, email, code, city, phonenumber, ifu, name_representant, marketteur). Example: ["name_client", "email", "ifu"]
     * @bodyParam client_type_id string optionnel Filtrer par type de client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam is_active boolean optionnel Filtrer par statut. Example: true
     * @bodyParam credit_min number optionnel Limite de crédit minimale. Example: 100000
     * @bodyParam credit_max number optionnel Limite de crédit maximale. Example: 1000000
     * @bodyParam balance_min number optionnel Solde minimal. Example: -50000
     * @bodyParam balance_max number optionnel Solde maximal. Example: 500000
     * @bodyParam reduction_min number optionnel Réduction de base minimale (%). Example: 0
     * @bodyParam reduction_max number optionnel Réduction de base maximale (%). Example: 20
     * @bodyParam page integer optionnel Page à récupérer. Example: 1
     * @bodyParam per_page integer optionnel Éléments par page. Example: 20
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "code": "CLI-ABC123",
     *       "name_client": "John Doe",
     *       "name_representant": "Jane Smith",
     *       "marketteur": "Marie Dupont",
     *       "email": "john.doe@example.com",
     *       "ifu": "1234567890123",
     *       "city": "Cotonou",
     *       "phonenumber": "+229 12 34 56 78",
     *       "credit_limit": "500000.00",
     *       "current_balance": "150000.00",
     *       "base_reduction": "5.00",
     *       "is_active": true
     *     }
     *   ],
     *   "meta": {
     *     "total": 1,
     *     "per_page": 20,
     *     "current_page": 1
     *   }
     * }
     */
    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'query' => 'required|string|min:1|max:255',
            'fields' => 'array|in:name_client,email,code,city,phonenumber,ifu,name_representant,marketteur',
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
            $query->byClientType($validated['client_type_id']);
        }

        if (isset($validated['is_active'])) {
            if ($validated['is_active']) {
                $query->active();
            } else {
                $query->inactive();
            }
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

        return response()->json($clients);
    }
}
