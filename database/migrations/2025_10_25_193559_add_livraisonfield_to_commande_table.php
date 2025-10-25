<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cette migration ajoute les champs chauffeur_id et camion_id
     * à une table commandes existante
     */
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            // Ajout des champs pour la livraison avec chauffeur et camion propres
            $table->uuid('chauffeur_id')->nullable()->after('fournisseur_id');
            $table->uuid('camion_id')->nullable()->after('chauffeur_id');

            // Clés étrangères vers chauffeurs et camions
            $table->foreign('chauffeur_id')
                ->references('chauffeur_id')
                ->on('chauffeurs')
                ->onDelete('set null');

            $table->foreign('camion_id')
                ->references('camion_id')
                ->on('camions')
                ->onDelete('set null');

            // Index pour améliorer les performances
            $table->index('chauffeur_id');
            $table->index('camion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            // Supprimer les clés étrangères
            $table->dropForeign(['chauffeur_id']);
            $table->dropForeign(['camion_id']);

            // Supprimer les index
            $table->dropIndex(['chauffeur_id']);
            $table->dropIndex(['camion_id']);

            // Supprimer les colonnes
            $table->dropColumn(['chauffeur_id', 'camion_id']);
        });
    }
};
