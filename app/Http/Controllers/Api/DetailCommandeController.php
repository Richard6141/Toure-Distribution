<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailCommande;
use App\Models\Commande;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @group Gestion des Détails de Commandes
 * 
 * API pour gérer les lignes de produits (détails) des commandes d'achat.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class DetailCommandeController extends Controller
{
    /**
     * Liste des détails de commandes
     * 
     * Récupère la liste paginée de tous les détails de commandes avec leurs produits.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * @queryParam commande_id string Filtrer par ID de commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @queryParam product_id string Filtrer par ID de produit. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des détails de commandes récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "sous_total": "25000.00",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "commande": {
     *           "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *           "numero_commande": "CMD-2025-0001",
     *           "date_achat": "2025-01-15"
     *         },
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *           "code": "PROD001",
     *           "name": "Produit ABC",
     *           "unit_price": "2500.00"
     *         }
     *       }
     *     ],
     *     "first_page_url": "http://localhost/api/detail-commandes?page=1",
     *     "from": 1,
     *     "last_page": 2,
     *     "per_page": 15,
     *     "to": 15,
     *     "total": 30
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = DetailCommande::with([
            'commande:commande_id,numero_commande,date_achat',
            'product:product_id,code,name,unit_price'
        ]);

        // Filtrer par commande
        if ($request->filled('commande_id')) {
            $query->parCommande($request->input('commande_id'));
        }

        // Filtrer par produit
        if ($request->filled('product_id')) {
            $query->parProduit($request->input('product_id'));
        }

        $details = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des détails de commandes récupérée avec succès',
            'data' => $details
        ]);
    }

    /**
     * Liste des détails d'une commande spécifique
     * 
     * Récupère tous les détails (lignes de produits) d'une commande donnée.
     * 
     * @authenticated
     * 
     * @urlParam commandeId string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détails de la commande récupérés avec succès",
     *   "data": {
     *     "commande": {
     *       "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *       "numero_commande": "CMD-2025-0001",
     *       "date_achat": "2025-01-15",
     *       "montant": "50000.00"
     *     },
     *     "details": [
     *       {
     *         "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "sous_total": "25000.00",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *           "code": "PROD001",
     *           "name": "Produit ABC"
     *         }
     *       },
     *       {
     *         "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2e",
     *         "quantite": 5,
     *         "prix_unitaire": "5000.00",
     *         "sous_total": "25000.00",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2e",
     *           "code": "PROD002",
     *           "name": "Produit XYZ"
     *         }
     *       }
     *     ],
     *     "total": "50000.00"
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function getByCommande(string $commandeId): JsonResponse
    {
        $commande = Commande::find($commandeId);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $details = DetailCommande::with('product:product_id,code,name,unit_price')
            ->parCommande($commandeId)
            ->get();

        $total = $details->sum('sous_total');

        return response()->json([
            'success' => true,
            'message' => 'Détails de la commande récupérés avec succès',
            'data' => [
                'commande' => [
                    'commande_id' => $commande->commande_id,
                    'numero_commande' => $commande->numero_commande,
                    'date_achat' => $commande->date_achat,
                    'montant' => $commande->montant,
                ],
                'details' => $details,
                'total' => number_format($total, 2, '.', ''),
            ]
        ]);
    }

    /**
     * Créer un détail de commande
     * 
     * Ajoute une ligne de produit à une commande existante.
     * 
     * @authenticated
     * 
     * @bodyParam commande_id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @bodyParam product_id string required L'UUID du produit. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam quantite integer required La quantité commandée. Example: 10
     * @bodyParam prix_unitaire numeric required Le prix unitaire du produit. Example: 2500.00
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "Détail de commande créé avec succès",
     *   "data": {
     *     "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *     "quantite": 10,
     *     "prix_unitaire": "2500.00",
     *     "sous_total": "25000.00",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "commande": {
     *       "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_commande": "CMD-2025-0001"
     *     },
     *     "product": {
     *       "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *       "code": "PROD001",
     *       "name": "Produit ABC"
     *     }
     *   }
     * }
     * 
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "commande_id": [
     *       "La commande sélectionnée n'existe pas"
     *     ],
     *     "product_id": [
     *       "Le produit sélectionné n'existe pas"
     *     ]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'commande_id' => 'required|uuid|exists:commandes,commande_id',
            'product_id' => 'required|uuid|exists:products,product_id',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0|max:9999999999.99',
        ], [
            'commande_id.required' => 'La commande est requise',
            'commande_id.exists' => 'La commande sélectionnée n\'existe pas',
            'product_id.required' => 'Le produit est requis',
            'product_id.exists' => 'Le produit sélectionné n\'existe pas',
            'quantite.required' => 'La quantité est requise',
            'quantite.min' => 'La quantité doit être au minimum 1',
            'prix_unitaire.required' => 'Le prix unitaire est requis',
            'prix_unitaire.min' => 'Le prix unitaire doit être supérieur ou égal à 0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $detail = DetailCommande::create($validator->validated());
        $detail->load([
            'commande:commande_id,numero_commande',
            'product:product_id,code,name'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Détail de commande créé avec succès',
            'data' => $detail
        ], 201);
    }

    /**
     * Créer plusieurs détails de commande en une seule fois
     * 
     * Ajoute plusieurs lignes de produits à une commande existante.
     * 
     * @authenticated
     * 
     * @bodyParam commande_id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @bodyParam details array required Liste des détails à ajouter.
     * @bodyParam details[].product_id string required L'UUID du produit. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam details[].quantite integer required La quantité commandée. Example: 10
     * @bodyParam details[].prix_unitaire numeric required Le prix unitaire. Example: 2500.00
     * 
     * @response 201 {
     *   "success": true,
     *   "message": "3 détails de commande créés avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "details_count": 3,
     *     "total": "75000.00",
     *     "details": [
     *       {
     *         "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "sous_total": "25000.00"
     *       }
     *     ]
     *   }
     * }
     */
    public function storeMultiple(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'commande_id' => 'required|uuid|exists:commandes,commande_id',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|uuid|exists:products,product_id',
            'details.*.quantite' => 'required|integer|min:1',
            'details.*.prix_unitaire' => 'required|numeric|min:0|max:9999999999.99',
        ], [
            'commande_id.required' => 'La commande est requise',
            'commande_id.exists' => 'La commande sélectionnée n\'existe pas',
            'details.required' => 'Au moins un détail est requis',
            'details.*.product_id.required' => 'Le produit est requis pour chaque ligne',
            'details.*.product_id.exists' => 'Un ou plusieurs produits n\'existent pas',
            'details.*.quantite.required' => 'La quantité est requise pour chaque ligne',
            'details.*.quantite.min' => 'La quantité doit être au minimum 1',
            'details.*.prix_unitaire.required' => 'Le prix unitaire est requis pour chaque ligne',
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
            $commandeId = $request->input('commande_id');
            $detailsData = $request->input('details');
            $createdDetails = [];

            foreach ($detailsData as $detailData) {
                $detail = DetailCommande::create([
                    'commande_id' => $commandeId,
                    'product_id' => $detailData['product_id'],
                    'quantite' => $detailData['quantite'],
                    'prix_unitaire' => $detailData['prix_unitaire'],
                ]);
                $createdDetails[] = $detail;
            }

            DB::commit();

            $total = collect($createdDetails)->sum('sous_total');

            return response()->json([
                'success' => true,
                'message' => count($createdDetails) . ' détails de commande créés avec succès',
                'data' => [
                    'commande_id' => $commandeId,
                    'details_count' => count($createdDetails),
                    'total' => number_format($total, 2, '.', ''),
                    'details' => $createdDetails,
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création des détails',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un détail de commande
     *
     * Récupère les informations d'une ligne de commande spécifique avec tous les produits de la commande.
     *
     * @authenticated
     *
     * @urlParam id string required L'UUID du détail de commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Détail de commande récupéré avec succès",
     *   "data": {
     *     "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *     "quantite": 10,
     *     "prix_unitaire": "2500.00",
     *     "sous_total": "25000.00",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "commande": {
     *       "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "numero_commande": "CMD-2025-0001",
     *       "date_achat": "2025-01-15",
     *       "details": [
     *         {
     *           "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *           "quantite": 10,
     *           "prix_unitaire": "2500.00",
     *           "sous_total": "25000.00",
     *           "product": {
     *             "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *             "code": "PROD001",
     *             "name": "Produit ABC",
     *             "unit_price": "2500.00"
     *           }
     *         },
     *         {
     *           "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2e",
     *           "quantite": 5,
     *           "prix_unitaire": "5000.00",
     *           "sous_total": "25000.00",
     *           "product": {
     *             "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2e",
     *             "code": "PROD002",
     *             "name": "Produit XYZ",
     *             "unit_price": "5000.00"
     *           }
     *         }
     *       ]
     *     },
     *     "product": {
     *       "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *       "code": "PROD001",
     *       "name": "Produit ABC",
     *       "unit_price": "2500.00"
     *     }
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Détail de commande non trouvé"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $detail = DetailCommande::with([
            'commande' => function ($query) {
                $query->select('commande_id', 'numero_commande', 'date_achat')
                    ->with(['details.product:product_id,code,name,unit_price']);
            },
            'product:product_id,code,name,unit_price'
        ])->find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de commande non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Détail de commande récupéré avec succès',
            'data' => $detail
        ]);
    }

    /**
     * Mettre à jour un détail de commande
     * 
     * Modifie la quantité ou le prix unitaire d'une ligne de commande.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du détail de commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam quantite integer La quantité commandée. Example: 15
     * @bodyParam prix_unitaire numeric Le prix unitaire du produit. Example: 2300.00
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détail de commande mis à jour avec succès",
     *   "data": {
     *     "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *     "quantite": 15,
     *     "prix_unitaire": "2300.00",
     *     "sous_total": "34500.00",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T14:30:00.000000Z"
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Détail de commande non trouvé"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $detail = DetailCommande::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de commande non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantite' => 'sometimes|required|integer|min:1',
            'prix_unitaire' => 'sometimes|required|numeric|min:0|max:9999999999.99',
        ], [
            'quantite.required' => 'La quantité est requise',
            'quantite.min' => 'La quantité doit être au minimum 1',
            'prix_unitaire.required' => 'Le prix unitaire est requis',
            'prix_unitaire.min' => 'Le prix unitaire doit être supérieur ou égal à 0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $detail->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Détail de commande mis à jour avec succès',
            'data' => $detail->fresh()
        ]);
    }

    /**
     * Supprimer un détail de commande
     * 
     * Effectue une suppression logique (soft delete) d'une ligne de commande.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du détail de commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détail de commande supprimé avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Détail de commande non trouvé"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $detail = DetailCommande::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de commande non trouvé'
            ], 404);
        }

        $detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Détail de commande supprimé avec succès'
        ]);
    }

    /**
     * Liste des détails supprimés
     * 
     * Récupère la liste paginée de tous les détails de commandes supprimés.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des détails supprimés récupérée avec succès",
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

        $details = DetailCommande::onlyTrashed()
            ->with([
                'commande:commande_id,numero_commande',
                'product:product_id,code,name'
            ])
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des détails supprimés récupérée avec succès',
            'data' => $details
        ]);
    }

    /**
     * Restaurer un détail supprimé
     * 
     * Restaure un détail de commande précédemment supprimé.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID du détail supprimé. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détail de commande restauré avec succès",
     *   "data": {
     *     "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *     "quantite": 10,
     *     "prix_unitaire": "2500.00",
     *     "sous_total": "25000.00",
     *     "deleted_at": null
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Détail supprimé non trouvé"
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $detail = DetailCommande::onlyTrashed()->find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail supprimé non trouvé'
            ], 404);
        }

        $detail->restore();

        return response()->json([
            'success' => true,
            'message' => 'Détail de commande restauré avec succès',
            'data' => $detail->fresh()
        ]);
    }
}
