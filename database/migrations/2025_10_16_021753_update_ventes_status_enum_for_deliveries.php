<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Commande pour créer cette migration :
 * php artisan make:migration add_delivery_status_to_ventes_table
 * 
 * ou
 * 
 * php artisan make:migration update_ventes_status_enum_for_deliveries
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Méthode 1: Utilisation de ALTER TABLE (MySQL/MariaDB)
        DB::statement("ALTER TABLE ventes MODIFY COLUMN status ENUM(
            'en_attente',
            'validee',
            'en_cours_livraison',
            'livree',
            'partiellement_livree',
            'annulee'
        ) DEFAULT 'en_attente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Retour à l'ancienne définition
        DB::statement("ALTER TABLE ventes MODIFY COLUMN status ENUM(
            'en_attente',
            'validee',
            'livree',
            'partiellement_livree',
            'annulee'
        ) DEFAULT 'en_attente'");
    }
};
