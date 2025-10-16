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
        Schema::create('deliveries', function (Blueprint $table) {
            // Clé primaire
            $table->uuid('delivery_id')->primary();

            // Référence unique
            $table->string('reference', 50)->unique()->comment('Format: LIV-YYYY-0001');

            // Relations principales
            $table->uuid('vente_id');
            $table->uuid('client_id');
            $table->uuid('entrepot_id')->comment('Entrepôt source de la livraison');
            $table->uuid('chauffeur_id')->nullable();
            $table->uuid('camion_id')->nullable();

            // Dates et heures
            $table->dateTime('date_livraison_prevue')->nullable();
            $table->dateTime('date_livraison_reelle')->nullable();
            $table->time('heure_depart')->nullable();
            $table->time('heure_arrivee')->nullable();

            // Statut de la livraison
            $table->enum('statut', [
                'en_preparation',    // En cours de préparation
                'prete',            // Prête à partir
                'en_transit',       // En cours de livraison
                'livree',           // Livrée complètement
                'livree_partiellement', // Livrée partiellement
                'annulee',          // Annulée
                'retournee'         // Retournée
            ])->default('en_preparation');

            // Informations de livraison
            $table->text('adresse_livraison')->nullable();
            $table->string('contact_livraison', 100)->nullable();
            $table->string('telephone_livraison', 20)->nullable();

            // Notes et observations
            $table->text('note')->nullable();
            $table->text('observation')->nullable()->comment('Observations du chauffeur à la livraison');

            // Signature et preuve
            $table->string('signature_client')->nullable()->comment('Chemin vers la signature numérique');
            $table->json('photos')->nullable()->comment('Photos de la livraison');

            // Utilisateur qui a créé la livraison
            $table->uuid('created_by')->nullable();

            // Timestamps et soft delete
            $table->timestamps();
            $table->softDeletes();

            // Clés étrangères
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

            $table->foreign('chauffeur_id')
                ->references('chauffeur_id')
                ->on('chauffeurs')
                ->onDelete('set null');

            $table->foreign('camion_id')
                ->references('camion_id')
                ->on('camions')
                ->onDelete('set null');

            $table->foreign('created_by')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');

            // Index pour améliorer les performances
            $table->index(['statut', 'date_livraison_prevue']);
            $table->index(['vente_id', 'statut']);
            $table->index(['chauffeur_id', 'date_livraison_prevue']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
