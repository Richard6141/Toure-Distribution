<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            // Ajout de la colonne commande_id
            $table->uuid('commande_id')
                ->nullable()
                ->after('fournisseur_id')
                ->comment('Référence à la commande fournisseur source');

            // Ajout de la clé étrangère
            $table->foreign('commande_id')
                ->references('commande_id')
                ->on('commandes')
                ->onDelete('set null');

            // Ajout de l'index pour améliorer les performances
            $table->index('commande_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            // Supprimer la clé étrangère
            $table->dropForeign(['commande_id']);

            // Supprimer la colonne
            $table->dropColumn('commande_id');
        });
    }
};
