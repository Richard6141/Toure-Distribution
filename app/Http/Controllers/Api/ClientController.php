<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\ClientPhone;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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
     * @queryParam search string Recherche globale (nom, email, code, IFU, représentant, marketteur, téléphones). Example: John
     * @queryParam name string Rechercher par nom de client. Example: John Doe
     * @queryParam email string Rechercher par email. Example: john@example.com
     * @queryParam code string Rechercher par code client. Example: CLI-ABC123
     * @queryParam city string Rechercher par ville. Example: Cotonou
     * @queryParam ifu string Rechercher par numéro IFU. Example: 1234567890123
     * @queryParam marketteur string Rechercher par marketteur. Example: Marie Dupont
     * @queryParam client_type_id string Filtrer par type de client (UUID). Example: 550e8400-e29b-41d4-a716-446655440000
     * @queryParam is_active boolean Filtrer par statut actif. Example: true
     * @queryParam with_client_type boolean Inclure les informations du type de client. Example: true
     * @queryParam with_phones boolean Inclure les numéros de téléphone. Example: true
     * @queryParam balance_filter string Filtrer par solde (positive, negative, zero). Example: positive
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *       "code": "CLI00001",
     *       "name_client": "John Doe",
     *       "name_representant": "Jane Smith",
     *       "marketteur": "Marie Dupont",
     *       "client_type_id": "550e8400-e29b-41d4-a716-446655440001",
     *       "adresse": "123 Rue de la Paix",
     *       "city": "Cotonou",
     *       "email": "john.doe@example.com",
     *       "ifu": "1234567890123",
     *       "phonenumber": "+229 12 34 56 78",
     *       "phones": [
     *         {
     *           "id": "uuid",
     *           "phone_number": "+229 12 34 56 78",
     *           "type": "mobile",
     *           "label": "Principal"
     *         }
     *       ],
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
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "per_page": ["Le nombre d'éléments par page ne peut pas dépasser 100"]
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        try {
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
                'with_phones' => 'boolean',
                'balance_filter' => 'in:positive,negative,zero'
            ], [
                'per_page.max' => 'Le nombre d\'éléments par page ne peut pas dépasser 100',
                'per_page.integer' => 'Le nombre d\'éléments par page doit être un nombre entier',
                'client_type_id.exists' => 'Le type de client spécifié n\'existe pas',
                'balance_filter.in' => 'Le filtre de solde doit être : positive, negative ou zero'
            ]);

            $query = Client::query();

            // Recherche globale
            if (isset($validated['search'])) {
                $search = $validated['search'];
                $query->where(function ($q) use ($search) {
                    $q->where('name_client', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('ifu', 'like', "%{$search}%")
                        ->orWhere('name_representant', 'like', "%{$search}%")
                        ->orWhere('marketteur', 'like', "%{$search}%")
                        ->orWhereHas('phones', function ($q) use ($search) {
                            $q->where('phone_number', 'like', "%{$search}%");
                        });
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

            // Inclure les relations
            if (isset($validated['with_client_type']) && $validated['with_client_type']) {
                $query->with('clientType');
            }

            if (isset($validated['with_phones']) && $validated['with_phones']) {
                $query->with('phones');
            }

            $perPage = $validated['per_page'] ?? 15;
            $clients = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $clients->items(),
                'pagination' => [
                    'current_page' => $clients->currentPage(),
                    'last_page' => $clients->lastPage(),
                    'per_page' => $clients->perPage(),
                    'total' => $clients->total(),
                    'from' => $clients->firstItem(),
                    'to' => $clients->lastItem(),
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des clients', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des clients',
                'error' => config('app.debug') ? $e->getMessage() : 'Erreur serveur'
            ], 500);
        }
    }

    /**
     * Créer un nouveau client
     *
     * Crée un nouveau client avec les informations fournies.
     * L'UUID et le code client sont générés automatiquement.
     *
     * @bodyParam name_client string required Nom complet du client. Example: John Doe
     * @bodyParam name_representant string Nom du représentant du client. Example: Jane Smith
     * @bodyParam marketteur string Nom du marketteur associé au client. Example: Marie Dupont
     * @bodyParam client_type_id string UUID du type de client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam adresse string Adresse du client. Example: 123 Rue de la Paix
     * @bodyParam city string Ville du client. Example: Cotonou
     * @bodyParam email string Email unique du client. Example: john.doe@example.com
     * @bodyParam ifu string Numéro IFU (Identifiant Fiscal Unique). Example: 1234567890123
     * @bodyParam phones array required Tableau de numéros de téléphone (minimum 1). Example: [{"phone_number": "+229 12 34 56 78", "type": "mobile", "label": "Principal"}]
     * @bodyParam phones[].phone_number string required Numéro de téléphone. Example: +229 12 34 56 78
     * @bodyParam phones[].type string required Type de téléphone (mobile, fixe, whatsapp, autre). Example: mobile
     * @bodyParam phones[].label string Label du numéro. Example: Principal
     * @bodyParam credit_limit number Limite de crédit (défaut: 0). Example: 500000
     * @bodyParam current_balance number Solde actuel (défaut: 0). Example: 0
     * @bodyParam base_reduction number Réduction de base en pourcentage (0-100, défaut: 0). Example: 5
     * @bodyParam is_active boolean Statut actif (défaut: true). Example: true
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Client créé avec succès",
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
     *     "phones": [
     *       {
     *         "id": "uuid",
     *         "phone_number": "+229 12 34 56 78",
     *         "type": "mobile",
     *         "label": "Principal"
     *       }
     *     ],
     *     "credit_limit": "500000.00",
     *     "current_balance": "0.00",
     *     "base_reduction": "5.00",
     *     "is_active": true,
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T10:30:00Z"
     *   }
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "email": ["Cette adresse email est déjà utilisée"],
     *     "phones": ["Au moins un numéro de téléphone est requis"]
     *   }
     * }
     * 
     * @response 500 {
     *   "success": false,
     *   "message": "Erreur lors de la création du client",
     *   "error": "Message d'erreur détaillé"
     * }
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name_client' => 'required|string|max:255',
                'name_representant' => 'nullable|string|max:255',
                'marketteur' => 'nullable|string|max:255',
                'client_type_id' => 'nullable|uuid|exists:client_types,client_type_id',
                'adresse' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'email' => 'nullable|email|max:255|unique:clients,email',
                'ifu' => 'nullable|string|max:50|unique:clients,ifu',
                'phones' => 'required|array|min:1',
                'phones.*.phone_number' => 'required|string|max:20|distinct',
                'phones.*.type' => 'required|in:mobile,fixe,whatsapp,autre',
                'phones.*.label' => 'nullable|string|max:50',
                'credit_limit' => 'nullable|numeric|min:0|max:999999999999.99',
                'current_balance' => 'nullable|numeric|min:-999999999999.99|max:999999999999.99',
                'base_reduction' => 'nullable|numeric|min:0|max:100',
                'is_active' => 'boolean'
            ], [
                // Messages personnalisés
                'name_client.required' => 'Le nom du client est obligatoire',
                'name_client.max' => 'Le nom du client ne peut pas dépasser 255 caractères',
                'client_type_id.exists' => 'Le type de client sélectionné n\'existe pas',
                'email.email' => 'L\'adresse email doit être valide',
                'email.unique' => 'Cette adresse email est déjà utilisée par un autre client',
                'ifu.unique' => 'Ce numéro IFU est déjà utilisé par un autre client',
                'phones.required' => 'Au moins un numéro de téléphone est requis',
                'phones.min' => 'Vous devez fournir au minimum 1 numéro de téléphone',
                'phones.*.phone_number.required' => 'Le numéro de téléphone est obligatoire',
                'phones.*.phone_number.distinct' => 'Les numéros de téléphone doivent être uniques',
                'phones.*.type.required' => 'Le type de téléphone est obligatoire',
                'phones.*.type.in' => 'Le type de téléphone doit être : mobile, fixe, whatsapp ou autre',
                'credit_limit.min' => 'La limite de crédit ne peut pas être négative',
                'base_reduction.min' => 'La réduction de base ne peut pas être négative',
                'base_reduction.max' => 'La réduction de base ne peut pas dépasser 100%',
            ]);

            DB::beginTransaction();

            try {
                // Générer le code client automatiquement
                $lastClient = Client::orderByDesc('created_at')->lockForUpdate()->first();
                $lastNumber = $lastClient && preg_match('/CLI(\d+)/', $lastClient->code, $matches)
                    ? (int)$matches[1]
                    : 0;

                $validated['code'] = 'CLI' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

                // Séparer les téléphones des autres données
                $phonesData = $validated['phones'];
                unset($validated['phones']);

                // Créer le client
                $client = Client::create($validated);

                // Créer les numéros de téléphone
                foreach ($phonesData as $phoneData) {
                    $client->phones()->create($phoneData);
                }

                // Charger les relations
                $client->load(['clientType', 'phones']);

                DB::commit();

                Log::info('Client créé avec succès', ['client_id' => $client->client_id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Client créé avec succès',
                    'data' => $client
                ], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du client', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password'])
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du client',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur interne est survenue'
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
     * @queryParam with_phones boolean Inclure les numéros de téléphone. Example: true
     *
     * @response 200 {
     *   "success": true,
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
     *     "phones": [
     *       {
     *         "id": "uuid",
     *         "phone_number": "+229 12 34 56 78",
     *         "type": "mobile",
     *         "label": "Principal"
     *       }
     *     ],
     *     "credit_limit": "500000.00",
     *     "current_balance": "150000.00",
     *     "base_reduction": "5.00",
     *     "is_active": true,
     *     "created_at": "2024-01-15T10:30:00Z",
     *     "updated_at": "2024-01-15T10:30:00Z"
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Client non trouvé",
     *   "error": "Aucun client ne correspond à l'identifiant fourni"
     * }
     */
    public function show(Request $request, string $client_id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'with_client_type' => 'boolean',
                'with_phones' => 'boolean'
            ]);

            $query = Client::where('client_id', $client_id);

            if (isset($validated['with_client_type']) && $validated['with_client_type']) {
                $query->with('clientType');
            }

            if (isset($validated['with_phones']) && $validated['with_phones']) {
                $query->with('phones');
            }

            $client = $query->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $client
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Client non trouvé',
                'error' => 'Aucun client ne correspond à l\'identifiant fourni'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération du client', [
                'client_id' => $client_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du client',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur interne est survenue'
            ], 500);
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
     * @bodyParam phones array Tableau de numéros de téléphone. Example: [{"id": "uuid", "phone_number": "+229 12 34 56 78", "type": "mobile"}]
     * @bodyParam phones[].id string UUID du téléphone (pour mise à jour). Example: uuid-existant
     * @bodyParam phones[].phone_number string required Numéro de téléphone. Example: +229 87 65 43 21
     * @bodyParam phones[].type string required Type (mobile, fixe, whatsapp, autre). Example: mobile
     * @bodyParam phones[].label string Label du numéro. Example: Bureau
     * @bodyParam credit_limit number Limite de crédit. Example: 750000
     * @bodyParam current_balance number Solde actuel. Example: 200000
     * @bodyParam base_reduction number Réduction de base en pourcentage (0-100). Example: 10
     * @bodyParam is_active boolean Statut actif. Example: false
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Client mis à jour avec succès",
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "code": "CLI-UPDATED",
     *     "name_client": "Jane Doe",
     *     "phones": [
     *       {
     *         "id": "uuid",
     *         "phone_number": "+229 87 65 43 21",
     *         "type": "mobile",
     *         "label": "Bureau"
     *       }
     *     ]
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Client non trouvé"
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "email": ["Cette adresse email est déjà utilisée"],
     *     "phones": ["Au moins un numéro de téléphone est requis"]
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
                'phones' => 'nullable|array|min:1',
                'phones.*.id' => 'nullable|uuid|exists:client_phones,id',
                'phones.*.phone_number' => 'required|string|max:20|distinct',
                'phones.*.type' => 'required|in:mobile,fixe,whatsapp,autre',
                'phones.*.label' => 'nullable|string|max:50',
                'credit_limit' => 'nullable|numeric|min:0|max:999999999999.99',
                'current_balance' => 'nullable|numeric|min:-999999999999.99|max:999999999999.99',
                'base_reduction' => 'nullable|numeric|min:0|max:100',
                'is_active' => 'boolean'
            ], [
                'code.unique' => 'Ce code client est déjà utilisé par un autre client',
                'name_client.required' => 'Le nom du client est obligatoire',
                'client_type_id.exists' => 'Le type de client sélectionné n\'existe pas',
                'email.email' => 'L\'adresse email doit être valide',
                'email.unique' => 'Cette adresse email est déjà utilisée par un autre client',
                'ifu.unique' => 'Ce numéro IFU est déjà utilisé par un autre client',
                'phones.min' => 'Au moins un numéro de téléphone est requis',
                'phones.*.phone_number.required' => 'Le numéro de téléphone est obligatoire',
                'phones.*.phone_number.distinct' => 'Les numéros de téléphone doivent être uniques',
                'phones.*.type.required' => 'Le type de téléphone est obligatoire',
                'phones.*.type.in' => 'Le type de téléphone doit être : mobile, fixe, whatsapp ou autre',
            ]);

            DB::beginTransaction();

            try {
                // Gérer les numéros de téléphone si fournis
                if (isset($validated['phones'])) {
                    $phonesData = $validated['phones'];
                    unset($validated['phones']);

                    // Collecter les IDs des téléphones à conserver
                    $phoneIdsToKeep = collect($phonesData)
                        ->filter(fn($p) => isset($p['id']))
                        ->pluck('id')
                        ->toArray();

                    // Supprimer les téléphones non inclus dans la mise à jour
                    $client->phones()->whereNotIn('id', $phoneIdsToKeep)->delete();

                    // Mettre à jour ou créer les téléphones
                    foreach ($phonesData as $phoneData) {
                        if (isset($phoneData['id'])) {
                            // Mise à jour d'un téléphone existant
                            $phone = ClientPhone::find($phoneData['id']);
                            if ($phone && $phone->client_id === $client->client_id) {
                                $phone->update($phoneData);
                            } else {
                                throw new \Exception("Le téléphone avec l'ID {$phoneData['id']} n'appartient pas à ce client");
                            }
                        } else {
                            // Création d'un nouveau téléphone
                            $client->phones()->create($phoneData);
                        }
                    }
                }

                // Mettre à jour le client
                $client->update($validated);
                $client->load(['clientType', 'phones']);

                DB::commit();

                Log::info('Client mis à jour avec succès', ['client_id' => $client->client_id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Client mis à jour avec succès',
                    'data' => $client->fresh(['clientType', 'phones'])
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Client non trouvé',
                'error' => 'Aucun client ne correspond à l\'identifiant fourni'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du client', [
                'client_id' => $client_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du client',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur interne est survenue'
            ], 500);
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
     *   "success": true,
     *   "message": "Client supprimé avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Client non trouvé"
     * }
     */
    public function destroy(string $client_id): JsonResponse
    {
        try {
            $client = Client::where('client_id', $client_id)->firstOrFail();
            $client->delete();

            Log::info('Client supprimé avec succès', ['client_id' => $client_id]);

            return response()->json([
                'success' => true,
                'message' => 'Client supprimé avec succès'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Client non trouvé',
                'error' => 'Aucun client ne correspond à l\'identifiant fourni'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du client', [
                'client_id' => $client_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du client',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur interne est survenue'
            ], 500);
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
     *   "success": true,
     *   "message": "Client restauré avec succès",
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "code": "CLI-ABC123",
     *     "name_client": "John Doe",
     *     "deleted_at": null
     *   }
     * }
     * 
     * @response 400 {
     *   "success": false,
     *   "message": "Ce client n'est pas supprimé",
     *   "error": "Le client est déjà actif"
     * }
     * 
     * @response 404 {
     *   "success": false,
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
                    'success' => false,
                    'message' => 'Ce client n\'est pas supprimé',
                    'error' => 'Le client est déjà actif'
                ], 400);
            }

            $client->restore();

            Log::info('Client restauré avec succès', ['client_id' => $client_id]);

            return response()->json([
                'success' => true,
                'message' => 'Client restauré avec succès',
                'data' => $client->fresh()
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Client non trouvé',
                'error' => 'Aucun client ne correspond à l\'identifiant fourni'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la restauration du client', [
                'client_id' => $client_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration du client',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur interne est survenue'
            ], 500);
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
     * @queryParam with_phones boolean Inclure les numéros de téléphone. Example: true
     *
     * @response 200 {
     *   "success": true,
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
        try {
            $validated = $request->validate([
                'page' => 'integer|min:1',
                'per_page' => 'integer|min:1|max:100',
                'with_client_type' => 'boolean',
                'with_phones' => 'boolean'
            ]);

            $query = Client::onlyTrashed();

            if (isset($validated['with_client_type']) && $validated['with_client_type']) {
                $query->with('clientType');
            }

            if (isset($validated['with_phones']) && $validated['with_phones']) {
                $query->with('phones');
            }

            $perPage = $validated['per_page'] ?? 15;
            $clients = $query->orderBy('deleted_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $clients->items(),
                'pagination' => [
                    'current_page' => $clients->currentPage(),
                    'last_page' => $clients->lastPage(),
                    'per_page' => $clients->perPage(),
                    'total' => $clients->total(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des clients supprimés', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des clients supprimés',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur interne est survenue'
            ], 500);
        }
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
     *   "success": true,
     *   "message": "Statut du client mis à jour avec succès",
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "is_active": false
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Client non trouvé"
     * }
     */
    public function toggleStatus(Request $request, string $client_id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'is_active' => 'required|boolean'
            ], [
                'is_active.required' => 'Le statut actif est obligatoire',
                'is_active.boolean' => 'Le statut actif doit être true ou false'
            ]);

            $client = Client::where('client_id', $client_id)->firstOrFail();
            $client->update(['is_active' => $validated['is_active']]);

            Log::info('Statut du client mis à jour', [
                'client_id' => $client_id,
                'is_active' => $validated['is_active']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Statut du client mis à jour avec succès',
                'data' => [
                    'client_id' => $client->client_id,
                    'is_active' => $client->is_active
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Client non trouvé',
                'error' => 'Aucun client ne correspond à l\'identifiant fourni'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du statut', [
                'client_id' => $client_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur interne est survenue'
            ], 500);
        }
    }

    /**
     * Mettre à jour le solde d'un client
     *
     * Ajoute ou soustrait un montant au solde actuel du client.
     *
     * @urlParam client_id string required L'UUID du client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam amount number required Montant à ajouter (positif) ou soustraire (négatif). Example: 50000
     * @bodyParam description string Description de l'opération. Example: Paiement facture
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Solde mis à jour avec succès",
     *   "data": {
     *     "client_id": "550e8400-e29b-41d4-a716-446655440000",
     *     "previous_balance": "150000.00",
     *     "new_balance": "200000.00",
     *     "amount_added": "50000.00",
     *     "available_credit": "300000.00",
     *     "description": "Paiement facture"
     *   }
     * }
     * 
     * @response 400 {
     *   "success": false,
     *   "message": "Le montant dépasserait la limite de crédit autorisée",
     *   "data": {
     *     "current_balance": "150000.00",
     *     "credit_limit": "500000.00",
     *     "available_credit": "350000.00",
     *     "requested_amount": "400000.00"
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Client non trouvé"
     * }
     */
    public function updateBalance(Request $request, string $client_id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'amount' => 'required|numeric|not_in:0',
                'description' => 'nullable|string|max:255'
            ], [
                'amount.required' => 'Le montant est obligatoire',
                'amount.numeric' => 'Le montant doit être un nombre',
                'amount.not_in' => 'Le montant ne peut pas être zéro',
                'description.max' => 'La description ne peut pas dépasser 255 caractères'
            ]);

            $client = Client::where('client_id', $client_id)->firstOrFail();

            $previousBalance = $client->current_balance;
            $newBalance = $previousBalance + $validated['amount'];

            // Vérifier la limite de crédit si c'est un ajout
            if ($validated['amount'] > 0 && $newBalance > $client->credit_limit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le montant dépasserait la limite de crédit autorisée',
                    'data' => [
                        'current_balance' => number_format($client->current_balance, 2, '.', ''),
                        'credit_limit' => number_format($client->credit_limit, 2, '.', ''),
                        'available_credit' => number_format($client->credit_limit - $client->current_balance, 2, '.', ''),
                        'requested_amount' => number_format($validated['amount'], 2, '.', '')
                    ]
                ], 400);
            }

            $client->current_balance = $newBalance;
            $client->save();

            Log::info('Solde du client mis à jour', [
                'client_id' => $client_id,
                'previous_balance' => $previousBalance,
                'new_balance' => $newBalance,
                'amount' => $validated['amount']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Solde mis à jour avec succès',
                'data' => [
                    'client_id' => $client->client_id,
                    'previous_balance' => number_format($previousBalance, 2, '.', ''),
                    'new_balance' => number_format($newBalance, 2, '.', ''),
                    'amount_added' => number_format($validated['amount'], 2, '.', ''),
                    'available_credit' => number_format($client->credit_limit - $newBalance, 2, '.', ''),
                    'description' => $validated['description'] ?? null
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Client non trouvé',
                'error' => 'Aucun client ne correspond à l\'identifiant fourni'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du solde', [
                'client_id' => $client_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du solde',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur interne est survenue'
            ], 500);
        }
    }

    /**
     * Statistiques des clients
     *
     * Récupère des statistiques générales sur les clients.
     *
     * @response 200 {
     *   "success": true,
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
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des statistiques', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur interne est survenue'
            ], 500);
        }
    }

    /**
     * Rechercher des clients
     *
     * Recherche avancée de clients avec de multiples critères.
     *
     * @bodyParam query string required Terme de recherche. Example: John
     * @bodyParam fields array Champs à rechercher (name_client, email, code, city, phonenumber, ifu, name_representant, marketteur). Example: ["name_client", "email", "ifu"]
     * @bodyParam client_type_id string Filtrer par type de client. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam is_active boolean Filtrer par statut. Example: true
     * @bodyParam credit_min number Limite de crédit minimale. Example: 100000
     * @bodyParam credit_max number Limite de crédit maximale. Example: 1000000
     * @bodyParam balance_min number Solde minimal. Example: -50000
     * @bodyParam balance_max number Solde maximal. Example: 500000
     * @bodyParam reduction_min number Réduction de base minimale (%). Example: 0
     * @bodyParam reduction_max number Réduction de base maximale (%). Example: 20
     * @bodyParam page integer Page à récupérer. Example: 1
     * @bodyParam per_page integer Éléments par page. Example: 20
     *
     * @response 200 {
     *   "success": true,
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
     *       "phones": [
     *         {
     *           "id": "uuid",
     *           "phone_number": "+229 12 34 56 78",
     *           "type": "mobile",
     *           "label": "Principal"
     *         }
     *       ],
     *       "credit_limit": "500000.00",
     *       "current_balance": "150000.00",
     *       "base_reduction": "5.00",
     *       "is_active": true
     *     }
     *   ],
     *   "pagination": {
     *     "total": 1,
     *     "per_page": 20,
     *     "current_page": 1
     *   }
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "query": ["Le terme de recherche est obligatoire"]
     *   }
     * }
     */
    public function search(Request $request): JsonResponse
    {
        try {
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
            ], [
                'query.required' => 'Le terme de recherche est obligatoire',
                'query.min' => 'Le terme de recherche doit contenir au moins 1 caractère',
                'client_type_id.exists' => 'Le type de client spécifié n\'existe pas',
            ]);

            $query = Client::query();
            $searchQuery = $validated['query'];
            $searchFields = $validated['fields'] ?? ['name_client', 'email', 'code', 'ifu'];

            // Recherche dans les champs spécifiés
            $query->where(function ($q) use ($searchQuery, $searchFields) {
                foreach ($searchFields as $field) {
                    if ($field === 'phonenumber') {
                        $q->orWhereHas('phones', function ($phoneQuery) use ($searchQuery) {
                            $phoneQuery->where('phone_number', 'like', "%{$searchQuery}%");
                        });
                    } else {
                        $q->orWhere($field, 'like', "%{$searchQuery}%");
                    }
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
            $clients = $query->with(['clientType', 'phones'])
                ->orderBy('name_client')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $clients->items(),
                'pagination' => [
                    'total' => $clients->total(),
                    'per_page' => $clients->perPage(),
                    'current_page' => $clients->currentPage(),
                    'last_page' => $clients->lastPage(),
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la recherche de clients', [
                'error' => $e->getMessage(),
                'search_query' => $request->input('query')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche',
                'error' => config('app.debug') ? $e->getMessage() : 'Une erreur interne est survenue'
            ], 500);
        }
    }
}
