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
        Schema::create('paiement_commandes', function (Blueprint $table) {
            $table->uuid('paiement_commande_id')->primary();
            $table->uuid('commande_id');
            $table->string('reference_paiement', 50)->unique(); // Référence unique auto-générée
            $table->decimal('montant', 15, 2); // Montant payé
            $table->enum('mode_paiement', [
                'especes',
                'cheque',
                'virement',
                'carte_bancaire',
                'mobile_money'
            ]);
            $table->enum('statut', [
                'en_attente',
                'valide',
                'refuse',
                'annule'
            ])->default('en_attente');
            $table->dateTime('date_paiement'); // Date et heure du paiement
            $table->string('numero_transaction')->nullable(); // Pour paiements électroniques
            $table->string('numero_cheque')->nullable(); // Pour paiements par chèque
            $table->string('banque')->nullable(); // Banque émettrice (chèque/virement)
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Clé étrangère vers commandes
            $table->foreign('commande_id')
                ->references('commande_id')
                ->on('commandes')
                ->onDelete('restrict');

            // Index pour améliorer les performances
            $table->index(['commande_id', 'statut']);
            $table->index('date_paiement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_commandes');
    }
};
