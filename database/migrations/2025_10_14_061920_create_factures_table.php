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
        Schema::create('factures', function (Blueprint $table) {
            $table->uuid('facture_id')->primary();
            $table->string('facture_number')->unique();
            $table->string('reference')->nullable();
            $table->uuid('client_id')->nullable();

            // Informations de facture
            $table->dateTime('facture_date');
            $table->date('due_date')->nullable();

            $table->decimal('montant_ht', 15, 2)->default(0);
            $table->decimal('taxe_rate', 5, 2)->default(0); // taux de taxe (%)
            $table->decimal('transport_cost', 15, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0)
                ->comment('Montant payé par le client');

            $table->string('statut')->default('en attente')
                ->comment('payé, retard, brouillon');
            $table->string('delivery_adresse')->nullable();
            $table->text('note')->nullable();
            // Relation avec client

            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->onDelete('cascade');

            // Utilisateur qui a créé la facture
            $table->uuid('user_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};