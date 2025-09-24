<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->uuid('stock_movement_id')->primary();
            $table->string('reference')->unique()->comment('Numéro du mouvement');

            // Type de mouvement
            $table->uuid('movement_type_id')->nullable();
            $table->foreign('movement_type_id')
                ->references('stock_movement_type_id')
                ->on('stock_movement_types')
                ->onDelete('set null');

            // Entrepôts
            $table->uuid('entrepot_from_id')->nullable();
            $table->foreign('entrepot_from_id')
                ->references('entrepot_id')
                ->on('entrepots')
                ->onDelete('set null');

            $table->uuid('entrepot_to_id')->nullable();
            $table->foreign('entrepot_to_id')
                ->references('entrepot_id')
                ->on('entrepots')
                ->onDelete('set null');

            // Fournisseur et client
            $table->uuid('fournisseur_id')->nullable();
            $table->uuid('client_id')->nullable();

            // Statut et note
            $table->string('statut')->default('enregistré');
            $table->text('note')->nullable();

            // Utilisateur
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            // Index avec noms courts pour éviter la limite de 64 caractères
            $table->index(['movement_type_id'], 'idx_movement_type');
            $table->index(['entrepot_from_id'], 'idx_entrepot_from');
            $table->index(['entrepot_to_id'], 'idx_entrepot_to');
            $table->index(['client_id'], 'idx_client');
            $table->index(['user_id'], 'idx_user');
            $table->index(['statut', 'created_at'], 'idx_statut_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};