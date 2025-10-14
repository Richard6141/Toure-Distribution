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
        Schema::create('paiements', function (Blueprint $table) {
            $table->uuid('paiement_id')->primary();

            // Référence unique du paiement
            $table->string('reference')->unique();

            // Relation avec la facture
            $table->uuid('facture_id');
            $table->foreign('facture_id')
                ->references('facture_id')
                ->on('factures')
                ->onDelete('cascade');

            // Relation avec le client
            $table->uuid('client_id');
            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->onDelete('cascade');

            // Relation avec le mode de paiement
            $table->uuid('payment_method_id');
            $table->foreign('payment_method_id')
                ->references('payment_method_id')
                ->on('payment_methods')
                ->onDelete('cascade');

            // Informations du paiement
            $table->decimal('amount', 15, 2);
            $table->dateTime('payment_date')->default(now());
            $table->text('note')->nullable();

            $table->string('statut')
                ->default('pending')
                ->comment('pending, confirmé, cancelled');

            // Utilisateur
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamps();

            // Index optimisés
            $table->index(['facture_id'], 'idx_facture');
            $table->index(['client_id'], 'idx_client');
            $table->index(['statut'], 'idx_statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
