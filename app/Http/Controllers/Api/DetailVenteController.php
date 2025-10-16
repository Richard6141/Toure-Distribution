<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailVente;
use App\Models\Product;
use App\Models\Vente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @group Gestion des Détails de Ventes
 * 
 * API pour gérer les lignes de détails des ventes (produits vendus).
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class DetailVenteController extends Controller
{
    /**
     * Liste des détails de ventes
     * 
     * Récupère la liste paginée de tous les détails de ventes avec leurs produits.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * @queryParam vente_id string Filtrer par ID de vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @queryParam product_id string Filtrer par ID de produit. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des détails de ventes récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "detail_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "remise_ligne": "0.00",
     *         "montant_ht": "25000.00",
     *         "taux_taxe": "18.00",
     *         "montant_taxe": "4500.00",
     *         "montant_ttc": "29500.00",
     *         "vente": {
     *           "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *           "numero_vente": "VTE-2025-0001"
     *         },
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *           "code": "PROD001",
     *           "name": "Produit A"
     *         }
     *       }
     *     ],
     *     "total": 25
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = DetailVente::with([
            'vente:vente_id,numero_vente,date_vente',
            'product:product_id,code,name,unit_price'
        ]);

        // Filtrer par vente
        if ($request->filled('vente_id')) {
            $query->where('vente_id', $request->input('vente_id'));
        }

        // Filtrer par produit
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        $details = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des détails de ventes récupérée avec succès',
            'data' => $details
        ]);
    }

    /**
     * Créer un détail de vente
     * 
     * Ajoute une ligne de produit à une vente existante.
     * Les montants sont calculés automatiquement.
     * 
     * @authenticated
     * 
     * @bodyParam vente_id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam product_id string required L'UUID du produit. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c
     * @bodyParam quantite integer required La quantité vendue. Example: 10
     * @bodyParam prix_unitaire numeric required Le prix unitaire. Example: 2500.00
     * @bodyParam remise_ligne numeric La remise sur la ligne. Example: 0
     * @bodyParam taux_taxe numeric Le taux de taxe en %. Example: 18
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "Détail de vente créé avec succès",
     *   "data": {
     *     "detail_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *     "quantite": 10,
     *     "prix_unitaire": "2500.00",
     *     "remise_ligne": "0.00",
     *     "montant_ht": "25000.00",
     *     "taux_taxe": "18.00",
     *     "montant_taxe": "4500.00",
     *     "montant_ttc": "29500.00",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "vente": {
     *       "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_vente": "VTE-2025-0001",
     *       "montant_total": "54500.00"
     *     }
     *   }
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "product_id": [
     *       "Le produit sélectionné n'existe pas"
     *     ]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'vente_id' => 'required|uuid|exists:ventes,vente_id',
            'product_id' => 'required|uuid|exists:products,product_id',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0|max:999999999.99',
            'remise_ligne' => 'nullable|numeric|min:0',
            'taux_taxe' => 'nullable|numeric|min:0|max:100',
        ], [
            'vente_id.required' => 'La vente est requise',
            'vente_id.exists' => 'La vente sélectionnée n\'existe pas',
            'product_id.required' => 'Le produit est requis',
            'product_id.exists' => 'Le produit sélectionné n\'existe pas',
            'quantite.required' => 'La quantité est requise',
            'quantite.min' => 'La quantité doit être au moins 1',
            'prix_unitaire.required' => 'Le prix unitaire est requis',
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
            // Créer le détail (les montants sont calculés automatiquement dans le modèle)
            $detail = DetailVente::create($validator->validated());

            // Recalculer les totaux de la vente
            $this->recalculerTotauxVente($detail->vente_id);

            $detail->load(['vente:vente_id,numero_vente,montant_total,montant_net', 'product:product_id,code,name']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Détail de vente créé avec succès',
                'data' => $detail
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du détail de vente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Créer plusieurs détails de vente
     * 
     * Ajoute plusieurs lignes de produits à une vente existante en une seule opération.
     * Les montants sont calculés automatiquement pour chaque ligne.
     * Les totaux de la vente sont recalculés une seule fois à la fin.
     * 
     * @authenticated
     * 
     * @bodyParam vente_id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam details array required Les détails de la vente (produits). Example: [{"product_id": "uuid", "quantite": 10, "prix_unitaire": 2500, "remise_ligne": 0, "taux_taxe": 18}]
     * @bodyParam details[].product_id string required L'UUID du produit. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c
     * @bodyParam details[].quantite integer required La quantité vendue. Example: 10
     * @bodyParam details[].prix_unitaire numeric required Le prix unitaire. Example: 2500.00
     * @bodyParam details[].remise_ligne numeric La remise sur la ligne. Example: 0
     * @bodyParam details[].taux_taxe numeric Le taux de taxe en %. Example: 18
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "3 détails de vente créés avec succès",
     *   "data": {
     *     "vente": {
     *       "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_vente": "VTE-2025-0001",
     *       "montant_total": "79000.00",
     *       "montant_net": "75050.00"
     *     },
     *     "details": [
     *       {
     *         "detail_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "remise_ligne": "0.00",
     *         "montant_ht": "25000.00",
     *         "taux_taxe": "18.00",
     *         "montant_taxe": "4500.00",
     *         "montant_ttc": "29500.00",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *           "code": "PROD001",
     *           "name": "Produit A"
     *         }
     *       },
     *       {
     *         "detail_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *         "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2e",
     *         "quantite": 5,
     *         "prix_unitaire": "3500.00",
     *         "remise_ligne": "500.00",
     *         "montant_ht": "17000.00",
     *         "taux_taxe": "18.00",
     *         "montant_taxe": "3060.00",
     *         "montant_ttc": "20060.00",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2e",
     *           "code": "PROD002",
     *           "name": "Produit B"
     *         }
     *       },
     *       {
     *         "detail_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2f",
     *         "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3a",
     *         "quantite": 8,
     *         "prix_unitaire": "1800.00",
     *         "remise_ligne": "200.00",
     *         "montant_ht": "14200.00",
     *         "taux_taxe": "18.00",
     *         "montant_taxe": "2556.00",
     *         "montant_ttc": "16756.00",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3a",
     *           "code": "PROD003",
     *           "name": "Produit C"
     *         }
     *       }
     *     ]
     *   }
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "vente_id": [
     *       "La vente sélectionnée n'existe pas"
     *     ],
     *     "details.1.product_id": [
     *       "Le produit sélectionné n'existe pas"
     *     ],
     *     "details.2.quantite": [
     *       "La quantité doit être au moins 1"
     *     ]
     *   }
     * }
     */
    public function storeMultiple(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'vente_id' => 'required|uuid|exists:ventes,vente_id',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|uuid|exists:products,product_id',
            'details.*.quantite' => 'required|integer|min:1',
            'details.*.prix_unitaire' => 'required|numeric|min:0|max:999999999.99',
            'details.*.remise_ligne' => 'nullable|numeric|min:0',
            'details.*.taux_taxe' => 'nullable|numeric|min:0|max:100',
        ], [
            'vente_id.required' => 'La vente est requise',
            'vente_id.exists' => 'La vente sélectionnée n\'existe pas',
            'details.required' => 'Les détails sont requis',
            'details.min' => 'Au moins un détail est requis',
            'details.*.product_id.required' => 'Le produit est requis',
            'details.*.product_id.exists' => 'Le produit sélectionné n\'existe pas',
            'details.*.quantite.required' => 'La quantité est requise',
            'details.*.quantite.min' => 'La quantité doit être au moins 1',
            'details.*.prix_unitaire.required' => 'Le prix unitaire est requis',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Vérifier que la vente existe
        $vente = Vente::find($request->vente_id);
        if (!$vente) {
            return response()->json([
                'success' => false,
                'message' => 'Vente non trouvée'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $detailsCreated = [];

            // Créer tous les détails
            foreach ($request->details as $detailData) {
                $detail = DetailVente::create([
                    'vente_id' => $request->vente_id,
                    'product_id' => $detailData['product_id'],
                    'quantite' => $detailData['quantite'],
                    'prix_unitaire' => $detailData['prix_unitaire'],
                    'remise_ligne' => $detailData['remise_ligne'] ?? 0,
                    'taux_taxe' => $detailData['taux_taxe'] ?? 0,
                ]);

                $detail->load('product:product_id,code,name,unit_price');
                $detailsCreated[] = $detail;
            }

            // Recalculer les totaux de la vente une seule fois
            $this->recalculerTotauxVente($request->vente_id);

            // Rafraîchir la vente pour obtenir les nouveaux totaux
            $vente->refresh();

            DB::commit();

            $count = count($detailsCreated);
            $message = $count > 1
                ? "{$count} détails de vente créés avec succès"
                : "Détail de vente créé avec succès";

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'vente' => [
                        'vente_id' => $vente->vente_id,
                        'numero_vente' => $vente->numero_vente,
                        'montant_total' => $vente->montant_total,
                        'montant_net' => $vente->montant_net,
                        'montant_ht' => $vente->montant_ht,
                        'montant_taxe' => $vente->montant_taxe,
                    ],
                    'details' => $detailsCreated,
                    'count' => $count
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création des détails de vente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un détail de vente
     * 
     * Récupère les détails d'une ligne de vente spécifique.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du détail de vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détails du détail de vente récupérés avec succès",
     *   "data": {
     *     "detail_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *     "quantite": 10,
     *     "prix_unitaire": "2500.00",
     *     "montant_ht": "25000.00",
     *     "montant_ttc": "29500.00",
     *     "vente": {
     *       "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_vente": "VTE-2025-0001",
     *       "date_vente": "2025-01-15T10:00:00.000000Z"
     *     },
     *     "product": {
     *       "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *       "code": "PROD001",
     *       "name": "Produit A",
     *       "unit_price": "2500.00"
     *     }
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Détail de vente non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $detail = DetailVente::with([
            'vente:vente_id,numero_vente,date_vente,montant_total',
            'product:product_id,code,name,unit_price'
        ])->find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de vente non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Détails du détail de vente récupérés avec succès',
            'data' => $detail
        ]);
    }

    /**
     * Mettre à jour un détail de vente
     * 
     * Met à jour une ligne de vente existante.
     * Les montants sont recalculés automatiquement.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du détail de vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam quantite integer La quantité vendue. Example: 15
     * @bodyParam prix_unitaire numeric Le prix unitaire. Example: 2300.00
     * @bodyParam remise_ligne numeric La remise sur la ligne. Example: 500.00
     * @bodyParam taux_taxe numeric Le taux de taxe en %. Example: 18
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détail de vente mis à jour avec succès",
     *   "data": {
     *     "detail_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "quantite": 15,
     *     "prix_unitaire": "2300.00",
     *     "remise_ligne": "500.00",
     *     "montant_ttc": "40270.00",
     *     "updated_at": "2025-01-15T14:30:00.000000Z"
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Détail de vente non trouvé"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $detail = DetailVente::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de vente non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantite' => 'sometimes|required|integer|min:1',
            'prix_unitaire' => 'sometimes|required|numeric|min:0|max:999999999.99',
            'remise_ligne' => 'nullable|numeric|min:0',
            'taux_taxe' => 'nullable|numeric|min:0|max:100',
        ], [
            'quantite.required' => 'La quantité est requise',
            'quantite.min' => 'La quantité doit être au moins 1',
            'prix_unitaire.required' => 'Le prix unitaire est requis',
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
            // Mettre à jour le détail (les montants sont recalculés automatiquement)
            $detail->update($validator->validated());

            // Recalculer les totaux de la vente
            $this->recalculerTotauxVente($detail->vente_id);

            $detail->load(['vente:vente_id,numero_vente,montant_total', 'product:product_id,code,name']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Détail de vente mis à jour avec succès',
                'data' => $detail->fresh(['vente', 'product'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du détail de vente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un détail de vente
     * 
     * Effectue une suppression logique (soft delete) d'une ligne de vente.
     * Les totaux de la vente sont recalculés automatiquement.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du détail de vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détail de vente supprimé avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Détail de vente non trouvé"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $detail = DetailVente::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de vente non trouvé'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $venteId = $detail->vente_id;
            $detail->delete();

            // Recalculer les totaux de la vente
            $this->recalculerTotauxVente($venteId);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Détail de vente supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du détail de vente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Liste des détails supprimés
     * 
     * Récupère la liste paginée de tous les détails de ventes supprimés.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des détails de ventes supprimés récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [],
     *     "total": 0
     *   }
     * }
     */
    public function trashed(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $details = DetailVente::onlyTrashed()
            ->with([
                'vente:vente_id,numero_vente',
                'product:product_id,code,name'
            ])
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des détails de ventes supprimés récupérée avec succès',
            'data' => $details
        ]);
    }

    /**
     * Restaurer un détail de vente supprimé
     * 
     * Restaure une ligne de vente précédemment supprimée.
     * Les totaux de la vente sont recalculés automatiquement.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du détail supprimé. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détail de vente restauré avec succès",
     *   "data": {
     *     "detail_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "deleted_at": null
     *   }
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $detail = DetailVente::onlyTrashed()->find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de vente supprimé non trouvé'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $detail->restore();

            // Recalculer les totaux de la vente
            $this->recalculerTotauxVente($detail->vente_id);

            $detail->load(['vente:vente_id,numero_vente', 'product:product_id,code,name']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Détail de vente restauré avec succès',
                'data' => $detail->fresh(['vente', 'product'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la restauration du détail de vente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Détails d'une vente
     * 
     * Récupère tous les détails (lignes) associés à une vente spécifique.
     * 
     * @authenticated
     * 
     * @urlParam vente_id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détails de la vente récupérés avec succès",
     *   "data": {
     *     "vente": {
     *       "vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_vente": "VTE-2025-0001",
     *       "montant_total": "54500.00",
     *       "montant_net": "52000.00"
     *     },
     *     "details": [
     *       {
     *         "detail_vente_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "montant_ttc": "29500.00",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *           "code": "PROD001",
     *           "name": "Produit A"
     *         }
     *       }
     *     ]
     *   }
     * }
     */
    public function detailsParVente(string $venteId): JsonResponse
    {
        $vente = Vente::find($venteId);

        if (!$vente) {
            return response()->json([
                'success' => false,
                'message' => 'Vente non trouvée'
            ], 404);
        }

        $details = DetailVente::where('vente_id', $venteId)
            ->with('product:product_id,code,name,unit_price')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Détails de la vente récupérés avec succès',
            'data' => [
                'vente' => [
                    'vente_id' => $vente->vente_id,
                    'numero_vente' => $vente->numero_vente,
                    'montant_total' => $vente->montant_total,
                    'montant_net' => $vente->montant_net,
                ],
                'details' => $details
            ]
        ]);
    }

    /**
     * Recalcule les totaux d'une vente après modification des détails
     */
    private function recalculerTotauxVente(string $venteId): void
    {
        $vente = Vente::find($venteId);

        if (!$vente) {
            return;
        }

        $details = DetailVente::where('vente_id', $venteId)->get();

        $montantHT = $details->sum('montant_ht');
        $montantTaxe = $details->sum('montant_taxe');
        $montantTotal = $details->sum('montant_ttc');

        $montantNet = $montantTotal - $vente->remise;

        $vente->update([
            'montant_ht' => $montantHT,
            'montant_taxe' => $montantTaxe,
            'montant_total' => $montantTotal,
            'montant_net' => $montantNet,
        ]);
    }
}
