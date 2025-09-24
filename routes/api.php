<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\ClientTypeController;

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
    // Routes CRUD principales
    Route::get('/', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/{client_id}', [ClientController::class, 'show'])->name('clients.show');
    Route::put('/{client_id}', [ClientController::class, 'update'])->name('clients.update');
    Route::patch('/{client_id}', [ClientController::class, 'update'])->name('clients.patch');
    Route::delete('/{client_id}', [ClientController::class, 'destroy'])->name('clients.destroy');

    // Routes pour gestion soft delete
    Route::get('/trashed/list', [ClientController::class, 'trashed'])->name('clients.trashed');
    Route::post('/{client_id}/restore', [ClientController::class, 'restore'])->name('clients.restore');

    // Routes pour actions spéciales
    Route::patch('/{client_id}/toggle-status', [ClientController::class, 'toggleStatus'])->name('clients.toggle-status');
    Route::patch('/{client_id}/update-balance', [ClientController::class, 'updateBalance'])->name('clients.update-balance');

    // Routes pour recherche et statistiques
    Route::post('/search', [ClientController::class, 'search'])->name('clients.search');
    Route::get('/statistics/overview', [ClientController::class, 'statistics'])->name('clients.statistics');
})->middleware('auth:sanctum');
