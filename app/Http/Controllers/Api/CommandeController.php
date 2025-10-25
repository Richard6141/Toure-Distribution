<?php

namespace App\Http\Controllers\Api;

use App\Models\Camion;
use App\Models\Product;
use App\Models\Commande;
use App\Models\Entrepot;
use App\Models\Chauffeur;
use App\Models\Fournisseur;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * @group Gestion des Commandes
 * 
 * API pour gérer les commandes d'achat auprès des fournisseurs.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class CommandeController extends Controller
{
    /**
     * Liste des commandes
     * 
     * Récupère la liste paginée de toutes les commandes avec leurs fournisseurs et produits associés.
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * @queryParam search string Rechercher par numéro de commande. Example: CMD-2025-001
     * @queryParam status string Filtrer par statut (en_attente, validee, en_cours, livree, partiellement_livree, annulee). Example: en_attente
     * @queryParam fournisseur_id string Filtrer par ID du fournisseur. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @queryParam date_achat_debut date Filtrer par date d'achat minimum (format: Y-m-d). Example: 2025-01-01
     * @queryParam date_achat_fin date Filtrer par date d'achat maximum (format: Y-m-d). Example: 2025-12-31
     * @queryParam montant_min numeric Filtrer par montant minimum. Example: 1000
     * @queryParam montant_max numeric Filtrer par montant maximum. Example: 50000
     * @queryParam en_retard boolean Afficher uniquement les commandes en retard (1 ou 0). Example: 1
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des commandes récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "numero_commande": "CMD-2025-0001",
     *         "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "date_achat": "2025-01-15",
     *         "date_livraison_prevue": "2025-02-15",
     *         "date_livraison_effective": null,
     *         "montant": "75000.00",
     *         "status": "en_attente",
     *         "note": "Commande urgente",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "fournisseur": {
     *           "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *           "code": "FOUR001",
     *           "name": "Fournisseur ABC",
     *           "email": "contact@fournisseur-abc.com",
     *           "phone": "+229 97 00 00 00"
     *         },
     *         "details": [
     *           {
     *             "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *             "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *             "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *             "quantite": 10,
     *             "prix_unitaire": "2500.00",
     *             "sous_total": "25000.00",
     *             "created_at": "2025-01-15T10:30:00.000000Z",
     *             "updated_at": "2025-01-15T10:30:00.000000Z",
     *             "product": {
     *               "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *               "code": "PROD001",
     *               "name": "Laptop Dell XPS 15",
     *               "unit_price": "2500.00",
     *               "picture": "laptop-dell-xps.jpg"
     *             }
     *           },
     *           {
     *             "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2e",
     *             "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *             "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2f",
     *             "quantite": 5,
     *             "prix_unitaire": "5000.00",
     *             "sous_total": "25000.00",
     *             "created_at": "2025-01-15T10:30:00.000000Z",
     *             "updated_at": "2025-01-15T10:30:00.000000Z",
     *             "product": {
     *               "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2f",
     *               "code": "PROD002",
     *               "name": "Imprimante HP LaserJet",
     *               "unit_price": "5000.00",
     *               "picture": "imprimante-hp.jpg"
     *             }
     *           }
     *         ]
     *       }
     *     ],
     *     "first_page_url": "http://localhost/api/commandes?page=1",
     *     "from": 1,
     *     "last_page": 3,
     *     "per_page": 15,
     *     "to": 15,
     *     "total": 45
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $query = Commande::with([
            'fournisseur:fournisseur_id,code,name,email,phone',
            'details.product:product_id,code,name,unit_price,picture'
        ]);

        // Recherche par numéro de commande
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('numero_commande', 'like', "%{$search}%");
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filtrer par fournisseur
        if ($request->filled('fournisseur_id')) {
            $query->parFournisseur($request->input('fournisseur_id'));
        }

        // Filtrer par période de dates d'achat
        if ($request->filled('date_achat_debut') && $request->filled('date_achat_fin')) {
            $query->parPeriodeAchat(
                $request->input('date_achat_debut'),
                $request->input('date_achat_fin')
            );
        } elseif ($request->filled('date_achat_debut')) {
            $query->where('date_achat', '>=', $request->input('date_achat_debut'));
        } elseif ($request->filled('date_achat_fin')) {
            $query->where('date_achat', '<=', $request->input('date_achat_fin'));
        }

        // Filtrer par montant minimum
        if ($request->filled('montant_min')) {
            $query->montantMin($request->input('montant_min'));
        }

        // Filtrer par montant maximum
        if ($request->filled('montant_max')) {
            $query->montantMax($request->input('montant_max'));
        }

        // Filtrer les commandes en retard
        if ($request->boolean('en_retard')) {
            $query->enRetard();
        }

        $commandes = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des commandes récupérée avec succès',
            'data' => $commandes
        ]);
    }

    /**
     * Créer une commande
     * 
     * Enregistre une nouvelle commande d'achat dans le système.
     * Le numéro de commande est généré automatiquement au format CMD-YYYY-0001.
     * Vous pouvez affecter un chauffeur et/ou un camion dès la création pour une livraison propre, 
     * ou laisser ces champs vides si la livraison est assurée par le fournisseur.
     * 
     * @authenticated
     * 
     * @bodyParam fournisseur_id string required L'UUID du fournisseur. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam chauffeur_id string L'UUID du chauffeur pour la livraison (optionnel - si livraison propre). Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c
     * @bodyParam camion_id string L'UUID du camion pour la livraison (optionnel - si livraison propre). Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d
     * @bodyParam date_achat date required La date d'achat (format: Y-m-d). Example: 2025-01-15
     * @bodyParam date_livraison_prevue date required La date de livraison prévue (format: Y-m-d). Example: 2025-02-15
     * @bodyParam date_livraison_effective date La date de livraison effective (format: Y-m-d). Example: 2025-02-10
     * @bodyParam montant numeric required Le montant total de la commande. Example: 75000.00
     * @bodyParam status string Le statut de la commande (en_attente, validee, en_cours, livree, partiellement_livree, annulee). Par défaut: en_attente. Example: en_attente
     * @bodyParam note string Des notes ou observations sur la commande. Example: Commande urgente - Livraison propre
     * @bodyParam details array required Liste des produits commandés (minimum 1 produit).
     * @bodyParam details[].product_id string required L'UUID du produit. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d
     * @bodyParam details[].quantite integer required La quantité commandée (minimum 1). Example: 10
     * @bodyParam details[].prix_unitaire numeric required Le prix unitaire du produit. Example: 2500.00
     * 
     * @response 201 scenario="Création réussie - Livraison fournisseur" {
     *   "success": true,
     *   "message": "Commande créée avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "chauffeur_id": null,
     *     "camion_id": null,
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "date_livraison_effective": null,
     *     "montant": "75000.00",
     *     "status": "en_attente",
     *     "note": "Commande urgente",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "fournisseur": {
     *       "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "code": "FOUR001",
     *       "name": "Fournisseur ABC",
     *       "email": "contact@fournisseur-abc.com"
     *     },
     *     "chauffeur": null,
     *     "camion": null,
     *     "details": [
     *       {
     *         "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3a",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "sous_total": "25000.00",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *           "code": "PROD001",
     *           "name": "Laptop Dell XPS 15",
     *           "unit_price": "2500.00"
     *         }
     *       },
     *       {
     *         "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3b",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2e",
     *         "quantite": 5,
     *         "prix_unitaire": "5000.00",
     *         "sous_total": "25000.00",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2e",
     *           "code": "PROD002",
     *           "name": "Imprimante HP LaserJet",
     *           "unit_price": "5000.00"
     *         }
     *       }
     *     ]
     *   }
     * }
     * 
     * @response 201 scenario="Création réussie - Livraison propre (avec chauffeur et camion)" {
     *   "success": true,
     *   "message": "Commande créée avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c",
     *     "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "date_livraison_effective": null,
     *     "montant": "75000.00",
     *     "status": "en_attente",
     *     "note": "Livraison avec notre propre chauffeur et camion",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "fournisseur": {
     *       "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "code": "FOUR001",
     *       "name": "Fournisseur ABC",
     *       "email": "contact@fournisseur-abc.com"
     *     },
     *     "chauffeur": {
     *       "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c",
     *       "name": "Jean Dupont",
     *       "phone": "+229 97 00 00 00",
     *       "numero_permis": "P-123456",
     *       "status": "actif"
     *     },
     *     "camion": {
     *       "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d",
     *       "numero_immat": "AB-1234-BJ",
     *       "marque": "Mercedes-Benz",
     *       "modele": "Actros",
     *       "capacite": "15.00",
     *       "status": "disponible"
     *     },
     *     "details": [
     *       {
     *         "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3a",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "sous_total": "25000.00",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *           "code": "PROD001",
     *           "name": "Laptop Dell XPS 15"
     *         }
     *       }
     *     ]
     *   }
     * }
     * 
     * @response 400 scenario="Chauffeur non actif" {
     *   "success": false,
     *   "message": "Le chauffeur sélectionné n'est pas actif"
     * }
     * 
     * @response 400 scenario="Camion non disponible" {
     *   "success": false,
     *   "message": "Le camion sélectionné n'est pas disponible"
     * }
     * 
     * @response 422 scenario="Erreur de validation" {
     *   "success": false,
     *   "message": "Validation échouée",
     *   "errors": {
     *     "fournisseur_id": ["Le fournisseur sélectionné n'existe pas"],
     *     "chauffeur_id": ["Le chauffeur sélectionné n'existe pas"],
     *     "details": ["Le champ details est requis et doit contenir au moins 1 produit"]
     *   }
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'fournisseur_id' => 'required|uuid|exists:fournisseurs,fournisseur_id',
            'chauffeur_id' => 'nullable|uuid|exists:chauffeurs,chauffeur_id',
            'camion_id' => 'nullable|uuid|exists:camions,camion_id',
            'date_achat' => 'required|date',
            'date_livraison_prevue' => 'required|date|after_or_equal:date_achat',
            'montant' => 'required|numeric|min:0',
            'status' => 'sometimes|in:en_attente,validee,en_cours,livree,partiellement_livree,annulee',
            'note' => 'nullable|string',
            // Détails des produits
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|uuid|exists:products,product_id',
            'details.*.quantite' => 'required|integer|min:1',
            'details.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation échouée',
                'errors' => $validator->errors()
            ], 422);
        }

        // Si un chauffeur est fourni, vérifier qu'il est actif
        if ($request->has('chauffeur_id')) {
            $chauffeur = Chauffeur::find($request->chauffeur_id);
            if ($chauffeur->status !== 'actif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Le chauffeur sélectionné n\'est pas actif'
                ], 400);
            }
        }

        // Si un camion est fourni, vérifier qu'il est disponible
        if ($request->has('camion_id')) {
            $camion = Camion::find($request->camion_id);
            if ($camion->status !== 'disponible') {
                return response()->json([
                    'success' => false,
                    'message' => 'Le camion sélectionné n\'est pas disponible'
                ], 400);
            }
        }

        // Créer la commande
        $commande = Commande::create($request->only([
            'fournisseur_id',
            'chauffeur_id',
            'camion_id',
            'date_achat',
            'date_livraison_prevue',
            'montant',
            'status',
            'note'
        ]));

        // Créer les détails de la commande
        foreach ($request->details as $detail) {
            $commande->details()->create([
                'product_id' => $detail['product_id'],
                'quantite' => $detail['quantite'],
                'prix_unitaire' => $detail['prix_unitaire'],
                'sous_total' => $detail['quantite'] * $detail['prix_unitaire']
            ]);
        }

        // Charger les relations pour la réponse
        $commande->load(['fournisseur', 'chauffeur', 'camion', 'details.product']);

        return response()->json([
            'success' => true,
            'message' => 'Commande créée avec succès',
            'data' => $commande
        ], 201);
    }
    /**
     * Afficher une commande
     * 
     * Récupère les détails d'une commande spécifique avec son fournisseur et tous ses produits.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Détails de la commande récupérés avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0001",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "date_livraison_effective": null,
     *     "montant": "75000.00",
     *     "status": "en_attente",
     *     "note": "Commande urgente",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "is_en_attente": true,
     *     "is_livree": false,
     *     "is_en_retard": false,
     *     "fournisseur": {
     *       "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "code": "FOUR001",
     *       "name": "Fournisseur ABC",
     *       "responsable": "Jean Dupont",
     *       "email": "contact@fournisseur-abc.com",
     *       "phone": "+229 97 00 00 00",
     *       "adresse": "123 Rue Principale",
     *       "city": "Cotonou"
     *     },
     *     "details": [
     *       {
     *         "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2c",
     *         "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *         "quantite": 10,
     *         "prix_unitaire": "2500.00",
     *         "sous_total": "25000.00",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2d",
     *           "code": "PROD001",
     *           "name": "Laptop Dell XPS 15",
     *           "description": "Ordinateur portable haute performance",
     *           "unit_price": "2500.00",
     *           "cost": "2000.00",
     *           "minimum_cost": "1800.00",
     *           "min_stock_level": 5,
     *           "is_active": true,
     *           "picture": "laptop-dell-xps.jpg",
     *           "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *           "created_at": "2025-01-10T08:00:00.000000Z",
     *           "updated_at": "2025-01-10T08:00:00.000000Z"
     *         }
     *       },
     *       {
     *         "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2e",
     *         "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2f",
     *         "quantite": 5,
     *         "prix_unitaire": "5000.00",
     *         "sous_total": "25000.00",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2f",
     *           "code": "PROD002",
     *           "name": "Imprimante HP LaserJet",
     *           "description": "Imprimante laser professionnelle",
     *           "unit_price": "5000.00",
     *           "cost": "4000.00",
     *           "minimum_cost": "3500.00",
     *           "min_stock_level": 3,
     *           "is_active": true,
     *           "picture": "imprimante-hp.jpg",
     *           "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *           "created_at": "2025-01-10T08:00:00.000000Z",
     *           "updated_at": "2025-01-10T08:00:00.000000Z"
     *         }
     *       },
     *       {
     *         "detail_commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f30",
     *         "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f31",
     *         "quantite": 20,
     *         "prix_unitaire": "1250.00",
     *         "sous_total": "25000.00",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "product": {
     *           "product_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f31",
     *           "code": "PROD003",
     *           "name": "Souris sans fil Logitech",
     *           "description": "Souris ergonomique sans fil",
     *           "unit_price": "1250.00",
     *           "cost": "800.00",
     *           "minimum_cost": "600.00",
     *           "min_stock_level": 20,
     *           "is_active": true,
     *           "picture": "souris-logitech.jpg",
     *           "product_category_id": "8c3e1d7a-2b4c-5d6e-7f8a-9b0c1d2e3f4b",
     *           "created_at": "2025-01-10T08:00:00.000000Z",
     *           "updated_at": "2025-01-10T08:00:00.000000Z"
     *         }
     *       }
     *     ]
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $commande = Commande::with([
            'fournisseur',
            'details.product'
        ])->find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $data = $commande->toArray();
        $data['is_en_attente'] = $commande->isEnAttente();
        $data['is_livree'] = $commande->isLivree();
        $data['is_en_retard'] = $commande->isEnRetard();

        return response()->json([
            'success' => true,
            'message' => 'Détails de la commande récupérés avec succès',
            'data' => $data
        ]);
    }


    /**
     * Mettre à jour une commande
     * 
     * Met à jour les informations d'une commande existante.
     * Note: Le numéro de commande ne peut pas être modifié.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam fournisseur_id string L'UUID du fournisseur. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b
     * @bodyParam date_achat date La date d'achat (format: Y-m-d). Example: 2025-01-15
     * @bodyParam date_livraison_prevue date La date de livraison prévue (format: Y-m-d). Example: 2025-02-15
     * @bodyParam date_livraison_effective date La date de livraison effective (format: Y-m-d). Example: 2025-02-10
     * @bodyParam montant numeric Le montant total de la commande. Example: 25000.00
     * @bodyParam status string Le statut de la commande. Example: livree
     * @bodyParam note string Des notes ou observations sur la commande. Example: Livraison effectuée avec succès
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Commande mise à jour avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0001",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "date_livraison_effective": "2025-02-10",
     *     "montant": "25000.00",
     *     "status": "livree",
     *     "note": "Livraison effectuée avec succès",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-02-10T14:30:00.000000Z",
     *     "fournisseur": {
     *       "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "code": "FOUR001",
     *       "name": "Fournisseur ABC"
     *     }
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'fournisseur_id' => 'sometimes|required|uuid|exists:fournisseurs,fournisseur_id',
            'date_achat' => 'sometimes|required|date',
            'date_livraison_prevue' => 'sometimes|required|date|after_or_equal:date_achat',
            'date_livraison_effective' => 'nullable|date',
            'montant' => 'sometimes|required|numeric|min:0|max:9999999999999.99',
            'status' => ['sometimes', Rule::in([
                'en_attente',
                'validee',
                'en_cours',
                'livree',
                'partiellement_livree',
                'annulee'
            ])],
            'note' => 'nullable|string',
        ], [
            'fournisseur_id.required' => 'Le fournisseur est requis',
            'fournisseur_id.exists' => 'Le fournisseur sélectionné n\'existe pas',
            'date_achat.required' => 'La date d\'achat est requise',
            'date_livraison_prevue.required' => 'La date de livraison prévue est requise',
            'date_livraison_prevue.after_or_equal' => 'La date de livraison doit être postérieure ou égale à la date d\'achat',
            'montant.required' => 'Le montant est requis',
            'montant.numeric' => 'Le montant doit être un nombre',
            'montant.min' => 'Le montant doit être supérieur ou égal à 0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Le numero_commande ne peut pas être modifié
        $commande->update($validator->validated());
        $commande->load('fournisseur:fournisseur_id,code,name,email,phone');

        return response()->json([
            'success' => true,
            'message' => 'Commande mise à jour avec succès',
            'data' => $commande->fresh(['fournisseur'])
        ]);
    }

    /**
     * Supprimer une commande
     * 
     * Effectue une suppression logique (soft delete) d'une commande.
     * La commande reste dans la base mais est marquée comme supprimée.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Commande supprimée avec succès"
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $commande->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commande supprimée avec succès'
        ]);
    }

    /**
     * Liste des commandes supprimées
     * 
     * Récupère la liste paginée de toutes les commandes supprimées (soft deleted).
     * 
     * @authenticated
     * 
     * @queryParam page integer Numéro de la page. Example: 1
     * @queryParam per_page integer Nombre d'éléments par page (max 100). Example: 15
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des commandes supprimées récupérée avec succès",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *         "numero_commande": "CMD-2025-0001",
     *         "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *         "date_achat": "2025-01-15",
     *         "montant": "25000.00",
     *         "status": "annulee",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "deleted_at": "2025-01-20T14:30:00.000000Z",
     *         "fournisseur": {
     *           "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *           "code": "FOUR001",
     *           "name": "Fournisseur ABC"
     *         }
     *       }
     *     ],
     *     "first_page_url": "http://localhost/api/commandes/trashed/list?page=1",
     *     "from": 1,
     *     "last_page": 1,
     *     "per_page": 15,
     *     "to": 3,
     *     "total": 3
     *   }
     * }
     */
    public function trashed(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);

        $commandes = Commande::onlyTrashed()
            ->with('fournisseur:fournisseur_id,code,name,email,phone')
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Liste des commandes supprimées récupérée avec succès',
            'data' => $commandes
        ]);
    }

    /**
     * Restaurer une commande supprimée
     * 
     * Restaure une commande précédemment supprimée (soft deleted).
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande supprimée. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Commande restaurée avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0001",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "montant": "25000.00",
     *     "status": "en_attente",
     *     "created_at": "2025-01-15T10:30:00.000000Z",
     *     "updated_at": "2025-01-15T10:30:00.000000Z",
     *     "deleted_at": null,
     *     "fournisseur": {
     *       "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *       "code": "FOUR001",
     *       "name": "Fournisseur ABC"
     *     }
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Commande supprimée non trouvée"
     * }
     */
    public function restore(string $id): JsonResponse
    {
        $commande = Commande::onlyTrashed()->find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande supprimée non trouvée'
            ], 404);
        }

        $commande->restore();
        $commande->load('fournisseur:fournisseur_id,code,name,email,phone');

        return response()->json([
            'success' => true,
            'message' => 'Commande restaurée avec succès',
            'data' => $commande->fresh(['fournisseur'])
        ]);
    }

    /**
     * Répartir une commande livrée dans les entrepôts
     * 
     * Permet au responsable de la centrale de répartir les produits d'une commande livrée
     * dans différents entrepôts selon les besoins. La répartition peut se faire en plusieurs fois.
     * 
     * **Processus automatique :**
     * - ✅ Validation que la commande est bien livrée
     * - ✅ Vérification que les produits existent dans la table products
     * - ✅ Contrôle strict des quantités (ne pas dépasser ce qui est commandé)
     * - ✅ Création automatique des stocks si le produit n'existe pas dans l'entrepôt
     * - ✅ Mise à jour automatique des stocks existants
     * - ✅ Création des mouvements de stock et de leurs détails
     * - ✅ Validation automatique des mouvements
     * 
     * @authenticated
     * 
     * @urlParam id string required UUID de la commande livrée. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam distributions array required Tableau des répartitions par entrepôt (minimum 1). Example: [{"entrepot_id": "550e...", "products": [...]}]
     * @bodyParam distributions[].entrepot_id string required UUID de l'entrepôt de destination. Example: 550e8400-e29b-41d4-a716-446655440002
     * @bodyParam distributions[].products array required Produits à transférer vers cet entrepôt (minimum 1). Example: [{"product_id": "550e...", "quantite": 50}]
     * @bodyParam distributions[].products[].product_id string required UUID du produit (doit exister dans la table products). Example: 550e8400-e29b-41d4-a716-446655440003
     * @bodyParam distributions[].products[].quantite integer required Quantité à transférer (minimum 1). Example: 50
     * @bodyParam distributions[].note string optional Note ou observation sur cette répartition. Example: "Stock prioritaire - demande urgente"
     * 
     * @response 201 scenario="Répartition réussie" {
     *   "success": true,
     *   "message": "Commande répartie avec succès dans 2 entrepôt(s)",
     *   "data": {
     *     "commande": {
     *       "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *       "numero_commande": "CMD-2025-0001",
     *       "status": "livree",
     *       "is_fully_distributed": false,
     *       "can_distribute_more": true
     *     },
     *     "stock_movements": [
     *       {
     *         "stock_movement_id": "550e8400-e29b-41d4-a716-446655440010",
     *         "reference": "MV-2025-00001",
     *         "movement_type": "réception commande",
     *         "statut": "validated",
     *         "entrepot_to": {
     *           "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *           "name": "Entrepôt Principal",
     *           "code": "ENT-001"
     *         },
     *         "details": [
     *           {
     *             "product": {
     *               "product_id": "550e8400-e29b-41d4-a716-446655440003",
     *               "name": "Produit A",
     *               "code": "PROD-001"
     *             },
     *             "quantite": 50
     *           }
     *         ]
     *       }
     *     ],
     *     "quantites_reparties": {
     *       "550e8400-e29b-41d4-a716-446655440003": 100
     *     },
     *     "quantites_restantes": {
     *       "550e8400-e29b-41d4-a716-446655440003": 0,
     *       "550e8400-e29b-41d4-a716-446655440004": 50
     *     }
     *   }
     * }
     * 
     * @response 400 scenario="Commande pas encore livrée" {
     *   "success": false,
     *   "message": "La commande doit être livrée pour être répartie",
     *   "current_status": "validee"
     * }
     * 
     * @response 400 scenario="Produit n'appartient pas à la commande" {
     *   "success": false,
     *   "message": "Le produit 'Produit XYZ' n'appartient pas à cette commande"
     * }
     * 
     * @response 400 scenario="Quantité excessive" {
     *   "success": false,
     *   "message": "Quantité excessive pour le produit 'Produit A'. Restant à répartir: 30, Demandée: 50"
     * }
     * 
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     * 
     * @response 404 scenario="Produit non trouvé" {
     *   "success": false,
     *   "message": "Le produit avec l'ID '550e...' n'existe pas dans le système"
     * }
     * 
     * @response 422 scenario="Erreurs de validation" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "distributions": ["Au moins une répartition est requise"],
     *     "distributions.0.entrepot_id": ["L'entrepôt est requis"],
     *     "distributions.0.products.0.quantite": ["La quantité doit être au minimum 1"]
     *   }
     * }
     * 
     * @response 500 scenario="Erreur serveur" {
     *   "success": false,
     *   "message": "Erreur lors de la répartition de la commande",
     *   "error": "Message d'erreur détaillé"
     * }
     */
    public function distributeToWarehouses(Request $request, string $id): JsonResponse
    {
        try {
            // 1. Récupérer la commande avec ses relations
            $commande = Commande::with(['details.product', 'fournisseur'])
                ->find($id);

            if (!$commande) {
                return response()->json([
                    'success' => false,
                    'message' => 'Commande non trouvée'
                ], 404);
            }

            // 2. Vérifier que la commande est livrée
            if (!$commande->canBeDistributed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'La commande doit être livrée pour être répartie',
                    'current_status' => $commande->status
                ], 400);
            }

            // 3. Validation des données
            $validator = Validator::make($request->all(), [
                'distributions' => 'required|array|min:1',
                'distributions.*.entrepot_id' => 'required|uuid|exists:entrepots,entrepot_id',
                'distributions.*.products' => 'required|array|min:1',
                'distributions.*.products.*.product_id' => 'required|uuid|exists:products,product_id',
                'distributions.*.products.*.quantite' => 'required|integer|min:1',
                'distributions.*.note' => 'nullable|string|max:1000',
            ], [
                'distributions.required' => 'Au moins une répartition est requise',
                'distributions.*.entrepot_id.required' => 'L\'entrepôt est requis',
                'distributions.*.entrepot_id.exists' => 'Un ou plusieurs entrepôts n\'existent pas',
                'distributions.*.products.required' => 'Au moins un produit est requis par entrepôt',
                'distributions.*.products.*.product_id.required' => 'Le produit est requis',
                'distributions.*.products.*.product_id.exists' => 'Un ou plusieurs produits n\'existent pas dans le système',
                'distributions.*.products.*.quantite.required' => 'La quantité est requise',
                'distributions.*.products.*.quantite.min' => 'La quantité doit être au minimum 1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            // 4. Récupérer les quantités restantes à répartir
            $quantitesRestantes = $commande->getQuantitesRestantes();

            // 5. Vérifier que les produits appartiennent à la commande et calculer les quantités totales
            $commandeProductIds = $commande->details->pluck('product_id')->toArray();
            $quantitesARepartir = []; // Pour suivre le total à répartir dans cette requête

            foreach ($request->distributions as $distributionIndex => $distribution) {
                foreach ($distribution['products'] as $productIndex => $product) {
                    $productId = $product['product_id'];
                    $quantite = $product['quantite'];

                    // Vérifier que le produit existe dans le système
                    $productModel = Product::find($productId);
                    if (!$productModel) {
                        return response()->json([
                            'success' => false,
                            'message' => "Le produit avec l'ID '{$productId}' n'existe pas dans le système"
                        ], 404);
                    }

                    // Vérifier que le produit fait partie de la commande
                    if (!in_array($productId, $commandeProductIds)) {
                        return response()->json([
                            'success' => false,
                            'message' => "Le produit '{$productModel->name}' n'appartient pas à cette commande"
                        ], 400);
                    }

                    // Cumuler les quantités à répartir
                    if (!isset($quantitesARepartir[$productId])) {
                        $quantitesARepartir[$productId] = 0;
                    }
                    $quantitesARepartir[$productId] += $quantite;
                }
            }

            // 6. Vérifier qu'on ne dépasse pas les quantités restantes
            foreach ($quantitesARepartir as $productId => $totalARepartir) {
                $qteRestante = $quantitesRestantes[$productId] ?? 0;

                if ($totalARepartir > $qteRestante) {
                    $productModel = Product::find($productId);

                    return response()->json([
                        'success' => false,
                        'message' => "Quantité excessive pour le produit '{$productModel->name}'. " .
                            "Restant à répartir: {$qteRestante}, Demandée: {$totalARepartir}"
                    ], 400);
                }
            }

            DB::beginTransaction();

            $createdMovements = [];

            // 7. Créer un mouvement de stock pour chaque entrepôt
            foreach ($request->distributions as $distribution) {
                $entrepotId = $distribution['entrepot_id'];
                $note = $distribution['note'] ?? null;

                // Générer la référence du mouvement
                $reference = $this->generateStockMovementReference();

                // Récupérer l'entrepôt pour enrichir la note
                $entrepot = Entrepot::find($entrepotId);
                $entrepotName = $entrepot ? $entrepot->name : 'Entrepôt';

                // Créer le mouvement de stock
                $stockMovement = StockMovement::create([
                    'stock_movement_id' => (string) Str::uuid(),
                    'reference' => $reference,
                    'movement_type' => 'réception commande',
                    'fournisseur_id' => $commande->fournisseur_id,
                    'commande_id' => $commande->commande_id,
                    'entrepot_to_id' => $entrepotId,
                    'statut' => 'pending',
                    'note' => $note ?? "Répartition de la commande {$commande->numero_commande} vers {$entrepotName}",
                    'user_id' => auth()->user()->user_id ?? null
                ]);

                // 8. Créer les détails du mouvement
                foreach ($distribution['products'] as $product) {
                    $productId = $product['product_id'];
                    $quantite = $product['quantite'];

                    $stockMovement->details()->create([
                        'stock_movement_detail_id' => (string) Str::uuid(),
                        'product_id' => $productId,
                        'quantite' => $quantite
                    ]);
                }

                // 9. VALIDATION AUTOMATIQUE du mouvement
                // Cela déclenche automatiquement la mise à jour/création des stocks
                $stockMovement->validate();

                // Charger les relations pour la réponse
                $stockMovement->load([
                    'entrepotTo',
                    'fournisseur',
                    'commande',
                    'user',
                    'details.product'
                ]);

                $createdMovements[] = $stockMovement;
            }

            DB::commit();

            // 10. Rafraîchir la commande pour obtenir les nouvelles quantités
            $commande = $commande->fresh();

            return response()->json([
                'success' => true,
                'message' => 'Commande répartie avec succès dans ' . count($createdMovements) . ' entrepôt(s)',
                'data' => [
                    'commande' => [
                        'commande_id' => $commande->commande_id,
                        'numero_commande' => $commande->numero_commande,
                        'status' => $commande->status,
                        'is_fully_distributed' => $commande->isFullyDistributed(),
                        'can_distribute_more' => $commande->canDistributeMore()
                    ],
                    'stock_movements' => $createdMovements,
                    'quantites_reparties' => $quantitesARepartir,
                    'quantites_restantes' => $commande->getQuantitesRestantes()
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la répartition de la commande',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Historique des répartitions d'une commande
     * 
     * Récupère l'historique complet de toutes les répartitions effectuées pour une commande.
     * Affiche les quantités commandées, réparties et restantes par produit.
     * 
     * @authenticated
     * 
     * @urlParam id string required UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "commande": {
     *       "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *       "numero_commande": "CMD-2025-0001",
     *       "status": "livree",
     *       "date_livraison_effective": "2025-10-15",
     *       "is_fully_distributed": false,
     *       "can_distribute_more": true
     *     },
     *     "quantites_commandees": {
     *       "550e8400-e29b-41d4-a716-446655440003": {
     *         "product": {
     *           "product_id": "550e8400-e29b-41d4-a716-446655440003",
     *           "name": "Produit A",
     *           "code": "PROD-001"
     *         },
     *         "quantite": 100,
     *         "prix_unitaire": "2500.00"
     *       }
     *     },
     *     "quantites_reparties": {
     *       "550e8400-e29b-41d4-a716-446655440003": 50
     *     },
     *     "quantites_restantes": {
     *       "550e8400-e29b-41d4-a716-446655440003": 50
     *     },
     *     "repartitions": [
     *       {
     *         "stock_movement_id": "550e8400-e29b-41d4-a716-446655440010",
     *         "reference": "MV-2025-00001",
     *         "entrepot": {
     *           "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
     *           "name": "Entrepôt Principal",
     *           "code": "ENT-001"
     *         },
     *         "statut": "validated",
     *         "note": "Répartition urgente",
     *         "created_at": "2025-10-15T14:30:00.000000Z",
     *         "user": {
     *           "user_id": "550e8400-e29b-41d4-a716-446655440050",
     *           "username": "admin",
     *           "email": "admin@example.com"
     *         },
     *         "details": [
     *           {
     *             "product": {
     *               "product_id": "550e8400-e29b-41d4-a716-446655440003",
     *               "name": "Produit A",
     *               "code": "PROD-001"
     *             },
     *             "quantite": 50
     *           }
     *         ]
     *       }
     *     ]
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function distributionHistory(string $id): JsonResponse
    {
        $commande = Commande::with([
            'details.product',
            'stockMovements' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'stockMovements.entrepotTo',
            'stockMovements.details.product',
            'stockMovements.user'
        ])->find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        // Construire le tableau des quantités commandées
        $quantitesCommandees = [];
        foreach ($commande->details as $detail) {
            $quantitesCommandees[$detail->product_id] = [
                'product' => $detail->product ? $detail->product->only(['product_id', 'name', 'code']) : null,
                'quantite' => $detail->quantite,
                'prix_unitaire' => $detail->prix_unitaire
            ];
        }

        // Construire le tableau des répartitions avec toutes les informations
        $repartitions = $commande->stockMovements->map(function ($movement) {
            return [
                'stock_movement_id' => $movement->stock_movement_id,
                'reference' => $movement->reference,
                'entrepot' => $movement->entrepotTo ? $movement->entrepotTo->only(['entrepot_id', 'name', 'code']) : null,
                'statut' => $movement->statut,
                'note' => $movement->note,
                'created_at' => $movement->created_at,
                'user' => $movement->user ? $movement->user->only(['user_id', 'username', 'email']) : null,
                'details' => $movement->details->map(function ($detail) {
                    return [
                        'product' => $detail->product ? $detail->product->only(['product_id', 'name', 'code']) : null,
                        'quantite' => $detail->quantite
                    ];
                })
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'commande' => [
                    'commande_id' => $commande->commande_id,
                    'numero_commande' => $commande->numero_commande,
                    'status' => $commande->status,
                    'date_livraison_effective' => $commande->date_livraison_effective,
                    'is_fully_distributed' => $commande->isFullyDistributed(),
                    'can_distribute_more' => $commande->canDistributeMore()
                ],
                'quantites_commandees' => $quantitesCommandees,
                'quantites_reparties' => $commande->getQuantitesReparties(),
                'quantites_restantes' => $commande->getQuantitesRestantes(),
                'repartitions' => $repartitions
            ]
        ]);
    }

    /**
     * Génère une référence unique pour un mouvement de stock
     * Format: MV-YYYY-00001
     */
    private function generateStockMovementReference(): string
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

    /**
     * Affecter un chauffeur à une commande
     * 
     * Affecte un chauffeur à une commande existante pour assurer la livraison.
     * Le chauffeur doit avoir le statut "actif" pour pouvoir être affecté.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @bodyParam chauffeur_id string required L'UUID du chauffeur à affecter. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c
     * 
     * @response 200 scenario="Chauffeur affecté avec succès" {
     *   "success": true,
     *   "message": "Chauffeur affecté avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c",
     *     "camion_id": null,
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "montant": "75000.00",
     *     "status": "en_attente",
     *     "chauffeur": {
     *       "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c",
     *       "name": "Jean Dupont",
     *       "phone": "+229 97 00 00 00",
     *       "numero_permis": "P-123456",
     *       "status": "actif"
     *     }
     *   }
     * }
     * 
     * @response 400 scenario="Chauffeur non actif" {
     *   "success": false,
     *   "message": "Le chauffeur n'est pas actif"
     * }
     * 
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     * 
     * @response 422 scenario="Erreur de validation" {
     *   "success": false,
     *   "message": "Validation échouée",
     *   "errors": {
     *     "chauffeur_id": ["Le chauffeur sélectionné n'existe pas"]
     *   }
     * }
     */
    public function assignChauffeur(Request $request, string $id): JsonResponse
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'chauffeur_id' => 'required|uuid|exists:chauffeurs,chauffeur_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation échouée',
                'errors' => $validator->errors()
            ], 422);
        }

        // Vérifier que le chauffeur est actif
        $chauffeur = Chauffeur::find($request->chauffeur_id);
        if ($chauffeur->status !== 'actif') {
            return response()->json([
                'success' => false,
                'message' => 'Le chauffeur n\'est pas actif'
            ], 400);
        }

        $commande->assignChauffeur($request->chauffeur_id);
        $commande->load('chauffeur');

        return response()->json([
            'success' => true,
            'message' => 'Chauffeur affecté avec succès',
            'data' => $commande
        ], 200);
    }

    /**
     * Affecter un camion à une commande
     * 
     * Affecte un camion à une commande existante pour assurer le transport.
     * Le camion doit avoir le statut "disponible" pour pouvoir être affecté.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @bodyParam camion_id string required L'UUID du camion à affecter. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d
     * 
     * @response 200 scenario="Camion affecté avec succès" {
     *   "success": true,
     *   "message": "Camion affecté avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "chauffeur_id": null,
     *     "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "montant": "75000.00",
     *     "status": "en_attente",
     *     "camion": {
     *       "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d",
     *       "numero_immat": "AB-1234-BJ",
     *       "marque": "Mercedes-Benz",
     *       "modele": "Actros",
     *       "capacite": "15.00",
     *       "status": "disponible"
     *     }
     *   }
     * }
     * 
     * @response 400 scenario="Camion non disponible" {
     *   "success": false,
     *   "message": "Le camion n'est pas disponible"
     * }
     * 
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     * 
     * @response 422 scenario="Erreur de validation" {
     *   "success": false,
     *   "message": "Validation échouée",
     *   "errors": {
     *     "camion_id": ["Le camion sélectionné n'existe pas"]
     *   }
     * }
     */
    public function assignCamion(Request $request, string $id): JsonResponse
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'camion_id' => 'required|uuid|exists:camions,camion_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation échouée',
                'errors' => $validator->errors()
            ], 422);
        }

        // Vérifier que le camion est disponible
        $camion = Camion::find($request->camion_id);
        if ($camion->status !== 'disponible') {
            return response()->json([
                'success' => false,
                'message' => 'Le camion n\'est pas disponible'
            ], 400);
        }

        $commande->assignCamion($request->camion_id);
        $commande->load('camion');

        return response()->json([
            'success' => true,
            'message' => 'Camion affecté avec succès',
            'data' => $commande
        ], 200);
    }

    /**
     * Affecter un chauffeur et un camion à une commande
     * 
     * Affecte simultanément un chauffeur et un camion à une commande existante pour organiser une livraison complète.
     * Le chauffeur doit être "actif" et le camion doit être "disponible".
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @bodyParam chauffeur_id string required L'UUID du chauffeur à affecter. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c
     * @bodyParam camion_id string required L'UUID du camion à affecter. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d
     * 
     * @response 200 scenario="Livraison affectée avec succès" {
     *   "success": true,
     *   "message": "Chauffeur et camion affectés avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c",
     *     "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "montant": "75000.00",
     *     "status": "en_attente",
     *     "chauffeur": {
     *       "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c",
     *       "name": "Jean Dupont",
     *       "phone": "+229 97 00 00 00",
     *       "numero_permis": "P-123456",
     *       "status": "actif"
     *     },
     *     "camion": {
     *       "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d",
     *       "numero_immat": "AB-1234-BJ",
     *       "marque": "Mercedes-Benz",
     *       "modele": "Actros",
     *       "capacite": "15.00",
     *       "status": "disponible"
     *     }
     *   }
     * }
     * 
     * @response 400 scenario="Chauffeur non actif" {
     *   "success": false,
     *   "message": "Le chauffeur n'est pas actif"
     * }
     * 
     * @response 400 scenario="Camion non disponible" {
     *   "success": false,
     *   "message": "Le camion n'est pas disponible"
     * }
     * 
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     * 
     * @response 422 scenario="Erreur de validation" {
     *   "success": false,
     *   "message": "Validation échouée",
     *   "errors": {
     *     "chauffeur_id": ["Le chauffeur sélectionné n'existe pas"],
     *     "camion_id": ["Le camion sélectionné n'existe pas"]
     *   }
     * }
     */
    public function assignLivraison(Request $request, string $id): JsonResponse
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'chauffeur_id' => 'required|uuid|exists:chauffeurs,chauffeur_id',
            'camion_id' => 'required|uuid|exists:camions,camion_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation échouée',
                'errors' => $validator->errors()
            ], 422);
        }

        // Vérifier que le chauffeur est actif
        $chauffeur = Chauffeur::find($request->chauffeur_id);
        if ($chauffeur->status !== 'actif') {
            return response()->json([
                'success' => false,
                'message' => 'Le chauffeur n\'est pas actif'
            ], 400);
        }

        // Vérifier que le camion est disponible
        $camion = Camion::find($request->camion_id);
        if ($camion->status !== 'disponible') {
            return response()->json([
                'success' => false,
                'message' => 'Le camion n\'est pas disponible'
            ], 400);
        }

        $commande->assignLivraison($request->chauffeur_id, $request->camion_id);
        $commande->load(['chauffeur', 'camion']);

        return response()->json([
            'success' => true,
            'message' => 'Chauffeur et camion affectés avec succès',
            'data' => $commande
        ], 200);
    }

    /**
     * Retirer le chauffeur d'une commande
     * 
     * Retire le chauffeur affecté à une commande. La commande repassera en livraison fournisseur si aucun camion n'est affecté.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 scenario="Chauffeur retiré avec succès" {
     *   "success": true,
     *   "message": "Chauffeur retiré avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "chauffeur_id": null,
     *     "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d",
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "montant": "75000.00",
     *     "status": "en_attente"
     *   }
     * }
     * 
     * @response 400 scenario="Aucun chauffeur affecté" {
     *   "success": false,
     *   "message": "Aucun chauffeur n'est affecté à cette commande"
     * }
     * 
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function unassignChauffeur(string $id): JsonResponse
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        if (!$commande->hasChauffeur()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun chauffeur n\'est affecté à cette commande'
            ], 400);
        }

        $commande->unassignChauffeur();

        return response()->json([
            'success' => true,
            'message' => 'Chauffeur retiré avec succès',
            'data' => $commande
        ], 200);
    }

    /**
     * Retirer le camion d'une commande
     * 
     * Retire le camion affecté à une commande. La commande repassera en livraison fournisseur si aucun chauffeur n'est affecté.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 scenario="Camion retiré avec succès" {
     *   "success": true,
     *   "message": "Camion retiré avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c",
     *     "camion_id": null,
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "montant": "75000.00",
     *     "status": "en_attente"
     *   }
     * }
     * 
     * @response 400 scenario="Aucun camion affecté" {
     *   "success": false,
     *   "message": "Aucun camion n'est affecté à cette commande"
     * }
     * 
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function unassignCamion(string $id): JsonResponse
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        if (!$commande->hasCamion()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun camion n\'est affecté à cette commande'
            ], 400);
        }

        $commande->unassignCamion();

        return response()->json([
            'success' => true,
            'message' => 'Camion retiré avec succès',
            'data' => $commande
        ], 200);
    }

    /**
     * Retirer le chauffeur et le camion d'une commande
     * 
     * Retire simultanément le chauffeur et le camion affectés à une commande.
     * La commande repassera en livraison fournisseur.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 scenario="Livraison retirée avec succès" {
     *   "success": true,
     *   "message": "Chauffeur et camion retirés avec succès",
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "fournisseur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b",
     *     "chauffeur_id": null,
     *     "camion_id": null,
     *     "date_achat": "2025-01-15",
     *     "date_livraison_prevue": "2025-02-15",
     *     "montant": "75000.00",
     *     "status": "en_attente"
     *   }
     * }
     * 
     * @response 400 scenario="Aucune livraison propre affectée" {
     *   "success": false,
     *   "message": "Aucun chauffeur ni camion n'est affecté à cette commande"
     * }
     * 
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function unassignLivraison(string $id): JsonResponse
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        if (!$commande->isLivraisonPropre()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun chauffeur ni camion n\'est affecté à cette commande'
            ], 400);
        }

        $commande->unassignLivraison();

        return response()->json([
            'success' => true,
            'message' => 'Chauffeur et camion retirés avec succès',
            'data' => $commande
        ], 200);
    }

    /**
     * Obtenir les informations de livraison d'une commande
     * 
     * Récupère les informations détaillées concernant la livraison d'une commande :
     * type de livraison (propre ou fournisseur), chauffeur et camion affectés.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @response 200 scenario="Livraison propre complète" {
     *   "success": true,
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "type_livraison": "propre",
     *     "livraison_complete": true,
     *     "chauffeur": {
     *       "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c",
     *       "name": "Jean Dupont",
     *       "phone": "+229 97 00 00 00",
     *       "numero_permis": "P-123456",
     *       "date_expiration_permis": "2026-12-31",
     *       "status": "actif"
     *     },
     *     "camion": {
     *       "camion_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3d",
     *       "numero_immat": "AB-1234-BJ",
     *       "marque": "Mercedes-Benz",
     *       "modele": "Actros",
     *       "capacite": "15.00",
     *       "status": "disponible"
     *     }
     *   }
     * }
     * 
     * @response 200 scenario="Livraison fournisseur" {
     *   "success": true,
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "type_livraison": "fournisseur",
     *     "livraison_complete": false,
     *     "chauffeur": null,
     *     "camion": null
     *   }
     * }
     * 
     * @response 200 scenario="Livraison propre partielle (chauffeur seul)" {
     *   "success": true,
     *   "data": {
     *     "commande_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a",
     *     "numero_commande": "CMD-2025-0156",
     *     "type_livraison": "propre",
     *     "livraison_complete": false,
     *     "chauffeur": {
     *       "chauffeur_id": "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f3c",
     *       "name": "Jean Dupont",
     *       "phone": "+229 97 00 00 00",
     *       "status": "actif"
     *     },
     *     "camion": null
     *   }
     * }
     * 
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function livraisonInfo(string $id): JsonResponse
    {
        $commande = Commande::with(['chauffeur', 'camion'])->find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'commande_id' => $commande->commande_id,
                'numero_commande' => $commande->numero_commande,
                'type_livraison' => $commande->isLivraisonPropre() ? 'propre' : 'fournisseur',
                'livraison_complete' => $commande->hasCompleteLivraisonPropre(),
                'chauffeur' => $commande->chauffeur,
                'camion' => $commande->camion,
            ]
        ], 200);
    }
}
