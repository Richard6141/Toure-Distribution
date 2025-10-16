<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\DetailVente;
use App\Models\Product;
use App\Models\Vente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @group Gestion des Ventes
 * 
 * API pour gérer les ventes aux clients.
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
     * @queryParam status string Filtrer par statut (en_attente, validee, livree, partiellement_livree, annulee). Example: validee
     * @queryParam statut_paiement string Filtrer par statut de paiement (non_paye, paye_partiellement, paye_totalement). Example: paye_partiellement
     * @queryParam date_debut date Filtrer par date minimum (format: Y-m-d). Example: 2025-01-01
     * @queryParam date_fin date Filtrer par date maximum (format: Y-m-d). Example: 2025-12-31
     * @queryParam montant_min numeric Filtrer par montant minimum. Example: 1000
     * @queryParam montant_max numeric Filtrer par montant maximum. Example: 50000
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
     *         "date_vente": "2025-01-15T10:00:00.000000Z",
     *         "montant_total": "25000.00",
     *         "montant_net": "23750.00",
     *         "remise": "1250.00",
     *         "status": "validee",
     *         "statut_paiement": "paye_partiellement",
     *         "created_at": "2025-01-15T10:00:00.000000Z",
     *         "client": {
     *           "client_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *           "code": "CLI001",
     *           "name_client": "Entreprise ABC",
     *           "phonenumber": "+229 97 00 00 00"
     *         }
     *       }
     *     ],
     *     "total": 45
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = Vente::with('client:client_id,code,name_client,phonenumber,email');

        // Recherche
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('numero_vente', 'like', "%{$search}%");
        }

        // Filtres
        if ($request->filled('client_id')) {
            $query->parClient($request->input('client_id'));
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

        // Montants
        if ($request->filled('montant_min')) {
            $query->where('montant_net', '>=', $request->input('montant_min'));
        }

        if ($request->filled('montant_max')) {
            $query->where('montant_net', '<=', $request->input('montant_max'));
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
     * Le numéro de vente est généré automatiquement au format VTE-YYYY-0001.
     * 
     * @authenticated
     * 
     * @bodyParam client_id string required L'UUID du client. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam date_vente datetime required La date et heure de la vente (format: Y-m-d H:i:s). Example: 2025-01-15 10:00:00
     * @bodyParam remise numeric La remise globale accordée. Example: 1250.00
     * @bodyParam note string Des notes ou observations. Example: Vente avec remise spéciale
     * @bodyParam details array required Les détails de la vente (produits). Example: [{"product_id": "uuid", "quantite": 10, "prix_unitaire": 2500, "remise_ligne": 0, "taux_taxe": 18}]
     * @bodyParam details[].product_id string required L'UUID du produit. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c
     * @bodyParam details[].quantite integer required La quantité vendue. Example: 10
     * @bodyParam details[].prix_unitaire numeric required Le prix unitaire. Example: 2500.00
     * @bodyParam details[].remise_ligne numeric La remise sur la ligne. Example: 0
     * @bodyParam details[].taux_taxe numeric Le taux de taxe en %. Example: 18
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "Vente créée avec succès",
     *   "data": {
     *     "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_vente": "VTE-2025-0001",
     *     "client_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "date_vente": "2025-01-15T10:00:00.000000Z",
     *     "montant_ht": "21186.44",
     *     "montant_taxe": "3813.56",
     *     "montant_total": "25000.00",
     *     "remise": "1250.00",
     *     "montant_net": "23750.00",
     *     "status": "en_attente",
     *     "statut_paiement": "non_paye",
     *     "details": [
     *       {
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "montant_ht": "21186.44",
     *         "montant_ttc": "25000.00"
     *       }
     *     ]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|uuid|exists:clients,client_id',
            'date_vente' => 'required|date',
            'remise' => 'nullable|numeric|min:0',
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
            'date_vente.required' => 'La date de vente est requise',
            'details.required' => 'Les détails de la vente sont requis',
            'details.min' => 'Au moins un produit est requis',
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
                $ttc = $ht + $taxe;

                $montantHT += $ht;
                $montantTaxe += $taxe;
                $montantTotal += $ttc;
            }

            $remise = $request->input('remise', 0);
            $montantNet = $montantTotal - $remise;

            // Créer la vente
            $vente = Vente::create([
                'client_id' => $request->client_id,
                'date_vente' => $request->date_vente,
                'montant_ht' => $montantHT,
                'montant_taxe' => $montantTaxe,
                'montant_total' => $montantTotal,
                'remise' => $remise,
                'montant_net' => $montantNet,
                'note' => $request->note,
            ]);

            // Créer les détails
            foreach ($request->details as $detail) {
                DetailVente::create([
                    'vente_id' => $vente->vente_id,
                    'product_id' => $detail['product_id'],
                    'quantite' => $detail['quantite'],
                    'prix_unitaire' => $detail['prix_unitaire'],
                    'remise_ligne' => $detail['remise_ligne'] ?? 0,
                    'taux_taxe' => $detail['taux_taxe'] ?? 0,
                ]);
            }

            $vente->load(['client:client_id,code,name_client', 'detailVentes.product:product_id,code,name']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vente créée avec succès',
                'data' => $vente
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la vente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher une vente
     * 
     * Récupère les détails complets d'une vente avec client, détails et paiements.
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
     *     "date_vente": "2025-01-15T10:00:00.000000Z",
     *     "montant_total": "25000.00",
     *     "montant_net": "23750.00",
     *     "montant_paye": "10000.00",
     *     "montant_restant": "13750.00",
     *     "status": "validee",
     *     "statut_paiement": "paye_partiellement",
     *     "client": {
     *       "client_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "code": "CLI001",
     *       "name_client": "Entreprise ABC"
     *     },
     *     "detail_ventes": [
     *       {
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "montant_ttc": "25000.00",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *           "code": "PROD001",
     *           "name": "Produit A"
     *         }
     *       }
     *     ],
     *     "paiements": [
     *       {
     *         "paiement_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *         "reference_paiement": "PAYV-2025-0001",
     *         "montant": "10000.00",
     *         "mode_paiement": "mobile_money",
     *         "date_paiement": "2025-01-15T14:00:00.000000Z"
     *       }
     *     ]
     *   }
     * }
     */
    public function show(string $id): JsonResponse
    {
        $vente = Vente::with([
            'client',
            'detailVentes.product:product_id,code,name,unit_price',
            'paiements'
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
        $data['is_totalement_payee'] = $vente->isTotalementPayee();
        $data['is_partiellement_payee'] = $vente->isPartiellementPayee();

        return response()->json([
            'success' => true,
            'message' => 'Détails de la vente récupérés avec succès',
            'data' => $data
        ]);
    }

    /**
     * Mettre à jour une vente
     * 
     * Met à jour les informations d'une vente existante.
     * Note: Le numéro de vente ne peut pas être modifié.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam status string Le statut de la vente. Example: livree
     * @bodyParam note string Des notes ou observations. Example: Livraison effectuée
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Vente mise à jour avec succès",
     *   "data": {}
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
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $vente->update($validator->validated());
        $vente->load('client:client_id,code,name_client');

        return response()->json([
            'success' => true,
            'message' => 'Vente mise à jour avec succès',
            'data' => $vente->fresh(['client'])
        ]);
    }

    /**
     * Supprimer une vente
     * 
     * Effectue une suppression logique (soft delete) d'une vente.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Vente supprimée avec succès"
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

        $vente->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vente supprimée avec succès'
        ]);
    }

    /**
     * Liste des ventes supprimées
     * 
     * @authenticated
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
     * @authenticated
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
            'data' => $vente->fresh(['client'])
        ]);
    }
}
