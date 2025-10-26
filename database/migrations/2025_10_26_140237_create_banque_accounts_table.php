<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banque_accounts', function (Blueprint $table) {
            $table->uuid('banque_account_id')->primary();
            $table->foreignUuid('banque_id')->constrained('banques', 'banque_id')->onDelete('cascade');
            $table->string('account_number')->unique();
            $table->string('account_name');
            $table->enum('account_type', ['courant', 'epargne', 'depot'])->default('courant');
            $table->string('titulaire');
            $table->decimal('balance', 15, 2)->default(0);
            $table->enum('statut', ['actif', 'inactif', 'suspendu', 'cloture'])->default('actif');
            $table->date('date_ouverture');
            $table->boolean('isActive')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Index pour optimiser les recherches
            $table->index('account_number');
            $table->index('banque_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banque_accounts');
    }
};
