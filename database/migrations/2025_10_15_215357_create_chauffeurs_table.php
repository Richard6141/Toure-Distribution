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
        Schema::create('chauffeurs', function (Blueprint $table) {
            $table->uuid('chauffeur_id')->primary();
            $table->string('name');
            $table->string('phone', 20); // String pour gérer les formats internationaux
            $table->string('numero_permis')->unique(); // Unique pour éviter les doublons
            $table->date('date_expiration_permis');
            $table->enum('status', ['actif', 'inactif', 'en_conge'])->default('actif');
            $table->timestamps(); // created_at et updated_at
            $table->softDeletes(); // deleted_at (optionnel)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chauffeurs');
    }
};
