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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->uuid('payment_method_id')->primary(); // Nom de clé plus standard
            $table->string('name'); // Le nom du moyen de paiement doit être une chaîne de caractères
            $table->boolean('is_active')->default(true); // booléen, pas bigInteger
            $table->timestamps(); // pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};