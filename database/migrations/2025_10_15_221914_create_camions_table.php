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
        Schema::create('camions', function (Blueprint $table) {
            $table->uuid('camion_id')->primary();
            $table->string('numero_immat')->unique(); // Numéro d'immatriculation unique
            $table->string('marque'); // Marque du camion
            $table->string('modele')->nullable(); // Modèle du camion
            $table->decimal('capacite', 8, 2); // Capacité en tonnes (ex: 15.50)
            $table->enum('status', ['disponible', 'en_mission', 'en_maintenance', 'hors_service'])
                ->default('disponible');
            $table->text('note')->nullable(); // Notes ou observations
            $table->timestamps(); // created_at et updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camions');
    }
};
