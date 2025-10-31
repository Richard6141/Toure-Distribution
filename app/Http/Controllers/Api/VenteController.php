<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\DetailVente;
use App\Models\Product;
use App\Models\Vente;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @group Gestion des Ventes
 * 
 * API pour gérer les ventes aux clients avec mise à jour automatique des stocks.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class VenteController extends Controller
{
    /**
     * Liste des ventes
     * 
     * Récupère la liste paginée de toutes les ventes avec leurs clients.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * @queryParam search string Rechercher par numéro de vente. Example: VTE-2025-001
     * @queryParam client_id string Filtrer par ID du client. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @queryParam entrepot_id string Filtrer par ID de l'entrepôt. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @queryParam status string Filtrer par statut. Example: validee
     * @queryParam statut_paiement string Filtrer par statut de paiement. Example: paye_partiellement
     * @queryParam date_debut date Filtrer par date minimum. Example: 2025-01-01
     * @queryParam date_fin date Filtrer par date maximum. Example: 2025-12-31
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des ventes récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "numero_vente": "VTE-2025-0001",
     *         "client_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "entrepot_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "date_vente": "2025-01-15T10:00:00.000000Z",
     *         "montant_total": "25000.00",
     *         "montant_net": "23750.00",
     *         "transport_price": "500.00",
     *         "status": "validee",
     *         "stock_movement_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d"
     *       }
     *     ]
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = Vente::with([
            'client:client_id,code,name_client,phonenumber,email',
            'entrepot:entrepot_id,code,name,adresse',
            'stockMovement:stock_movement_id,reference,statut'
        ]);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('numero_vente', 'like', "%{$search}%");
        }

        if ($request->filled('client_id')) {
            $query->parClient($request->input('client_id'));
        }

        if ($request->filled('entrepot_id')) {
            $query->where('entrepot_id', $request->input('entrepot_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('statut_paiement')) {
            $query->where('statut_paiement', $request->input('statut_paiement'));
        }

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->parPeriode(
                $request->input('date_debut') . ' 00:00:00',
                $request->input('date_fin') . ' 23:59:59'
            );
        } elseif ($request->filled('date_debut')) {
            $query->where('date_vente', '>=', $request->input('date_debut') . ' 00:00:00');
        } elseif ($request->filled('date_fin')) {
            $query->where('date_vente', '<=', $request->input('date_fin') . ' 23:59:59');
        }

        $ventes = $query->orderBy('date_vente', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des ventes récupérée avec succès',
            'data' => $ventes
        ]);
    }

    /**
     * Créer une vente
     * 
     * Enregistre une nouvelle vente avec ses détails.
     * Si la vente est créée avec le statut "validee", les stocks sont automatiquement mis à jour
     * et le current_balance du client est augmenté du montant de la vente.
     * 
     * **Options de validation automatique:**
     * - Si `status` est "validee", un mouvement de stock est créé et validé automatiquement
     * - Le stock de l'entrepôt source est diminué en temps réel
     * - Le current_balance du client est augmenté du montant_net de la vente
     * - Vérification de la limite de crédit du client (credit_limit)
     * - Si le stock est insuffisant ou la limite de crédit dépassée, la création échoue
     * 
     * @authenticated
     * 
     * @bodyParam client_id string required L'UUID du client. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam entrepot_id string required L'UUID de l'entrepôt source. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c
     * @bodyParam date_vente datetime required La date et heure de la vente. Example: 2025-01-15 10:00:00
     * @bodyParam remise numeric La remise globale. Example: 1250.00
     * @bodyParam transport_price numeric Le prix du transport. Example: 500.00
     * @bodyParam status string Le statut (en_attente par défaut, validee pour mise à jour automatique des stocks). Example: validee
     * @bodyParam note string Des notes. Example: Vente avec remise spéciale
     * @bodyParam details array required Les détails de la vente. Example: [{"product_id": "uuid", "quantite": 10, "prix_unitaire": 2500}]
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "Vente créée avec succès et stocks mis à jour",
     *   "data": {
     *     "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_vente": "VTE-2025-0001",
     *     "transport_price": "500.00",
     *     "stock_movement_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *     "status": "validee"
     *   }
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Stock insuffisant pour le produit Produit A. Disponible: 5, Demandé: 10"
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Limite de crédit dépassée pour le client ABC. Limite: 100000, Solde actuel: 80000, Montant de la vente: 25000"
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|uuid|exists:clients,client_id',
            'entrepot_id' => 'required|uuid|exists:entrepots,entrepot_id',
            'date_vente' => 'required|date',
            'remise' => 'nullable|numeric|min:0',
            'transport_price' => 'nullable|numeric|min:0',
            'status' => ['nullable', Rule::in([
                'en_attente',
                'validee',
                'livree',
                'partiellement_livree',
                'annulee'
            ])],
            'note' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|uuid|exists:products,product_id',
            'details.*.quantite' => 'required|integer|min:1',
            'details.*.prix_unitaire' => 'required|numeric|min:0',
            'details.*.remise_ligne' => 'nullable|numeric|min:0',
            'details.*.taux_taxe' => 'nullable|numeric|min:0|max:100',
        ], [
            'client_id.required' => 'Le client est requis',
            'client_id.exists' => 'Le client sélectionné n\'existe pas',
            'entrepot_id.required' => 'L\'entrepôt source est requis',
            'entrepot_id.exists' => 'L\'entrepôt sélectionné n\'existe pas',
            'date_vente.required' => 'La date de vente est requise',
            'details.required' => 'Les détails de la vente sont requis',
            'details.min' => 'Au moins un produit est requis',
            'transport_price.numeric' => 'Le prix du transport doit être un nombre',
            'transport_price.min' => 'Le prix du transport ne peut pas être négatif',
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
            $montantHT = 0;
            $montantTaxe = 0;
            $montantTotal = 0;

            foreach ($request->details as $detail) {
                $qte = $detail['quantite'];
                $pu = $detail['prix_unitaire'];
                $remiseLigne = $detail['remise_ligne'] ?? 0;
                $tauxTaxe = $detail['taux_taxe'] ?? 0;

                $ht = ($qte * $pu) - $remiseLigne;
                $taxe = $ht * ($tauxTaxe / 100);

                $montantHT += $ht;
                $montantTaxe += $taxe;
                $montantTotal += $ht + $taxe;
            }

            $remise = $request->input('remise', 0);
            $transportPrice = $request->input('transport_price', 0);
            $montantNet = $montantTotal - $remise + $transportPrice;

            $status = $request->input('status', 'en_attente');

            // Vérifications si statut = validee
            if ($status) {
                $client = Client::find($request->client_id);

                // Vérifier la limite de crédit
                if (($client->current_balance + $montantNet) > $client->credit_limit) {
                    throw new \Exception(
                        "Limite de crédit dépassée pour le client {$client->name_client}. " .
                            "Limite: {$client->credit_limit}, " .
                            "Solde actuel: {$client->current_balance}, " .
                            "Montant de la vente: {$montantNet}"
                    );
                }

                // Vérifier le stock
                foreach ($request->details as $detail) {
                    $stock = Stock::where('product_id', $detail['product_id'])
                        ->where('entrepot_id', $request->entrepot_id)
                        ->first();

                    $disponible = $stock ? ($stock->quantite - $stock->reserved_quantity) : 0;

                    if ($disponible < $detail['quantite']) {
                        $product = Product::find($detail['product_id']);
                        throw new \Exception(
                            "Stock insuffisant pour le produit {$product->name}. " .
                                "Disponible: {$disponible}, Demandé: {$detail['quantite']}"
                        );
                    }
                }
            }

            $vente = Vente::create([
                'client_id' => $request->client_id,
                'entrepot_id' => $request->entrepot_id,
                'date_vente' => $request->date_vente,
                'montant_ht' => $montantHT,
                'montant_taxe' => $montantTaxe,
                'montant_total' => $montantTotal,
                'remise' => $remise,
                'transport_price' => $transportPrice,
                'montant_net' => $montantNet,
                'status' => $status,
                'note' => $request->note,
            ]);

            foreach ($request->details as $detail) {
                $qte = $detail['quantite'];
                $pu = $detail['prix_unitaire'];
                $remiseLigne = $detail['remise_ligne'] ?? 0;
                $tauxTaxe = $detail['taux_taxe'] ?? 0;

                $ht = ($qte * $pu) - $remiseLigne;
                $taxe = $ht * ($tauxTaxe / 100);
                $total = $ht + $taxe;

                DetailVente::create([
                    'vente_id' => $vente->vente_id,
                    'product_id' => $detail['product_id'],
                    'quantite' => $qte,
                    'prix_unitaire' => $pu,
                    'remise_ligne' => $remiseLigne,
                    'taux_taxe' => $tauxTaxe,
                    'montant_ht' => $ht,
                    'montant_taxe' => $taxe,
                    'montant_total' => $total,
                ]);
            }

            if ($status) {
                $vente->createStockMovementIfNeeded();

                // Mettre à jour le current_balance du client
                $client = Client::find($vente->client_id);
                $client->current_balance += $vente->montant_net;
                $client->save();
            }

            $vente->load([
                'client:client_id,code,name_client',
                'entrepot:entrepot_id,code,name',
                'detailVentes.product:product_id,code,name',
                'stockMovement:stock_movement_id,reference,statut'
            ]);

            DB::commit();

            $message = $status === 'validee'
                ? 'Vente créée avec succès et stocks mis à jour'
                : 'Vente créée avec succès';

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $vente
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher une vente
     * 
     * Récupère les détails complets d'une vente.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détails de la vente récupérés avec succès",
     *   "data": {
     *     "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_vente": "VTE-2025-0001",
     *     "montant_total": "25000.00",
     *     "montant_net": "23750.00",
     *     "montant_paye": "10000.00",
     *     "montant_restant": "13750.00"
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Vente non trouvée"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $vente = Vente::with([
            'client',
            'entrepot',
            'detailVentes.product:product_id,code,name,unit_price',
            'paiements',
            'stockMovement.details.product'
        ])->find($id);

        if (!$vente) {
            return response()->json([
                'success' => false,
                'message' => 'Vente non trouvée'
            ], 404);
        }

        $data = $vente->toArray();
        $data['montant_paye'] = $vente->montant_paye;
        $data['montant_restant'] = $vente->montant_restant;

        return response()->json([
            'success' => true,
            'message' => 'Détails de la vente récupérés avec succès',
            'data' => $data
        ]);
    }

    /**
     * Mettre à jour une vente
     * 
     * Met à jour les informations d'une vente.
     * 
     * **Important:** 
     * - Si le statut passe à "validee", les stocks seront mis à jour automatiquement et le current_balance du client sera augmenté
     * - Si le statut passe à "annulee", le mouvement de stock sera annulé, les stocks restaurés et le current_balance du client sera diminué
     * - Si le transport_price est modifié sur une vente validée, le current_balance du client sera ajusté en conséquence
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam status string Le statut de la vente. Example: validee
     * @bodyParam transport_price numeric Le prix du transport. Example: 500.00
     * @bodyParam note string Des notes. Example: Livraison effectuée
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Vente mise à jour avec succès",
     *   "data": {}
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Stock insuffisant pour valider cette vente"
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Limite de crédit dépassée pour le client ABC"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $vente = Vente::find($id);

        if (!$vente) {
            return response()->json([
                'success' => false,
                'message' => 'Vente non trouvée'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => ['sometimes', Rule::in([
                'en_attente',
                'validee',
                'livree',
                'partiellement_livree',
                'annulee'
            ])],
            'transport_price' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
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
            $oldStatus = $vente->status;
            $oldMontantNet = $vente->montant_net;

            // Recalculer montant_net si transport_price modifié
            if ($request->has('transport_price')) {
                $vente->montant_net = $vente->montant_total - $vente->remise + $request->transport_price;
            }

            // Vérifications si passage à validee
            if (
                $request->has('status') &&
                $request->status === 'validee' &&
                $oldStatus !== 'validee' &&
                !$vente->stock_movement_id
            ) {
                $client = Client::find($vente->client_id);

                // Vérifier limite de crédit
                if (($client->current_balance + $vente->montant_net) > $client->credit_limit) {
                    throw new \Exception(
                        "Limite de crédit dépassée pour le client {$client->name_client}"
                    );
                }

                // Vérifier stock
                foreach ($vente->detailVentes as $detail) {
                    $stock = Stock::where('product_id', $detail->product_id)
                        ->where('entrepot_id', $vente->entrepot_id)
                        ->first();

                    $disponible = $stock ? ($stock->quantite - $stock->reserved_quantity) : 0;

                    if ($disponible < $detail->quantite) {
                        throw new \Exception(
                            "Stock insuffisant pour le produit {$detail->product->name}. " .
                                "Disponible: {$disponible}, Demandé: {$detail->quantite}"
                        );
                    }
                }
            }

            $vente->update($validator->validated());

            $client = Client::find($vente->client_id);

            // Passage à validee
            if ($request->has('status') && $request->status === 'validee' && $oldStatus !== 'validee') {
                $client->current_balance += $vente->montant_net;
                $client->save();
            }

            // Passage à annulee depuis validee
            if ($request->has('status') && $request->status === 'annulee' && $oldStatus === 'validee') {
                $client->current_balance -= $oldMontantNet;
                $client->save();
            }

            // Modification du montant_net sur vente validée
            if ($request->has('transport_price') && $vente->status === 'validee' && $oldStatus === 'validee') {
                $difference = $vente->montant_net - $oldMontantNet;
                $client->current_balance += $difference;
                $client->save();
            }

            $vente->load([
                'client:client_id,code,name_client',
                'entrepot:entrepot_id,code,name',
                'stockMovement:stock_movement_id,reference,statut'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vente mise à jour avec succès',
                'data' => $vente
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une vente
     * 
     * Effectue une suppression logique d'une vente.
     * Si la vente est validée, le mouvement de stock sera annulé, les stocks restaurés
     * et le current_balance du client sera diminué du montant de la vente.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Vente supprimée avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Vente non trouvée"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $vente = Vente::find($id);
        if (!$vente) {
            return response()->json([
                'success' => false,
                'message' => 'Vente non trouvée'
            ], 404);
        }

        // Vérifier le statut de la vente
        if ($vente->status !== 'en_attente') {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer une vente validée, livrée ou annulée',
                'hint' => 'Seules les ventes en attente peuvent être supprimées. Statut actuel : ' . $vente->status
            ], 422);
        }

        // ✅ Changez paiementVentes() en paiements()
        if ($vente->paiements()->where('statut', 'valide')->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer une vente avec des paiements validés',
                'hint' => 'Veuillez d\'abord annuler tous les paiements associés'
            ], 422);
        }

        // Vérifier s'il y a des livraisons en cours
        if ($vente->deliveries()->whereNotIn('statut', ['annulee'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer une vente avec des livraisons en cours',
                'hint' => 'Veuillez d\'abord annuler toutes les livraisons associées'
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Retirer du current_balance si vente validée
            if ($vente->status) {
                $client = Client::find($vente->client_id);
                $client->current_balance -= $vente->montant_net;
                $client->save();
            }

            $vente->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vente supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la vente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Liste des ventes supprimées
     * 
     * Récupère la liste paginée de toutes les ventes supprimées (soft deleted).
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des ventes supprimées récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": []
     *   }
     * }
     */
    public function trashed(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $ventes = Vente::onlyTrashed()
            ->with('client:client_id,code,name_client')
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des ventes supprimées récupérée avec succès',
            'data' => $ventes
        ]);
    }

    /**
     * Restaurer une vente supprimée
     * 
     * Restaure une vente supprimée logiquement.
     * Si la vente était validée, le current_balance du client sera restauré.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente supprimée. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Vente restaurée avec succès",
     *   "data": {}
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Vente supprimée non trouvée"
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $vente = Vente::onlyTrashed()->find($id);

        if (!$vente) {
            return response()->json([
                'success' => false,
                'message' => 'Vente supprimée non trouvée'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $vente->restore();

            // Restaurer le current_balance si la vente était validée
            if ($vente->status === 'validee') {
                $client = Client::find($vente->client_id);
                $client->current_balance += $vente->montant_net;
                $client->save();
            }

            $vente->load('client:client_id,code,name_client');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vente restaurée avec succès',
                'data' => $vente
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
