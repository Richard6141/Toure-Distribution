<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Commande pour créer cette migration :
 * php artisan make:migration create_delivery_details_table
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_details', function (Blueprint $table) {
            // Clé primaire
            $table->uuid('delivery_detail_id')->primary();

            // Relation avec la livraison
            $table->uuid('delivery_id');

            // Produit concerné
            $table->uuid('product_id');

            // Quantités
            $table->integer('quantite_commandee')->default(0)->comment('Quantité dans la vente');
            $table->integer('quantite_preparee')->default(0)->comment('Quantité préparée pour livraison');
            $table->integer('quantite_livree')->default(0)->comment('Quantité réellement livrée');
            $table->integer('quantite_retournee')->default(0)->comment('Quantité retournée');

            // Statut du détail
            $table->enum('statut', [
                'en_attente',
                'en_preparation',
                'pret',
                'livre',
                'partiellement_livre',
                'retourne',
                'manquant'
            ])->default('en_attente');

            // Informations complémentaires
            $table->text('note')->nullable()->comment('Note sur ce produit');
            $table->string('raison_ecart')->nullable()->comment('Raison si quantité livrée différente');
            $table->decimal('poids', 10, 2)->nullable()->comment('Poids du produit en kg');
            $table->decimal('volume', 10, 2)->nullable()->comment('Volume en m³');

            // Référence au détail de vente correspondant
            $table->uuid('detail_vente_id')->nullable();

            // Timestamps et soft delete
            $table->timestamps();
            $table->softDeletes();

            // Clés étrangères
            $table->foreign('delivery_id')
                ->references('delivery_id')
                ->on('deliveries')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('restrict');

            $table->foreign('detail_vente_id')
                ->references('detail_vente_id')
                ->on('detail_ventes')
                ->onDelete('set null');

            // Index pour améliorer les performances
            $table->index(['delivery_id', 'product_id']);
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_details');
    }
};
