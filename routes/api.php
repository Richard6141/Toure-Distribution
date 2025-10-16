<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VenteController;
use App\Http\Controllers\Api\CamionController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\ClientTypeController;
use App\Http\Controllers\Api\FactureController;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\EntrepotController;
use App\Http\Controllers\Api\PaiementController;
use App\Http\Controllers\Api\ChauffeurController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\Api\DetailVenteController;
use App\Http\Controllers\Api\FournisseurController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\Api\PaiementVenteController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\StockMovementTypeController;
use App\Http\Controllers\Api\DetailCommandeController;
use App\Http\Controllers\StockMovementDetailController;
use App\Http\Controllers\Api\PaiementCommandeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->name('auth.')->group(function () {
    // Routes publiques (sans authentification)
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

    // Vérifications de disponibilité
    Route::get('check-username/{username}', [AuthController::class, 'checkUsername'])->name('check.username');
    Route::get('check-email/{email}', [AuthController::class, 'checkEmail'])->name('check.email');

    // Routes protégées (authentification requise)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('logout-all', [AuthController::class, 'logoutAll'])->name('logout.all');
        Route::post('change-password', [AuthController::class, 'changePassword'])->name('change.password');
    });
});

Route::prefix('client-types')->name('client-types.')->group(function () {
    // Routes fixes d'abord (pour éviter les conflits avec les routes dynamiques)
    Route::get('/trashed/list', [ClientTypeController::class, 'trashed'])->name('trashed');

    // Routes CRUD standard
    Route::get('/', [ClientTypeController::class, 'index'])->name('index');
    Route::post('/', [ClientTypeController::class, 'store'])->name('store');
    Route::get('/{client_type_id}', [ClientTypeController::class, 'show'])->name('show');
    Route::put('/{client_type_id}', [ClientTypeController::class, 'update'])->name('update');
    Route::patch('/{client_type_id}', [ClientTypeController::class, 'update'])->name('patch');
    Route::delete('/{client_type_id}', [ClientTypeController::class, 'destroy'])->name('destroy');

    // Routes pour gestion soft delete
    Route::post('/{client_type_id}/restore', [ClientTypeController::class, 'restore'])->name('restore');
})->middleware('auth:sanctum');

