<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Entrepot;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

/**
 * @group Gestion des Mouvements de Stock
 * 
 
 * APIs pour gérer les mouvements de stock du système (transferts, réceptions, expéditions).
 * 
 * **Authentification requise**: Toutes les routes nécessitent un Bearer Token.
 * 
 * Pour obtenir un token, l'utilisateur doit d'abord s'authentifier via l'endpoint de connexion.
 * 
 * **Header requis pour toutes les requêtes:**
 * ```
 * Authorization: Bearer {votre_token}
 * Content-Type: application/json
 * Accept: application/json
 * ```
 * 
 * **Exemple de token:**
 * ```
 * Authorization: Bearer 1|abc123xyz456def789ghi012jkl345mno678pqr901stu234
 * ```
 * 
 * **Types de mouvements de stock:**
 * - **Transfert (transfer)**: Déplacement entre deux entrepôts
 * - **Réception (in)**: Entrée de stock depuis un fournisseur
 * - **Expédition (out)**: Sortie de stock vers un client
 * 
 * **Statuts des mouvements:**
 * - **pending**: En attente de traitement
 * - **completed**: Terminé et validé
 * - **cancelled**: Annulé
 */
class StockMovementController extends Controller
{
    /**
     * @title Lister tous les mouvements de stock
     * 
     * @authenticated
     * @group Gestion des Mouvements de Stock
     * 
     * Récupère la liste paginée de tous les mouvements de stock avec leurs détails complets.
     * Cette endpoint supporte le filtrage avancé, la recherche et le tri.
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @queryParam movement_type string Filtrer par type de mouvement Entrée (in), Sortie (out), Transfert (transfer). 
     * @queryParam statut string Filtrer par statut (pending, completed, cancelled). Example: pending
     * @queryParam entrepot_from_id string Filtrer par entrepôt source (UUID). Example: 550e8400-e29b-41d4-a716-446655440001
     * @queryParam entrepot_to_id string Filtrer par entrepôt destination (UUID). Example: 550e8400-e29b-41d4-a716-446655440002
     * @queryParam client_id string Filtrer par client (UUID). Example: 550e8400-e29b-41d4-a716-446655440101
     * @queryParam fournisseur_id string Filtrer par fournisseur (UUID). Example: 550e8400-e29b-41d4-a716-446655440100
     * @queryParam search string Rechercher par numéro de référence. Example: MV-2024
     * @queryParam date_from date Filtrer par date de début (YYYY-MM-DD). Example: 2024-01-01
     * @queryParam date_to date Filtrer par date de fin (YYYY-MM-DD). Example: 2024-12-31
     * @queryParam sort_by string Champ sur lequel trier (défaut: created_at). Example: reference
     * @queryParam sort_order string Ordre de tri: asc ou desc (défaut: desc). Example: desc
     * @queryParam per_page integer Nombre d'éléments par page (défaut: 15). Example: 20
     * 
     * @response 200 scenario="Succès" {
     *   "success": true,
     *   "data": {
     *     "data": [
     *       {
     *         "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *         "reference": "MV-2024-00001",
     *         "movement_type": "transfert",
     *         "statut": "pending"
     *       }
     *     ],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 1
     *   },
     *   "message": "Mouvements de stock récupérés avec succès"
     * }
     * 
     * @response 401 scenario="Non authentifié" {
     *   "message": "Unauthenticated."
     * }
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = StockMovement::with(['entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product']);

            if ($request->has('movement_type')) {
                $query->where('movement_type', $request->movement_type);
            }

            if ($request->has('statut')) {
                $query->where('statut', $request->statut);
            }

            if ($request->has('entrepot_from_id')) {
                $query->where('entrepot_from_id', $request->entrepot_from_id);
            }

            if ($request->has('entrepot_to_id')) {
                $query->where('entrepot_to_id', $request->entrepot_to_id);
            }

            if ($request->has('client_id')) {
                $query->where('client_id', $request->client_id);
            }

            if ($request->has('fournisseur_id')) {
                $query->where('fournisseur_id', $request->fournisseur_id);
            }

            if ($request->has('search')) {
                $query->where('reference', 'like', '%' . $request->search . '%');
            }

            if ($request->has('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            $perPage = $request->get('per_page', 15);
            $stockMovements = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $stockMovements,
                'message' => 'Mouvements de stock récupérés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des mouvements de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @title Créer un transfert de stock entre entrepôts
     * 
     * @authenticated
     * @group Gestion des Mouvements de Stock
     * 
     * Crée un nouveau mouvement de transfert de stock entre deux entrepôts différents.
     * La référence du mouvement est générée automatiquement au format MV-YYYY-XXXXX.
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @bodyParam movement_type string required Type de mouvement saisi manuellement. Example: transfert
     * @bodyParam entrepot_from_id string required UUID de l'entrepôt source. Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam entrepot_to_id string required UUID de l'entrepôt destination. Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam note string optional Note descriptive du transfert (max 1000 caractères). Example: "Transfert urgent"
     * @bodyParam details array required Tableau des produits à transférer (minimum 1). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantite": 10}]
     * @bodyParam details[].product_id string required UUID du produit. Example: 550e8400-e29b-41d4-a716-446655440003
     * @bodyParam details[].quantite integer required Quantité (minimum 1). Example: 10
     * 
     * @response 201 scenario="Transfert créé" {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440010",
     *     "reference": "MV-2024-00001",
     *     "statut": "pending"
     *   },
     *   "message": "Transfert entre entrepôts créé avec succès"
     * }
     * 
     * @response 422 scenario="Erreurs de validation" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {}
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */
    public function storeWarehouseTransfer(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'movement_type' => 'required|string|max:50',
                'entrepot_from_id' => 'required|uuid|exists:entrepots,entrepot_id',
                'entrepot_to_id' => 'required|uuid|exists:entrepots,entrepot_id|different:entrepot_from_id',
                'note' => 'nullable|string|max:1000',
                'details' => 'required|array|min:1',
                'details.*.product_id' => 'required|uuid|exists:products,product_id',
                'details.*.quantite' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $reference = $this->generateReference();

            $stockMovement = StockMovement::create([
                'stock_movement_id' => (string) Str::uuid(),
                'movement_type' => $request->movement_type,
                'reference' => $reference,
                'entrepot_from_id' => $request->entrepot_from_id,
                'entrepot_to_id' => $request->entrepot_to_id,
                'statut' => 'pending',
                'note' => $request->note,
                'user_id' => auth()->user()->user_id ?? null
            ]);

            foreach ($request->details as $detail) {
                $stockMovement->details()->create([
                    'stock_movement_detail_id' => (string) Str::uuid(),
                    'product_id' => $detail['product_id'],
                    'quantite' => $detail['quantite']
                ]);
            }

            DB::commit();

            $stockMovement->load(['entrepotFrom', 'entrepotTo', 'user', 'details.product']);

            return response()->json([
                'success' => true,
                'data' => $stockMovement,
                'message' => 'Transfert entre entrepôts créé avec succès'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du transfert',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @title Créer une réception de stock depuis un fournisseur
     * 
     * @authenticated
     * @group Gestion des Mouvements de Stock
     * 
     * Crée un nouveau mouvement de réception de marchandise en provenance d'un fournisseur.
     * Cette opération augmente le stock dans l'entrepôt de destination.
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @bodyParam movement_type string required Type de mouvement saisi manuellement. Example: entrée
     * @bodyParam fournisseur_id string required UUID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440100
     * @bodyParam entrepot_to_id string required UUID de l'entrepôt de destination. Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam note string optional Note descriptive (ex: numéro de bon de commande). Example: "Réception commande #PO-2024-001"
     * @bodyParam details array required Tableau des produits reçus (minimum 1). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantite": 50}]
     * @bodyParam details[].product_id string required UUID du produit. Example: 550e8400-e29b-41d4-a716-446655440003
     * @bodyParam details[].quantite integer required Quantité reçue (minimum 1). Example: 50
     * 
     * @response 201 scenario="Réception créée" {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440020",
     *     "reference": "MV-2024-00002",
     *     "statut": "pending"
     *   },
     *   "message": "Réception de fournisseur créée avec succès"
     * }
     * 
     * @response 422 scenario="Erreurs de validation" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {}
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */
    public function storeSupplierReceipt(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'movement_type' => 'required|string|max:50',
                'fournisseur_id' => 'required|uuid|exists:fournisseurs,fournisseur_id',
                'entrepot_to_id' => 'required|uuid|exists:entrepots,entrepot_id',
                'note' => 'nullable|string|max:1000',
                'details' => 'required|array|min:1',
                'details.*.product_id' => 'required|uuid|exists:products,product_id',
                'details.*.quantite' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $reference = $this->generateReference();

            $stockMovement = StockMovement::create([
                'stock_movement_id' => (string) Str::uuid(),
                'reference' => $reference,
                'movement_type' => $request->movement_type,
                'fournisseur_id' => $request->fournisseur_id,
                'entrepot_to_id' => $request->entrepot_to_id,
                'statut' => 'pending',
                'note' => $request->note,
                'user_id' => auth()->user()->user_id ?? null
            ]);

            foreach ($request->details as $detail) {
                $stockMovement->details()->create([
                    'stock_movement_detail_id' => (string) Str::uuid(),
                    'product_id' => $detail['product_id'],
                    'quantite' => $detail['quantite']
                ]);
            }

            DB::commit();

            $stockMovement->load(['entrepotTo', 'fournisseur', 'user', 'details.product']);

            return response()->json([
                'success' => true,
                'data' => $stockMovement,
                'message' => 'Réception de fournisseur créée avec succès'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la réception',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @title Créer un mouvement de stock générique
     * 
     * @authenticated
     * @group Gestion des Mouvements de Stock
     * 
     * Crée un mouvement de stock avec des paramètres flexibles. Il est recommandé d'utiliser
     *@Description les endpoints spécialisés (`storeWarehouseTransfer` ou `storeSupplierReceipt`) pour plus de clarté.
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @bodyParam movement_type string required  nom du mouvement saisi manuellement. Example: Entré
     * @bodyParam entrepot_from_id string optional UUID de l'entrepôt source. Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam entrepot_to_id string optional UUID de l'entrepôt destination. Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam fournisseur_id string optional UUID du fournisseur. Example: 550e8400-e29b-41d4-a716-446655440100
     * @bodyParam client_id string optional UUID du client. Example: 550e8400-e29b-41d4-a716-446655440101
     * @bodyParam note string optional Note descriptive (max 1000 caractères). Example: "Mouvement standard"
     * @bodyParam details array required Tableau des produits (minimum 1). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantite": 20}]
     * @bodyParam details[].product_id string required UUID du produit. Example: 550e8400-e29b-41d4-a716-446655440003
     * @bodyParam details[].quantite integer required Quantité (minimum 1). Example: 20
     * 
     * @response 201 scenario="Mouvement créé" {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *     "reference": "MV-2024-00003",
     *     "statut": "pending"
     *   },
     *   "message": "Mouvement de stock créé avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'movement_type' => 'nullable|string|max:20',
                'entrepot_from_id' => 'nullable|exists:entrepots,entrepot_id',
                'entrepot_to_id' => 'nullable|exists:entrepots,entrepot_id',
                'fournisseur_id' => 'nullable|exists:fournisseurs,fournisseur_id',
                'client_id' => 'nullable|exists:clients,client_id',
                'note' => 'nullable|string|max:1000',
                'details' => 'required|array|min:1',
                'details.*.product_id' => 'required|exists:products,product_id',
                'details.*.quantite' => 'required|integer|min:1'
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
                $reference = $this->generateReference();

                $stockMovement = StockMovement::create([
                    'stock_movement_id' => (string) Str::uuid(),
                    'reference' => $reference,
                    'movement_type' => $request->movement_type,
                    'entrepot_from_id' => $request->entrepot_from_id,
                    'entrepot_to_id' => $request->entrepot_to_id,
                    'fournisseur_id' => $request->fournisseur_id,
                    'client_id' => $request->client_id,
                    'statut' => 'pending',
                    'note' => $request->note,
                    'user_id' => auth()->user()->user_id ?? null
                ]);

                foreach ($request->details as $detail) {
                    $stockMovement->details()->create([
                        'stock_movement_detail_id' => (string) Str::uuid(),
                        'product_id' => $detail['product_id'],
                        'quantite' => $detail['quantite']
                    ]);
                }

                DB::commit();

                $stockMovement->load(['entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product']);

                return response()->json([
                    'success' => true,
                    'data' => $stockMovement,
                    'message' => 'Mouvement de stock créé avec succès'
                ], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @title Afficher un mouvement de stock par ID
     * 
     * @authenticated
     * @group Gestion des Mouvements de Stock
     * 
     * Récupère les détails complets d'un mouvement de stock spécifique avec toutes ses relations.
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du mouvement. Example: 550e8400-e29b-41d4-a716-446655440030
     * 
     * @response 200 scenario="Succès" {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *     "reference": "MV-2024-00003",
     *     "statut": "pending"
     *   },
     *   "message": "Mouvement de stock récupéré avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */
    public function show(string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::with(['entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product'])
                ->find($id);

            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $stockMovement,
                'message' => 'Mouvement de stock récupéré avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @title Mettre à jour un mouvement de stock (remplacement complet)
     * 
     * @authenticated
     * @group Gestion des Mouvements de Stock
     * 
     * Met à jour complètement un mouvement de stock (PUT). Remplace tous les champs et détails.
     * 
     * @header Authorization required Bearer Token. Example: Bearer 1|abc123xyz456
     * @header Content-Type required application/json
     * @header Accept required application/json
     * 
     * @urlParam id string required UUID du mouvement. Example: 550e8400-e29b-41d4-a716-446655440030
     * 
     * @bodyParam movement_type string 
     * @bodyParam entrepot_from_id string optional UUID source. Example: 550e8400-e29b-41d4-a716-446655440001
     * @bodyParam entrepot_to_id string optional UUID destination. Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam fournisseur_id string optional UUID fournisseur. Example: 550e8400-e29b-41d4-a716-446655440100
     * @bodyParam client_id string optional UUID client. Example: 550e8400-e29b-41d4-a716-446655440101
     * @bodyParam statut string required Statut (pending, completed, cancelled). Example: pending
     * @bodyParam note string optional Note. Example: "Note mise à jour"
     * @bodyParam details array required Nouveaux détails (minimum 1). Example: [{"product_id": "550e8400-e29b-41d4-a716-446655440003", "quantite": 15}]
     * @bodyParam details[].product_id string required UUID produit. Example: 550e8400-e29b-41d4-a716-446655440003
     * @bodyParam details[].quantite integer required Quantité (minimum 1). Example: 15
     * 
     * @response 200 scenario="Succès" {
     *   "success": true,
     *   "data": {},
     *   "message": "Mouvement de stock mis à jour avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::find($id);

            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'movement_type' => 'nullable|string|max:20',
                'entrepot_from_id' => 'nullable|exists:entrepots,entrepot_id',
                'entrepot_to_id' => 'nullable|exists:entrepots,entrepot_id',
                'fournisseur_id' => 'nullable|exists:fournisseurs,fournisseur_id',
                'client_id' => 'nullable|exists:clients,client_id',
                'statut' => 'required|in:pending,completed,cancelled',
                'note' => 'nullable|string|max:1000',
                'details' => 'required|array|min:1',
                'details.*.product_id' => 'required|exists:products,product_id',
                'details.*.quantite' => 'required|integer|min:1'
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
                $stockMovement->update([
                    'movement_type' => $request->movement_type,
                    'entrepot_from_id' => $request->entrepot_from_id,
                    'entrepot_to_id' => $request->entrepot_to_id,
                    'fournisseur_id' => $request->fournisseur_id,
                    'client_id' => $request->client_id,
                    'statut' => $request->statut,
                    'note' => $request->note
                ]);

                $stockMovement->details()->delete();

                foreach ($request->details as $detail) {
                    $stockMovement->details()->create([
                        'stock_movement_detail_id' => (string) Str::uuid(),
                        'product_id' => $detail['product_id'],
                        'quantite' => $detail['quantite']
                    ]);
                }

                DB::commit();

                $stockMovement->load(['entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product']);

                return response()->json([
                    'success' => true,
                    'data' => $stockMovement,
                    'message' => 'Mouvement de stock mis à jour avec succès'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     *@title Met à jour uniquement le statut d'un mouvement de stock
     * 
     *@description Cette endpoint est dédiée au changement de statut sans modifier les autres données.
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @urlParam id string required UUID du mouvement de stock. Example: 550e8400-e29b-41d4-a716-446655440030
     * @bodyParam statut string required Nouveau statut (pending, completed, cancelled). Example: completed
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *     "reference": "MV-2024-00003",
     *     "statut": "completed",
     *     "details": []
     *   },
     *   "message": "Statut du mouvement de stock mis à jour avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     */
    public function updateStatus(Request $request, string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::find($id);

            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'statut' => 'required|in:pending,completed,cancelled'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $stockMovement->update(['statut' => $request->statut]);

            $stockMovement->load(['entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product']);

            return response()->json([
                'success' => true,
                'data' => $stockMovement,
                'message' => 'Statut du mouvement de stock mis à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     * @title Supprime logiquement un mouvement de stock (soft delete)
     * 
     * @description Le mouvement n'est pas physiquement supprimé de la base de données, mais marqué comme supprimé avec un timestamp deleted_at.
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @urlParam id string required UUID du mouvement de stock à supprimer. Example: 550e8400-e29b-41d4-a716-446655440030
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Mouvement de stock supprimé avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::find($id);

            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            $stockMovement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mouvement de stock supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     *  @title Restaure un mouvement de stock supprimé
     * 
     * Récupère un mouvement qui a été supprimé via soft delete.
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @urlParam id string required UUID du mouvement de stock à restaurer. Example: 550e8400-e29b-41d4-a716-446655440030
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "stock_movement_id": "550e8400-e29b-41d4-a716-446655440030",
     *     "reference": "MV-2024-00003",
     *     "deleted_at": null
     *   },
     *   "message": "Mouvement de stock restauré avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Mouvement de stock non trouvé"
     * }
     */
    public function restore(string $id): JsonResponse
    {
        try {
            $stockMovement = StockMovement::withTrashed()->find($id);

            if (!$stockMovement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mouvement de stock non trouvé'
                ], 404);
            }

            if (!$stockMovement->trashed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce mouvement de stock n\'est pas supprimé'
                ], 400);
            }

            $stockMovement->restore();

            $stockMovement->load(['entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product']);

            return response()->json([
                'success' => true,
                'data' => $stockMovement,
                'message' => 'Mouvement de stock restauré avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration du mouvement de stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @group Stock Movements
     * @authenticated
     * 
     *  @title Récupère la liste des mouvements de stock supprimés
     * 
     * Retourne tous les mouvements marqués comme supprimés (soft delete).
     * 
     * @header Authorization required Bearer token. Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "data": [],
     *     "current_page": 1,
     *     "per_page": 15,
     *     "total": 0
     *   },
     *   "message": "Mouvements de stock supprimés récupérés avec succès"
     * }
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */
    public function trashed(): JsonResponse
    {
        try {
            $stockMovements = StockMovement::onlyTrashed()
                ->with(['entrepotFrom', 'entrepotTo', 'client', 'user', 'fournisseur', 'details.product'])
                ->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $stockMovements,
                'message' => 'Mouvements de stock supprimés récupérés avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des mouvements de stock supprimés',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Génère une référence unique pour le mouvement au format MV-YYYY-XXXXX
     */
    private function generateReference(): string
    {
        $year = date('Y');
        $prefix = "MV-{$year}-";

        $lastMovement = StockMovement::where('reference', 'like', "{$prefix}%")
            ->orderBy('reference', 'desc')
            ->first();

        if ($lastMovement) {
            $lastNumber = (int) substr($lastMovement->reference, strlen($prefix));
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return $prefix . $newNumber;
    }
}
