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
        Schema::create('client_phones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id');
            $table->string('phone_number', 20);
            $table->enum('type', ['mobile', 'fixe', 'whatsapp', 'autre'])->default('mobile');
            $table->string('label')->nullable(); // Ex: "Bureau", "Personnel", etc.
            $table->timestamps();

            // Clés étrangères
            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->onDelete('cascade');

            // Index pour améliorer les performances
            $table->index('client_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_phones');
    }
};
