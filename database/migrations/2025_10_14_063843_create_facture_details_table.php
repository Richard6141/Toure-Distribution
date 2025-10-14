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
        Schema::create('facture_details', function (Blueprint $table) {
            $table->uuid('facture_detail_id')->primary();

            // Relation avec la facture
            $table->uuid('facture_id')->nullable();
            $table->foreign('facture_id')
                ->references('facture_id')
                ->on('factures')
                ->onDelete('cascade');

            // Relation avec le produit
            $table->uuid('product_id')->nullable();
            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('restrict');

            // Informations de ligne
            $table->double('quantite')->default(0);
            $table->decimal('prix_unitaire', 15, 2)->default(0);
            $table->decimal('montant_total', 15, 2)->default(0)
                ->comment('quantite × prix_unitaire');

            $table->decimal('taxe_rate', 5, 2)->default(0)
                ->comment('Taux de taxe (%) pour cette ligne');
            $table->decimal('discount_amount', 15, 2)->default(0)
                ->comment('Remise appliquée sur la ligne');

            $table->timestamps();

            // Index pour accélérer les requêtes
            $table->index(['facture_id'], 'idx_facture');
            $table->index(['product_id'], 'idx_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_details');
    }
};