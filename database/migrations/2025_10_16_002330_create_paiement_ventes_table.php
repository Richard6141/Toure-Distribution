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
        Schema::create('paiement_ventes', function (Blueprint $table) {
            $table->uuid('paiement_vente_id')->primary();
            $table->uuid('vente_id');
            $table->string('reference_paiement', 50)->unique(); // Auto-généré: PAYV-YYYY-0001
            $table->decimal('montant', 15, 2);
            $table->enum('mode_paiement', [
                'especes',
                'cheque',
                'virement',
                'carte_bancaire',
                'mobile_money',
                'credit' // Paiement à crédit
            ]);
            $table->enum('statut', [
                'en_attente',
                'valide',
                'refuse',
                'annule'
            ])->default('en_attente');
            $table->dateTime('date_paiement');
            $table->string('numero_transaction')->nullable();
            $table->string('numero_cheque')->nullable();
            $table->string('banque')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Clé étrangère
            $table->foreign('vente_id')
                ->references('vente_id')
                ->on('ventes')
                ->onDelete('restrict');

            // Index
            $table->index(['vente_id', 'statut']);
            $table->index('date_paiement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_ventes');
    }
};
