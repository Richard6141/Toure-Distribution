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
        Schema::create('detail_ventes', function (Blueprint $table) {
            $table->uuid('detail_vente_id')->primary();
            $table->uuid('vente_id');
            $table->uuid('product_id');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 12, 2);
            $table->decimal('remise_ligne', 12, 2)->default(0); // Remise sur la ligne
            $table->decimal('montant_ht', 12, 2); // Montant HT de la ligne
            $table->decimal('taux_taxe', 5, 2)->default(0); // Taux de taxe en %
            $table->decimal('montant_taxe', 12, 2)->default(0); // Montant de la taxe
            $table->decimal('montant_ttc', 12, 2); // Montant TTC de la ligne
            $table->timestamps();
            $table->softDeletes();

            // Clés étrangères
            $table->foreign('vente_id')
                ->references('vente_id')
                ->on('ventes')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('restrict');

            // Index
            $table->index('vente_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_ventes');
    }
};
