<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\ClientTypeController;
use App\Http\Controllers\Api\EntrepotController;
use App\Http\Controllers\Api\FournisseurController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\StockMovementTypeController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\StockMovementDetailController;

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

Route::prefix('client-types')->group(function () {
    // Routes CRUD principales
    Route::get('/', [ClientTypeController::class, 'index'])->name('client-types.index');
    Route::post('/', [ClientTypeController::class, 'store'])->name('client-types.store');
    Route::get('/{client_type_id}', [ClientTypeController::class, 'show'])->name('client-types.show');
    Route::put('/{client_type_id}', [ClientTypeController::class, 'update'])->name('client-types.update');
    Route::patch('/{client_type_id}', [ClientTypeController::class, 'update'])->name('client-types.patch');
    Route::delete('/{client_type_id}', [ClientTypeController::class, 'destroy'])->name('client-types.destroy');

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [ClientTypeController::class, 'trashed'])->name('client-types.trashed');
    Route::post('/{client_type_id}/restore', [ClientTypeController::class, 'restore'])->name('client-types.restore');
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
    Route::get('/', [StockMovementController::class, 'index']);                   // Liste des mouvements
    Route::post('/', [StockMovementController::class, 'store']);                  // Création d'un mouvement
    Route::get('/{id}', [StockMovementController::class, 'show']);                // Afficher un mouvement par ID
    Route::put('/{id}', [StockMovementController::class, 'update']);              // Mise à jour d'un mouvement
    Route::patch('/{id}', [StockMovementController::class, 'update']);            // Mise à jour partielle d'un mouvement
    Route::delete('/{id}', [StockMovementController::class, 'destroy']);          // Suppression logique (soft delete)

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [StockMovementController::class, 'trashed']);     // Liste des mouvements supprimés
    Route::post('/{id}/restore', [StockMovementController::class, 'restore']);    // Restaurer un mouvement supprimé

    // Routes spéciales
    Route::patch('/{id}/update-status', [StockMovementController::class, 'updateStatus']); // Changer le statut
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
