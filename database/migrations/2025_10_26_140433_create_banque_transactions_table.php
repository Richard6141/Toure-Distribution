<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banque_transactions', function (Blueprint $table) {
            $table->uuid('banque_transaction_id')->primary();
            $table->foreignUuid('banque_account_id')->constrained('banque_accounts', 'banque_account_id')->onDelete('cascade');
            $table->string('transaction_number')->unique();
            $table->date('transaction_date');
            $table->enum('transaction_type', ['debit', 'credit', 'virement', 'cheque', 'retrait', 'depot'])->default('credit');
            $table->decimal('montant', 15, 2);
            $table->text('libelle');
            $table->string('reference_externe')->nullable()->comment('Numéro de chèque ou référence bancaire');
            $table->string('tiers')->nullable()->comment('Destinataire ou émetteur');
            $table->enum('status', ['en_attente', 'valide', 'rejete', 'annule'])->default('en_attente');
            $table->timestamps();
            $table->softDeletes();

            // Index pour optimiser les recherches
            $table->index('transaction_number');
            $table->index('transaction_date');
            $table->index('banque_account_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banque_transactions');
    }
};