Route::prefix('clients')->group(function () {
    // ✅ Routes avec segments FIXES en premier
    Route::get('/trashed/list', [ClientController::class, 'trashed'])->name('clients.trashed');
    Route::get('/statistics/overview', [ClientController::class, 'statistics'])->name('clients.statistics');
    Route::post('/search', [ClientController::class, 'search'])->name('clients.search');

    // ✅ Routes CRUD principales (avec paramètres dynamiques)
    Route::get('/', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/{client_id}', [ClientController::class, 'show'])->name('clients.show');
    Route::put('/{client_id}', [ClientController::class, 'update'])->name('clients.update');
    Route::patch('/{client_id}', [ClientController::class, 'update'])->name('clients.patch');
    Route::delete('/{client_id}', [ClientController::class, 'destroy'])->name('clients.destroy');

    // ✅ Routes pour gestion soft delete et actions spéciales
    Route::post('/{client_id}/restore', [ClientController::class, 'restore'])->name('clients.restore');
    Route::patch('/{client_id}/toggle-status', [ClientController::class, 'toggleStatus'])->name('clients.toggle-status');
    Route::patch('/{client_id}/update-balance', [ClientController::class, 'updateBalance'])->name('clients.update-balance');
})->middleware('auth:sanctum');
/*

/*
|--------------------------------------------------------------------------
| Fournisseurs API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('fournisseurs')->name('fournisseurs.')->group(function () {
    // Routes CRUD standard
    Route::get('/', [FournisseurController::class, 'index'])->name('index');
    Route::post('/', [FournisseurController::class, 'store'])->name('store');
    Route::get('/{id}', [FournisseurController::class, 'show'])->name('show');
    Route::put('/{id}', [FournisseurController::class, 'update'])->name('update');
    Route::patch('/{id}', [FournisseurController::class, 'update'])->name('patch');
    Route::delete('/{id}', [FournisseurController::class, 'destroy'])->name('destroy');

    // Routes pour la gestion du soft delete
    Route::patch('/{id}/restore', [FournisseurController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force', [FournisseurController::class, 'forceDelete'])->name('force-delete');
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Entrepôts API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('entrepots')->name('entrepots.')->group(function () {
    // Routes CRUD standard
    Route::get('/', [EntrepotController::class, 'index'])->name('index');
    Route::post('/', [EntrepotController::class, 'store'])->name('store');
    Route::get('/{id}', [EntrepotController::class, 'show'])->name('show');
    Route::put('/{id}', [EntrepotController::class, 'update'])->name('update');
    Route::patch('/{id}', [EntrepotController::class, 'update'])->name('patch');
    Route::delete('/{id}', [EntrepotController::class, 'destroy'])->name('destroy');

    // Routes pour la gestion des responsables
    Route::patch('/{id}/assign-user', [EntrepotController::class, 'assignUser'])->name('assign-user');
    Route::patch('/{id}/unassign-user', [EntrepotController::class, 'unassignUser'])->name('unassign-user');
    Route::patch('/{id}/change-user', [EntrepotController::class, 'changeUser'])->name('change-user');
})->middleware('auth:sanctum');


Route::prefix('product-categories')->group(function () {
    Route::get('/', [ProductCategoryController::class, 'index']);      // Liste des catégories
    Route::post('/', [ProductCategoryController::class, 'store']);     // Création
    Route::get('{id}', [ProductCategoryController::class, 'show']);    // Détail
    Route::put('{id}', [ProductCategoryController::class, 'update']);  // Mise à jour
    Route::delete('{id}', [ProductCategoryController::class, 'destroy']); // Suppression
})->middleware('auth:sanctum');


Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);          // Liste des produits
    Route::post('/', [ProductController::class, 'store']);         // Création d’un produit
    Route::get('{id}', [ProductController::class, 'show']);        // Afficher un produit par ID
    Route::put('{id}', [ProductController::class, 'update']);      // Mise à jour d’un produit
    Route::delete('{id}', [ProductController::class, 'destroy']);  // Suppression logique (soft delete)

    // Bonus utiles
    Route::get('category/{categoryId}', [ProductController::class, 'byCategory']); // Produits d’une catégorie
    Route::get('{id}/restore', [ProductController::class, 'restore']);  // Restaurer un produit supprimé
    Route::delete('{id}/force', [ProductController::class, 'forceDelete']); // Suppression définitive
})->middleware('auth:sanctum');

/**
 * Routes pour la gestion des stocks
 * Prefix: /stocks
 */
Route::prefix('stocks')->group(function () {
    Route::get('/', [StockController::class, 'index']);               // Liste des stocks
    Route::post('/', [StockController::class, 'store']);              // Création d'un stock
    Route::get('{id}', [StockController::class, 'show']);             // Afficher un stock par ID
    Route::put('{id}', [StockController::class, 'update']);           // Mise à jour d'un stock
    Route::delete('{id}', [StockController::class, 'destroy']);       // Suppression logique (soft delete)

    // Routes spécifiques pour la gestion des stocks
    Route::post('{id}/adjust', [StockController::class, 'adjustQuantity']); // Ajuster la quantité
    Route::post('{id}/reserve', [StockController::class, 'reserve']);        // Réserver une quantité
    Route::post('{id}/release', [StockController::class, 'release']);        // Libérer une réservation

    // Bonus utiles
    Route::get('product/{productId}', [StockController::class, 'byProduct']);    // Stocks d'un produit
    Route::get('entrepot/{entrepotId}', [StockController::class, 'byEntrepot']); // Stocks d'un entrepôt
    Route::get('{id}/restore', [StockController::class, 'restore']);             // Restaurer un stock supprimé
    Route::delete('{id}/force', [StockController::class, 'forceDelete']);        // Suppression définitive
})->middleware('auth:sanctum');

/**
 * Routes pour la gestion des types de mouvements de stock
 * Prefix: /stock-movement-types
 */
Route::prefix('stock-movement-types')->group(function () {
    Route::get('/', [StockMovementTypeController::class, 'index']);               // Liste des types
    Route::post('/', [StockMovementTypeController::class, 'store']);              // Création d'un type
    Route::get('/{id}', [StockMovementTypeController::class, 'show']);            // Afficher un type par ID
    Route::put('/{id}', [StockMovementTypeController::class, 'update']);          // Mise à jour d'un type
    Route::patch('/{id}', [StockMovementTypeController::class, 'update']);        // Mise à jour partielle d'un type
    Route::delete('/{id}', [StockMovementTypeController::class, 'destroy']);      // Suppression logique (soft delete)

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [StockMovementTypeController::class, 'trashed']); // Liste des types supprimés
    Route::post('/{id}/restore', [StockMovementTypeController::class, 'restore']); // Restaurer un type supprimé
})->middleware('auth:sanctum');

