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
        Schema::table('deliveries', function (Blueprint $table) {
            // Supprimer les anciennes contraintes
            $table->dropForeign(['vente_id']);
            $table->dropForeign(['client_id']);
            $table->dropForeign(['entrepot_id']);

            // Recréer avec cascade ou no action
            $table->foreign('vente_id')
                ->references('vente_id')
                ->on('ventes')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->foreign('entrepot_id')
                ->references('entrepot_id')
                ->on('entrepots')
                ->onDelete('no action')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            // Remettre restrict
            $table->dropForeign(['vente_id']);
            $table->dropForeign(['client_id']);
            $table->dropForeign(['entrepot_id']);

            $table->foreign('vente_id')
                ->references('vente_id')
                ->on('ventes')
                ->onDelete('restrict');

            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->onDelete('restrict');

            $table->foreign('entrepot_id')
                ->references('entrepot_id')
                ->on('entrepots')
                ->onDelete('restrict');
        });
    }
};
