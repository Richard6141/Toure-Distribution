<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE delivery_details MODIFY statut ENUM('en_attente', 'en_preparation', 'pret', 'livre', 'partiellement_livre', 'retourne', 'manquant', 'annule') DEFAULT 'en_attente'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE delivery_details MODIFY statut ENUM('en_attente', 'en_preparation', 'pret', 'livre', 'partiellement_livre', 'retourne', 'manquant') DEFAULT 'en_attente'");
    }
};