/**
 * Routes pour la gestion des mouvements de stock
 * Prefix: /stock-movements
 */
Route::prefix('stock-movements')->group(function () {


    Route::get('/', [StockMovementController::class, 'index'])
        ->name('stock-movements.index');

    Route::post('/', [StockMovementController::class, 'store'])
        ->name('stock-movements.store');

    Route::get('/{id}', [StockMovementController::class, 'show'])
        ->name('stock-movements.show');

    Route::put('/{id}', [StockMovementController::class, 'update'])
        ->name('stock-movements.update');

    Route::patch('/{id}', [StockMovementController::class, 'update'])
        ->name('stock-movements.update-partial');

    Route::delete('/{id}', [StockMovementController::class, 'destroy'])
        ->name('stock-movements.destroy');


    Route::post('/transfer/warehouse', [StockMovementController::class, 'storeWarehouseTransfer'])
        ->name('stock-movements.transfer.warehouse');

    Route::post('/receipt/supplier', [StockMovementController::class, 'storeSupplierReceipt'])
        ->name('stock-movements.receipt.supplier');


    Route::get('/trashed/list', [StockMovementController::class, 'trashed'])
        ->name('stock-movements.trashed');
    Route::post('/{id}/validate', [StockMovementController::class, 'validateMovement']);
    Route::post('/{id}/cancel', [StockMovementController::class, 'cancelMovement']);


    Route::post('/{id}/restore', [StockMovementController::class, 'restore'])
        ->name('stock-movements.restore');

    Route::patch('/{id}/update-status', [StockMovementController::class, 'updateStatus'])
        ->name('stock-movements.update-status');
})->middleware('auth:sanctum');

/**
 * Routes pour la gestion des détails de mouvements de stock
 * Prefix: /stock-movement-details
 */
