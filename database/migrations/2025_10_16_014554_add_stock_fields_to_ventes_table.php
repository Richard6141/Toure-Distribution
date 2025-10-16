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
        Schema::table('ventes', function (Blueprint $table) {
            // Ajouter l'entrepôt source si n'existe pas
            if (!Schema::hasColumn('ventes', 'entrepot_id')) {
                $table->uuid('entrepot_id')
                    ->nullable()
                    ->after('client_id')
                    ->comment('Entrepôt source de la vente');

                $table->foreign('entrepot_id')
                    ->references('entrepot_id')
                    ->on('entrepots')
                    ->onDelete('restrict');

                $table->index('entrepot_id');
            }

            // Ajouter la référence au mouvement de stock si n'existe pas
            if (!Schema::hasColumn('ventes', 'stock_movement_id')) {
                $table->uuid('stock_movement_id')
                    ->nullable()
                    ->after('note')
                    ->comment('Mouvement de stock associé');

                $table->foreign('stock_movement_id')
                    ->references('stock_movement_id')
                    ->on('stock_movements')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            // Supprimer les clés étrangères et colonnes
            if (Schema::hasColumn('ventes', 'stock_movement_id')) {
                $table->dropForeign(['stock_movement_id']);
                $table->dropColumn('stock_movement_id');
            }

            if (Schema::hasColumn('ventes', 'entrepot_id')) {
                $table->dropForeign(['entrepot_id']);
                $table->dropIndex(['entrepot_id']);
                $table->dropColumn('entrepot_id');
            }
        });
    }
};
