<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryDetail;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @group Gestion des Détails de Livraison
 * 
 * API pour gérer les détails des livraisons (produits).
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class DeliveryDetailController extends Controller
{
    /**
     * Liste des détails de livraisons
     * 
     * @authenticated
     * 
     * @queryParam delivery_id string Filtrer par livraison. Example: uuid
     * @queryParam product_id string Filtrer par produit. Example: uuid
     * @queryParam statut string Filtrer par statut. Example: pret
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = DeliveryDetail::with([
            'delivery:delivery_id,reference,statut',
            'product:product_id,code,name,unit_price'
        ]);

        // Filtres
        if ($request->filled('delivery_id')) {
            $query->where('delivery_id', $request->delivery_id);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $details = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Ajouter des informations calculées
        $details->getCollection()->transform(function ($detail) {
            $detail->taux_livraison = $detail->taux_livraison;
            $detail->has_ecart = $detail->hasEcart();
            return $detail;
        });

        return response()->json([
            'success' => true,
            'message' => 'Liste des détails de livraison récupérée avec succès',
            'data' => $details
        ]);
    }

    /**
     * Afficher un détail
     * 
     * @authenticated
     */
    public function show(string $id): JsonResponse
    {
        $detail = DeliveryDetail::with([
            'delivery',
            'product',
            'detailVente'
        ])->find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de livraison non trouvé'
            ], 404);
        }

        $data = $detail->toArray();
        $data['taux_livraison'] = $detail->taux_livraison;
        $data['has_ecart'] = $detail->hasEcart();
        $data['is_fully_delivered'] = $detail->isFullyDelivered();

        return response()->json([
            'success' => true,
            'message' => 'Détail de livraison récupéré avec succès',
            'data' => $data
        ]);
    }

    /**
     * Préparer un produit
     * 
     * Marque une quantité comme préparée pour la livraison.
     * 
     * @authenticated
     * 
     * @bodyParam quantite integer required Quantité préparée. Example: 10
     * @bodyParam note string Note. Example: Produit préparé
     */
    public function preparer(Request $request, string $id): JsonResponse
    {
        $detail = DeliveryDetail::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de livraison non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantite' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->quantite > $detail->quantite_commandee) {
            return response()->json([
                'success' => false,
                'message' => 'La quantité préparée ne peut pas dépasser la quantité commandée'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $detail->quantite_preparee = $request->quantite;
            if ($request->filled('note')) {
                $detail->note = $request->note;
            }
            $detail->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Produit préparé avec succès',
                'data' => $detail->fresh(['delivery', 'product'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la préparation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Livrer un produit
     * 
     * Enregistre la quantité livrée pour un produit.
     * 
     * @authenticated
     * 
     * @bodyParam quantite integer required Quantité livrée. Example: 10
     * @bodyParam observation string Observation si écart. Example: 2 produits endommagés
     */
    public function livrer(Request $request, string $id): JsonResponse
    {
        $detail = DeliveryDetail::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de livraison non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantite' => 'required|integer|min:0',
            'observation' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->quantite > $detail->quantite_preparee) {
            return response()->json([
                'success' => false,
                'message' => 'La quantité livrée ne peut pas dépasser la quantité préparée'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $detail->livrer($request->quantite, $request->observation);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Produit livré avec succès',
                'data' => $detail->fresh(['delivery', 'product'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la livraison',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retourner un produit
     * 
     * Enregistre un retour de produit.
     * 
     * @authenticated
     * 
     * @bodyParam quantite integer required Quantité retournée. Example: 2
     * @bodyParam raison string required Raison du retour. Example: Produits endommagés
     */
    public function retourner(Request $request, string $id): JsonResponse
    {
        $detail = DeliveryDetail::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de livraison non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantite' => 'required|integer|min:1',
            'raison' => 'required|string',
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
            $detail->retourner($request->quantite, $request->raison);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Retour enregistré avec succès',
                'data' => $detail->fresh(['delivery', 'product'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement du retour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour un détail
     * 
     * @authenticated
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $detail = DeliveryDetail::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Détail de livraison non trouvé'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantite_preparee' => 'sometimes|integer|min:0',
            'quantite_livree' => 'sometimes|integer|min:0',
            'quantite_retournee' => 'sometimes|integer|min:0',
            'note' => 'nullable|string',
            'raison_ecart' => 'nullable|string',
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
            'message' => 'Détail mis à jour avec succès',
            'data' => $detail->fresh(['delivery', 'product'])
        ]);
    }

    /**
     * Détails par livraison
     * 
     * Récupère tous les détails d'une livraison spécifique.
     * 
     * @authenticated
     */
    public function detailsParLivraison(string $deliveryId): JsonResponse
    {
        $delivery = Delivery::find($deliveryId);

        if (!$delivery) {
            return response()->json([
                'success' => false,
                'message' => 'Livraison non trouvée'
            ], 404);
        }

        $details = DeliveryDetail::where('delivery_id', $deliveryId)
            ->with('product:product_id,code,name,unit_price')
            ->get();

        // Ajouter des informations calculées
        $details->transform(function ($detail) {
            $detail->taux_livraison = $detail->taux_livraison;
            $detail->has_ecart = $detail->hasEcart();
            return $detail;
        });

        return response()->json([
            'success' => true,
            'message' => 'Détails de la livraison récupérés avec succès',
            'data' => [
                'delivery' => [
                    'delivery_id' => $delivery->delivery_id,
                    'reference' => $delivery->reference,
                    'statut' => $delivery->statut,
                ],
                'details' => $details,
                'totaux' => [
                    'quantite_commandee' => $details->sum('quantite_commandee'),
                    'quantite_preparee' => $details->sum('quantite_preparee'),
                    'quantite_livree' => $details->sum('quantite_livree'),
                    'quantite_retournee' => $details->sum('quantite_retournee'),
                ]
            ]
        ]);
    }

    /**
     * Préparer tous les produits d'une livraison
     * 
     * Marque tous les produits d'une livraison comme préparés avec leur quantité commandée.
     * 
     * @authenticated
     */
    public function preparerTout(string $deliveryId): JsonResponse
    {
        $delivery = Delivery::find($deliveryId);

        if (!$delivery) {
            return response()->json([
                'success' => false,
                'message' => 'Livraison non trouvée'
            ], 404);
        }

        if ($delivery->statut !== 'en_preparation') {
            return response()->json([
                'success' => false,
                'message' => 'La livraison doit être en préparation'
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Préparer tous les détails
            $delivery->deliveryDetails()->update([
                'quantite_preparee' => DB::raw('quantite_commandee'),
                'statut' => 'pret'
            ]);

            // Mettre à jour le statut de la livraison
            $delivery->statut = 'prete';
            $delivery->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tous les produits ont été préparés',
                'data' => $delivery->fresh(['deliveryDetails.product'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la préparation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
