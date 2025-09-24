<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->uuid('stock_id')->primary();

            $table->uuid('product_id')->nullable();
            $table->uuid('entrepot_id')->nullable();

            $table->integer('quantite')->default(0);
            $table->integer('reserved_quantity')->default(0)->comment('Quantité réservée dans un entrepôt');

            $table->timestamps();
            $table->softDeletes();

            // Clés étrangères
            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('entrepot_id')
                ->references('entrepot_id')
                ->on('entrepots')
                ->onDelete('cascade');

            $table->index(['product_id', 'entrepot_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};