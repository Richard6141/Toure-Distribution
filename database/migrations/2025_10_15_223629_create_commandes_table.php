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
        Schema::create('commandes', function (Blueprint $table) {
            $table->uuid('commande_id')->primary();
            $table->string('numero_commande', 50)->unique(); // Numéro de commande unique
            $table->uuid('fournisseur_id');
            $table->date('date_achat');
            $table->date('date_livraison_prevue');
            $table->date('date_livraison_effective')->nullable(); // Date de livraison réelle
            $table->decimal('montant', 15, 2); // Montant avec 2 décimales
            $table->enum('status', [
                'en_attente',
                'validee',
                'en_cours',
                'livree',
                'partiellement_livree',
                'annulee'
            ])->default('en_attente');
            $table->text('note')->nullable(); // Notes ou observations
            $table->timestamps();
            $table->softDeletes();

            // Clé étrangère vers fournisseurs
            $table->foreign('fournisseur_id')
                ->references('fournisseur_id')
                ->on('fournisseurs')
                ->onDelete('restrict'); // Empêche la suppression d'un fournisseur avec des commandes

            // Index pour améliorer les performances
            $table->index(['status', 'date_achat']);
            $table->index('date_livraison_prevue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