Route::prefix('stock-movement-details')->group(function () {
    Route::get('/', [StockMovementDetailController::class, 'index']);             // Liste des détails
    Route::post('/', [StockMovementDetailController::class, 'store']);            // Création d'un détail
    Route::get('/{id}', [StockMovementDetailController::class, 'show']);          // Afficher un détail par ID
    Route::put('/{id}', [StockMovementDetailController::class, 'update']);        // Mise à jour d'un détail
    Route::patch('/{id}', [StockMovementDetailController::class, 'update']);      // Mise à jour partielle d'un détail
    Route::delete('/{id}', [StockMovementDetailController::class, 'destroy']);    // Suppression logique (soft delete)

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [StockMovementDetailController::class, 'trashed']); // Liste des détails supprimés
    Route::post('/{id}/restore', [StockMovementDetailController::class, 'restore']); // Restaurer un détail supprimé

    // Routes spéciales
    Route::get('/stock-movement/{stockMovementId}', [StockMovementDetailController::class, 'byStockMovement']); // Détails d'un mouvement
    Route::get('/product/{productId}', [StockMovementDetailController::class, 'byProduct']); // Détails d'un produit
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Payment Methods API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('payment-methods')->name('payment-methods.')->group(function () {
    // Routes fixes d'abord (pour éviter les conflits avec les routes dynamiques)
    Route::get('/statistics/overview', [PaymentMethodController::class, 'statistics'])->name('statistics');

    // Routes CRUD standard
    Route::get('/', [PaymentMethodController::class, 'index'])->name('index');
    Route::post('/', [PaymentMethodController::class, 'store'])->name('store');
    Route::get('/{id}', [PaymentMethodController::class, 'show'])->name('show');
    Route::put('/{id}', [PaymentMethodController::class, 'update'])->name('update');
    Route::patch('/{id}', [PaymentMethodController::class, 'update'])->name('patch');
    Route::delete('/{id}', [PaymentMethodController::class, 'destroy'])->name('destroy');

    // Routes pour actions spéciales
    Route::patch('/{id}/toggle-status', [PaymentMethodController::class, 'toggleStatus'])->name('toggle-status');
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Invoices (Factures) API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('factures')->name('factures.')->group(function () {
    // Routes fixes d'abord (pour éviter les conflits avec les routes dynamiques)
    Route::get('/statistics/overview', [FactureController::class, 'statistics'])->name('statistics');

    // Routes CRUD standard
    Route::get('/', [FactureController::class, 'index'])->name('index');
    Route::post('/', [FactureController::class, 'store'])->name('store');
    Route::get('/{id}', [FactureController::class, 'show'])->name('show');
    Route::put('/{id}', [FactureController::class, 'update'])->name('update');
    Route::patch('/{id}', [FactureController::class, 'update'])->name('patch');
    Route::delete('/{id}', [FactureController::class, 'destroy'])->name('destroy');

    // Routes pour actions spéciales
    Route::patch('/{id}/update-status', [FactureController::class, 'updateStatus'])->name('update-status');
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Payments (Paiements) API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('paiements')->name('paiements.')->group(function () {
    // Routes fixes d'abord (pour éviter les conflits avec les routes dynamiques)
    Route::get('/statistics/overview', [PaiementController::class, 'statistics'])->name('statistics');

    // Routes CRUD standard
    Route::get('/', [PaiementController::class, 'index'])->name('index');
    Route::post('/', [PaiementController::class, 'store'])->name('store');
    Route::get('/{id}', [PaiementController::class, 'show'])->name('show');
    Route::put('/{id}', [PaiementController::class, 'update'])->name('update');
    Route::patch('/{id}', [PaiementController::class, 'update'])->name('patch');
    Route::delete('/{id}', [PaiementController::class, 'destroy'])->name('destroy');

    // Routes pour actions spéciales
    Route::patch('/{id}/update-status', [PaiementController::class, 'updateStatus'])->name('update-status');
})->middleware('auth:sanctum');
/**
 * Routes pour la gestion des chauffeurs
 * Prefix: /chauffeurs
 */
Route::prefix('chauffeurs')->group(function () {
    Route::get('/', [ChauffeurController::class, 'index']);               // Liste des chauffeurs
    Route::post('/', [ChauffeurController::class, 'store']);              // Création d'un chauffeur
    Route::get('/{id}', [ChauffeurController::class, 'show']);            // Afficher un chauffeur par ID
    Route::put('/{id}', [ChauffeurController::class, 'update']);          // Mise à jour d'un chauffeur
    Route::patch('/{id}', [ChauffeurController::class, 'update']);        // Mise à jour partielle d'un chauffeur
    Route::delete('/{id}', [ChauffeurController::class, 'destroy']);      // Suppression logique (soft delete)

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [ChauffeurController::class, 'trashed']); // Liste des chauffeurs supprimés
    Route::post('/{id}/restore', [ChauffeurController::class, 'restore']); // Restaurer un chauffeur supprimé
})->middleware('auth:sanctum');
/**
 * Routes pour la gestion des camions
 * Prefix: /camions
 */
Route::prefix('camions')->group(function () {
    Route::get('/', [CamionController::class, 'index']);               // Liste des camions
    Route::post('/', [CamionController::class, 'store']);              // Création d'un camion
    Route::get('/{id}', [CamionController::class, 'show']);            // Afficher un camion par ID
    Route::put('/{id}', [CamionController::class, 'update']);          // Mise à jour d'un camion
    Route::patch('/{id}', [CamionController::class, 'update']);        // Mise à jour partielle d'un camion
    Route::delete('/{id}', [CamionController::class, 'destroy']);      // Suppression logique (soft delete)

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [CamionController::class, 'trashed']); // Liste des camions supprimés
    Route::post('/{id}/restore', [CamionController::class, 'restore']); // Restaurer un camion supprimé
})->middleware('auth:sanctum');

/**
 * Routes pour la gestion des commandes d'achat
 * Prefix: /commandes
 */
Route::prefix('commandes')->group(function () {
    Route::get('/', [CommandeController::class, 'index']);               // Liste des commandes
    Route::post('/', [CommandeController::class, 'store']);              // Création d'une commande
    Route::get('/{id}', [CommandeController::class, 'show']);            // Afficher une commande par ID
    Route::put('/{id}', [CommandeController::class, 'update']);          // Mise à jour d'une commande
    Route::patch('/{id}', [CommandeController::class, 'update']);        // Mise à jour partielle d'une commande
    Route::delete('/{id}', [CommandeController::class, 'destroy']);      // Suppression logique (soft delete)

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [CommandeController::class, 'trashed']); // Liste des commandes supprimées
    Route::post('/{id}/restore', [CommandeController::class, 'restore']); // Restaurer une commande supprimée
})->middleware('auth:sanctum');

/**
 * Routes pour la gestion des détails de commandes
 * Prefix: /detail-commandes
 */
Route::prefix('detail-commandes')->group(function () {
    Route::get('/', [DetailCommandeController::class, 'index']);                         // Liste des détails
    Route::post('/', [DetailCommandeController::class, 'store']);                        // Créer un détail
    Route::post('/multiple', [DetailCommandeController::class, 'storeMultiple']);        // Créer plusieurs détails
    Route::get('/commande/{commandeId}', [DetailCommandeController::class, 'getByCommande']); // Détails d'une commande
    Route::get('/{id}', [DetailCommandeController::class, 'show']);                      // Afficher un détail
    Route::put('/{id}', [DetailCommandeController::class, 'update']);                    // Mettre à jour un détail
    Route::patch('/{id}', [DetailCommandeController::class, 'update']);                  // Mise à jour partielle
    Route::delete('/{id}', [DetailCommandeController::class, 'destroy']);                // Supprimer un détail

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [DetailCommandeController::class, 'trashed']);           // Liste des détails supprimés
    Route::post('/{id}/restore', [DetailCommandeController::class, 'restore']);          // Restaurer un détail
})->middleware('auth:sanctum');
/**
 * Routes pour la gestion des paiements de commandes
 * Prefix: /paiement-commandes
 */
Route::prefix('paiement-commandes')->group(function () {
    Route::get('/', [PaiementCommandeController::class, 'index']);               // Liste des paiements
    Route::post('/', [PaiementCommandeController::class, 'store']);              // Création d'un paiement
    Route::get('/{id}', [PaiementCommandeController::class, 'show']);            // Afficher un paiement par ID
    Route::put('/{id}', [PaiementCommandeController::class, 'update']);          // Mise à jour d'un paiement
    Route::patch('/{id}', [PaiementCommandeController::class, 'update']);        // Mise à jour partielle d'un paiement
    Route::delete('/{id}', [PaiementCommandeController::class, 'destroy']);      // Suppression logique (soft delete)

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [PaiementCommandeController::class, 'trashed']); // Liste des paiements supprimés
    Route::post('/{id}/restore', [PaiementCommandeController::class, 'restore']); // Restaurer un paiement supprimé

    // Route spéciale pour les paiements d'une commande
    Route::get('/commande/{commande_id}', [PaiementCommandeController::class, 'paiementsParCommande']); // Paiements d'une commande
})->middleware('auth:sanctum');

