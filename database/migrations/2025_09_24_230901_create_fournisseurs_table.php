<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->uuid('fournisseur_id')->primary();
            $table->string('code', 50)->unique()->comment('Code unique du fournisseur');
            $table->string('name')->comment('Nom du fournisseur');
            $table->string('responsable')->nullable()->comment('Personne responsable');
            $table->string('adresse')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('payment_terms')->nullable()->comment('Conditions de paiement');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['name', 'city', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fournisseurs');
    }
};
