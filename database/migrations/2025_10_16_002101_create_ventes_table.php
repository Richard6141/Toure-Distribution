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
        Schema::create('ventes', function (Blueprint $table) {
            $table->uuid('vente_id')->primary();
            $table->string('numero_vente', 50)->unique(); // Auto-généré: VTE-YYYY-0001
            $table->uuid('client_id');
            $table->dateTime('date_vente');
            $table->decimal('montant_ht', 15, 2)->default(0); // Montant Hors Taxe
            $table->decimal('montant_taxe', 15, 2)->default(0); // Montant de la taxe (TVA)
            $table->decimal('montant_total', 15, 2); // Montant TTC
            $table->decimal('remise', 15, 2)->default(0); // Remise accordée
            $table->decimal('montant_net', 15, 2); // Montant final après remise
            $table->enum('status', [
                'en_attente',      // En attente de validation
                'validee',         // Vente validée
                'livree',          // Vente livrée
                'partiellement_livree', // Livraison partielle
                'annulee'          // Vente annulée
            ])->default('en_attente');
            $table->enum('statut_paiement', [
                'non_paye',
                'paye_partiellement',
                'paye_totalement'
            ])->default('non_paye');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Clé étrangère vers clients
            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->onDelete('restrict');

            // Index pour améliorer les performances
            $table->index(['client_id', 'status']);
            $table->index(['date_vente', 'statut_paiement']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