/**
 * Routes pour la gestion des ventes
 * Prefix: /ventes
 */
Route::prefix('ventes')->group(function () {
    Route::get('/', [VenteController::class, 'index']);               // Liste des ventes
    Route::post('/', [VenteController::class, 'store']);              // Création d'une vente
    Route::get('/{id}', [VenteController::class, 'show']);            // Afficher une vente par ID
    Route::put('/{id}', [VenteController::class, 'update']);          // Mise à jour d'une vente
    Route::patch('/{id}', [VenteController::class, 'update']);        // Mise à jour partielle
    Route::delete('/{id}', [VenteController::class, 'destroy']);      // Suppression logique

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [VenteController::class, 'trashed']); // Liste des ventes supprimées
    Route::post('/{id}/restore', [VenteController::class, 'restore']); // Restaurer une vente
})->middleware('auth:sanctum');

/**
 * Routes pour la gestion des détails de ventes
 * Prefix: /detail-ventes
 */
Route::prefix('detail-ventes')->group(function () {
    Route::get('/', [DetailVenteController::class, 'index']);               // Liste des détails
    Route::post('/', [DetailVenteController::class, 'store']);              // Création d'un détail
    Route::post('/multiple', [DetailVenteController::class, 'storeMultiple']); // Création multiple de détails
    Route::get('/{id}', [DetailVenteController::class, 'show']);            // Afficher un détail par ID
    Route::put('/{id}', [DetailVenteController::class, 'update']);          // Mise à jour d'un détail
    Route::patch('/{id}', [DetailVenteController::class, 'update']);        // Mise à jour partielle
    Route::delete('/{id}', [DetailVenteController::class, 'destroy']);      // Suppression logique

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [DetailVenteController::class, 'trashed']); // Liste des détails supprimés
    Route::post('/{id}/restore', [DetailVenteController::class, 'restore']); // Restaurer un détail

    // Route spéciale pour les détails d'une vente
    Route::get('/vente/{vente_id}', [DetailVenteController::class, 'detailsParVente']); // Détails d'une vente
})->middleware('auth:sanctum');

/**
 * Routes pour la gestion des paiements de ventes
 * Prefix: /paiement-ventes
 */
Route::prefix('paiement-ventes')->group(function () {
    Route::get('/', [PaiementVenteController::class, 'index']);               // Liste des paiements
    Route::post('/', [PaiementVenteController::class, 'store']);              // Création d'un paiement
    Route::get('/{id}', [PaiementVenteController::class, 'show']);            // Afficher un paiement par ID
    Route::put('/{id}', [PaiementVenteController::class, 'update']);          // Mise à jour d'un paiement
    Route::patch('/{id}', [PaiementVenteController::class, 'update']);        // Mise à jour partielle
    Route::delete('/{id}', [PaiementVenteController::class, 'destroy']);      // Suppression logique

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [PaiementVenteController::class, 'trashed']); // Liste des paiements supprimés
    Route::post('/{id}/restore', [PaiementVenteController::class, 'restore']); // Restaurer un paiement

    // Route spéciale pour les paiements d'une vente
    Route::get('/vente/{vente_id}', [PaiementVenteController::class, 'paiementsParVente']); // Paiements d'une vente
})->middleware('auth:sanctum');
