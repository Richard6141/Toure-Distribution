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
        Schema::create('stock_movement_details', function (Blueprint $table) {
            // Clé primaire
            $table->uuid('stock_movement_detail_id')->primary();

            // Référence au mouvement de stock
            $table->uuid('stock_movement_id');
            $table->foreign('stock_movement_id')
                ->references('stock_movement_id')
                ->on('stock_movements')
                ->onDelete('cascade');

            // Référence au produit
            $table->uuid('product_id')->nullable();
            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('set null');

            // Quantité
            $table->integer('quantite')->default(0);

            // Timestamps et soft deletes
            $table->timestamps();
            $table->softDeletes();

            // Index pour améliorer les performances
            $table->index(['stock_movement_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movement_details');
    }
};