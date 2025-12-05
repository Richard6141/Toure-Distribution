<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Table pour enregistrer les paiements clients effectués à la caisse.
     * Ces paiements servent à régler les dettes des clients (solde négatif).
     */
    public function up(): void
    {
        Schema::create('client_payments', function (Blueprint $table) {
            $table->uuid('payment_id')->primary();
            $table->string('reference')->unique()->comment('Référence unique du paiement (PAY-CLI-YYYY-0001)');

            // Relation avec le client
            $table->uuid('client_id');
            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->onDelete('cascade');

            // Informations du paiement
            $table->decimal('montant', 15, 2)->comment('Montant payé par le client');
            $table->decimal('ancien_solde', 15, 2)->comment('Solde du client avant le paiement');
            $table->decimal('nouveau_solde', 15, 2)->comment('Solde du client après le paiement');

            // Mode de paiement
            $table->enum('mode_paiement', ['especes', 'cheque', 'virement', 'mobile_money', 'carte'])
                ->default('especes')
                ->comment('Mode de paiement utilisé');

            // Informations complémentaires selon le mode de paiement
            $table->string('numero_transaction')->nullable()->comment('Numéro de transaction (mobile money, virement)');
            $table->string('numero_cheque')->nullable()->comment('Numéro du chèque');
            $table->string('banque')->nullable()->comment('Banque émettrice (pour chèque ou virement)');

            // Note optionnelle
            $table->text('note')->nullable()->comment('Note ou commentaire sur le paiement');

            // Date et heure du paiement
            $table->datetime('date_paiement')->comment('Date et heure du paiement');

            // Caissier qui a enregistré le paiement
            $table->uuid('caissier_id')->nullable();
            $table->foreign('caissier_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            // Index pour améliorer les performances des requêtes courantes
            $table->index(['client_id', 'created_at']);
            $table->index('mode_paiement');
            $table->index('date_paiement');
            $table->index('caissier_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_payments');
    }
};
