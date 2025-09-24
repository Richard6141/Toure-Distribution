<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entrepots', function (Blueprint $table) {
            $table->uuid('entrepot_id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('adresse')->nullable();
            $table->boolean('is_active')->default(true);

            $table->uuid('user_id')->nullable(); // nullable pour set null si user supprimé

            $table->timestamps();

            // Clé étrangère sans cascade
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');

            $table->index(['user_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrepots');
    }
};