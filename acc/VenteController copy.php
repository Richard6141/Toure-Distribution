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

        // Recherche
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('numero_vente', 'like', "%{$search}%");
        }

        // Filtres
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

        // Période
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
     * Si la vente est créée avec le statut "validee", les stocks sont automatiquement mis à jour.
     * 
     * **Options de validation automatique:**
     * - Si `status` est "validee", un mouvement de stock est créé et validé automatiquement
     * - Le stock de l'entrepôt source est diminué en temps réel
     * - Si le stock est insuffisant, la création échoue
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
            // Vérifier la disponibilité du stock si statut = validee
            $status = $request->input('status', 'en_attente');
            if ($status === 'validee') {
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

            // Calculer les totaux
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

            // Montant net = Montant total - Remise + Frais de transport
            $montantNet = $montantTotal - $remise + $transportPrice;

            // Créer la vente
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

            // Créer les détails
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

            // Si statut validee, créer le mouvement de stock
            if ($status === 'validee') {
                $vente->createStockMovementIfNeeded();
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
     * **Important:** Si le statut passe à "validee", les stocks seront mis à jour automatiquement.
     * Si le statut passe à "annulee", le mouvement de stock sera annulé et les stocks restaurés.
     * 
     * @authenticated
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
            // Vérifier le stock si passage à validee
            if (
                $request->has('status') &&
                $request->status === 'validee' &&
                $vente->status !== 'validee' &&
                !$vente->stock_movement_id
            ) {

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

            // Si transport_price est modifié, recalculer le montant_net
            if ($request->has('transport_price')) {
                $oldTransportPrice = $vente->transport_price;
                $newTransportPrice = $request->transport_price;

                // Recalculer montant_net: montant_net = montant_total - remise + transport_price
                $vente->montant_net = $vente->montant_total - $vente->remise + $newTransportPrice;
            }

            $vente->update($validator->validated());

            // Le hook updated() du modèle gère automatiquement
            // la création/annulation du mouvement de stock

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
     * Si la vente est validée, le mouvement de stock sera annulé et les stocks restaurés.
     * 
     * @authenticated
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

        DB::beginTransaction();
        try {
            // Le hook deleting() du modèle annule automatiquement
            // le mouvement de stock si nécessaire
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

        $vente->restore();
        $vente->load('client:client_id,code,name_client');

        return response()->json([
            'success' => true,
            'message' => 'Vente restaurée avec succès',
            'data' => $vente
        ]);
    }
}
