<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_balance_adjustments', function (Blueprint $table) {
            $table->uuid('adjustment_id')->primary();
            $table->string('reference')->unique()->comment('Numéro de référence unique (ADJ-YYYY-0001)');

            // Client concerné
            $table->uuid('client_id');
            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->onDelete('cascade');

            // Type d'ajustement
            $table->enum('type', [
                'dette_initiale',      // Dette importée de l'ancien système
                'ajustement_credit',   // Augmentation du solde (client doit plus)
                'ajustement_debit',    // Diminution du solde (réduction de dette)
                'correction',          // Correction d'erreur
                'remise_exceptionnelle' // Remise accordée au client
            ])->default('dette_initiale');

            // Montants
            $table->decimal('montant', 15, 2)->comment('Montant de l\'ajustement (positif ou négatif)');
            $table->decimal('ancien_solde', 15, 2)->comment('Solde avant ajustement');
            $table->decimal('nouveau_solde', 15, 2)->comment('Solde après ajustement');

            // Informations
            $table->string('motif')->comment('Raison de l\'ajustement');
            $table->text('note')->nullable()->comment('Notes supplémentaires');
            $table->string('source')->default('manuel')->comment('Source: migration, manuel, import');

            // Date de l'ajustement
            $table->datetime('date_ajustement');

            // Utilisateur qui a effectué l'ajustement
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            // Index pour les recherches fréquentes
            $table->index(['client_id', 'created_at'], 'idx_client_date');
            $table->index(['type'], 'idx_type');
            $table->index(['source'], 'idx_source');
            $table->index(['date_ajustement'], 'idx_date_ajustement');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_balance_adjustments');
    }
};
