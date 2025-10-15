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
        Schema::create('detail_commandes', function (Blueprint $table) {
            $table->uuid('detail_commande_id')->primary();
            $table->uuid('commande_id'); // Correction: commande_id au lieu de command_id
            $table->uuid('product_id');
            $table->integer('quantite')->unsigned();
            $table->decimal('prix_unitaire', 12, 2);
            $table->decimal('sous_total', 12, 2)->storedAs('quantite * prix_unitaire'); // Colonne calculée
            $table->timestamps();
            $table->softDeletes();

            // Clés étrangères
            $table->foreign('commande_id')
                ->references('commande_id')
                ->on('commandes')
                ->onDelete('cascade'); // Supprime les détails si la commande est supprimée

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('restrict'); // Empêche la suppression d'un produit utilisé

            // Index pour améliorer les performances
            $table->index(['commande_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_commandes');
    }
};
