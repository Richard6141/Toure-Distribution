<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\DeliveryDetail;
use App\Models\Vente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * @group Gestion des Livraisons
 * 
 * API pour gérer les livraisons aux clients.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class DeliveryController extends Controller
{
    /**
     * Liste des livraisons
     * 
     * Récupère la liste paginée de toutes les livraisons.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * @queryParam search string Rechercher par référence. Example: LIV-2025-001
     * @queryParam statut string Filtrer par statut. Example: en_transit
     * @queryParam chauffeur_id string Filtrer par chauffeur. Example: uuid
     * @queryParam date_debut date Filtrer par date minimum. Example: 2025-01-01
     * @queryParam date_fin date Filtrer par date maximum. Example: 2025-12-31
     * @queryParam en_retard boolean Afficher uniquement les livraisons en retard. Example: true
     * @queryParam aujourdhui boolean Afficher uniquement les livraisons du jour. Example: true
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = Delivery::with([
            'vente:vente_id,numero_vente,montant_net',
            'client:client_id,code,name_client,phonenumber',
            'entrepot:entrepot_id,code,name',
            'chauffeur:chauffeur_id,nom,prenom,telephone',
            'camion:camion_id,immatriculation,marque,modele',
        ]);

        // Recherche
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('reference', 'like', "%{$search}%");
        }

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        if ($request->filled('chauffeur_id')) {
            $query->parChauffeur($request->input('chauffeur_id'));
        }

        if ($request->filled('vente_id')) {
            $query->where('vente_id', $request->input('vente_id'));
        }

        // Période
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->parPeriode($request->input('date_debut'), $request->input('date_fin'));
        } elseif ($request->filled('date_debut')) {
            $query->where('date_livraison_prevue', '>=', $request->input('date_debut'));
        } elseif ($request->filled('date_fin')) {
            $query->where('date_livraison_prevue', '<=', $request->input('date_fin'));
        }

        // Aujourd'hui
        if ($request->boolean('aujourdhui')) {
            $query->aujourdhui();
        }

        // En retard
        if ($request->boolean('en_retard')) {
            $query->enRetard();
        }

        $deliveries = $query->orderBy('date_livraison_prevue', 'desc')->paginate($perPage);

        // Ajouter des informations calculées
        $deliveries->getCollection()->transform(function ($delivery) {
            $delivery->is_late = $delivery->isLate();
            $delivery->completion_rate = $delivery->completion_rate;
            return $delivery;
        });

        return response()->json([
            'success' => true,
            'message' => 'Liste des livraisons récupérée avec succès',
            'data' => $deliveries
        ]);
    }

    /**
     * Créer une livraison
     * 
     * Crée une nouvelle livraison à partir d'une vente validée.
     * Les détails de livraison sont créés automatiquement à partir des détails de vente.
     * 
     * @authenticated
     * 
     * @bodyParam vente_id string required L'UUID de la vente. Example: uuid
     * @bodyParam entrepot_id string required L'UUID de l'entrepôt source. Example: uuid
     * @bodyParam chauffeur_id string L'UUID du chauffeur. Example: uuid
     * @bodyParam camion_id string L'UUID du camion. Example: uuid
     * @bodyParam date_livraison_prevue datetime Date de livraison prévue. Example: 2025-01-20 14:00:00
     * @bodyParam adresse_livraison string Adresse de livraison. Example: 123 Rue Example
     * @bodyParam contact_livraison string Contact sur place. Example: Jean Dupont
     * @bodyParam telephone_livraison string Téléphone du contact. Example: +229 97 00 00 00
     * @bodyParam note string Notes. Example: Livraison urgente
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'vente_id' => 'required|uuid|exists:ventes,vente_id',
            'entrepot_id' => 'required|uuid|exists:entrepots,entrepot_id',
            'chauffeur_id' => 'nullable|uuid|exists:chauffeurs,chauffeur_id',
            'camion_id' => 'nullable|uuid|exists:camions,camion_id',
            'date_livraison_prevue' => 'nullable|date',
            'adresse_livraison' => 'nullable|string|max:500',
            'contact_livraison' => 'nullable|string|max:100',
            'telephone_livraison' => 'nullable|string|max:20',
            'note' => 'nullable|string',
        ], [
            'vente_id.required' => 'La vente est requise',
            'vente_id.exists' => 'La vente sélectionnée n\'existe pas',
            'entrepot_id.required' => 'L\'entrepôt source est requis',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Vérifier que la vente est validée
        $vente = Vente::with('detailVentes.product')->find($request->vente_id);
        if ($vente->status !== 'validee') {
            return response()->json([
                'success' => false,
                'message' => 'La vente doit être validée pour créer une livraison'
            ], 422);
        }

        // Vérifier si une livraison n'existe pas déjà pour cette vente
        $existingDelivery = Delivery::where('vente_id', $request->vente_id)
            ->whereNotIn('statut', ['annulee'])
            ->first();

        if ($existingDelivery) {
            return response()->json([
                'success' => false,
                'message' => 'Une livraison existe déjà pour cette vente',
                'data' => $existingDelivery
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Créer la livraison
            $delivery = Delivery::create([
                'vente_id' => $request->vente_id,
                'client_id' => $vente->client_id,
                'entrepot_id' => $request->entrepot_id,
                'chauffeur_id' => $request->chauffeur_id,
                'camion_id' => $request->camion_id,
                'date_livraison_prevue' => $request->date_livraison_prevue ?? now()->addDay(),
                'adresse_livraison' => $request->adresse_livraison ?? $vente->client->adresse,
                'contact_livraison' => $request->contact_livraison ?? $vente->client->name_client,
                'telephone_livraison' => $request->telephone_livraison ?? $vente->client->phonenumber,
                'note' => $request->note,
                'statut' => 'en_preparation',
                'created_by' => auth()->user()->user_id ?? null,
            ]);

            // Créer les détails de livraison à partir des détails de vente
            foreach ($vente->detailVentes as $detailVente) {
                DeliveryDetail::create([
                    'delivery_id' => $delivery->delivery_id,
                    'product_id' => $detailVente->product_id,
                    'detail_vente_id' => $detailVente->detail_vente_id,
                    'quantite_commandee' => $detailVente->quantite,
                    'quantite_preparee' => 0,
                    'quantite_livree' => 0,
                    'quantite_retournee' => 0,
                    'statut' => 'en_attente',
                    'poids' => $detailVente->product->poids ?? null,
                    'volume' => $detailVente->product->volume ?? null,
                ]);
            }

            $delivery->load([
                'vente',
                'client',
                'entrepot',
                'chauffeur',
                'camion',
                'deliveryDetails.product'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Livraison créée avec succès',
                'data' => $delivery
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la livraison',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher une livraison
     * 
     * Récupère les détails complets d'une livraison.
     * 
     * @authenticated
     */
    public function show(string $id): JsonResponse
    {
        $delivery = Delivery::with([
            'vente.detailVentes.product',
            'client',
            'entrepot',
            'chauffeur',
            'camion',
            'createdBy:user_id,name,email',
            'deliveryDetails.product',
            'deliveryDetails.detailVente'
        ])->find($id);

        if (!$delivery) {
            return response()->json([
                'success' => false,
                'message' => 'Livraison non trouvée'
            ], 404);
        }

        // Ajouter des informations calculées
        $data = $delivery->toArray();
        $data['is_late'] = $delivery->isLate();
        $data['completion_rate'] = $delivery->completion_rate;
        $data['all_products_ready'] = $delivery->allProductsReady();

        return response()->json([
            'success' => true,
            'message' => 'Détails de la livraison récupérés avec succès',
            'data' => $data
        ]);
    }

    /**
     * Mettre à jour une livraison
     * 
     * Met à jour les informations d'une livraison.
     * 
     * @authenticated
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json([
                'success' => false,
                'message' => 'Livraison non trouvée'
            ], 404);
        }

        // Ne peut pas modifier une livraison livrée ou annulée
        if (in_array($delivery->statut, ['livree', 'annulee'])) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de modifier une livraison livrée ou annulée'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'chauffeur_id' => 'nullable|uuid|exists:chauffeurs,chauffeur_id',
            'camion_id' => 'nullable|uuid|exists:camions,camion_id',
            'date_livraison_prevue' => 'nullable|date',
            'adresse_livraison' => 'nullable|string|max:500',
            'contact_livraison' => 'nullable|string|max:100',
            'telephone_livraison' => 'nullable|string|max:20',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $delivery->update($validator->validated());
        $delivery->load(['chauffeur', 'camion']);

        return response()->json([
            'success' => true,
            'message' => 'Livraison mise à jour avec succès',
            'data' => $delivery
        ]);
    }

    /**
     * Démarrer une livraison
     * 
     * Passe le statut à "en_transit" et enregistre l'heure de départ.
     * 
     * @authenticated
     */
    public function startDelivery(string $id): JsonResponse
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json([
                'success' => false,
                'message' => 'Livraison non trouvée'
            ], 404);
        }

        if ($delivery->statut !== 'prete') {
            return response()->json([
                'success' => false,
                'message' => 'La livraison doit être prête pour démarrer'
            ], 422);
        }

        try {
            $delivery->startDelivery();

            return response()->json([
                'success' => true,
                'message' => 'Livraison démarrée avec succès',
                'data' => $delivery->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du démarrage de la livraison',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Terminer une livraison
     * 
     * Passe le statut à "livree" et enregistre les informations de livraison.
     * 
     * @authenticated
     * 
     * @bodyParam observation string Observations du chauffeur. Example: Livraison effectuée sans problème
     * @bodyParam signature_client string Chemin de la signature. Example: /signatures/sig-123.png
     * @bodyParam photos array Photos de la livraison. Example: ["/photos/photo1.jpg"]
     */
    public function completeDelivery(Request $request, string $id): JsonResponse
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json([
                'success' => false,
                'message' => 'Livraison non trouvée'
            ], 404);
        }

        if (!in_array($delivery->statut, ['en_transit', 'prete'])) {
            return response()->json([
                'success' => false,
                'message' => 'La livraison doit être en transit pour être terminée'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'observation' => 'nullable|string',
            'signature_client' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $delivery->completeDelivery($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Livraison terminée avec succès',
                'data' => $delivery->fresh(['deliveryDetails'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la finalisation de la livraison',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Annuler une livraison
     * 
     * Annule une livraison en cours.
     * 
     * @authenticated
     * 
     * @bodyParam raison string Raison de l'annulation. Example: Client indisponible
     */
    public function cancelDelivery(Request $request, string $id): JsonResponse
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json([
                'success' => false,
                'message' => 'Livraison non trouvée'
            ], 404);
        }

        if (in_array($delivery->statut, ['livree', 'annulee'])) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible d\'annuler une livraison déjà livrée ou annulée'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'raison' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $delivery->cancel($request->raison);

            return response()->json([
                'success' => true,
                'message' => 'Livraison annulée avec succès',
                'data' => $delivery->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'annulation de la livraison',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une livraison
     * 
     * Effectue une suppression logique.
     * 
     * @authenticated
     */
    public function destroy(string $id): JsonResponse
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json([
                'success' => false,
                'message' => 'Livraison non trouvée'
            ], 404);
        }

        // Annuler avant suppression si pas encore fait
        if (!in_array($delivery->statut, ['annulee'])) {
            $delivery->cancel('Suppression de la livraison');
        }

        $delivery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Livraison supprimée avec succès'
        ]);
    }

    /**
     * Statistiques des livraisons
     * 
     * @authenticated
     */
    public function statistics(Request $request): JsonResponse
    {
        $stats = [
            'total' => Delivery::count(),
            'en_preparation' => Delivery::enPreparation()->count(),
            'prete' => Delivery::prete()->count(),
            'en_transit' => Delivery::enTransit()->count(),
            'livree' => Delivery::livree()->count(),
            'en_retard' => Delivery::enRetard()->count(),
            'aujourdhui' => Delivery::aujourdhui()->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
