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
        Schema::table('products', function (Blueprint $table) {
            $table->string('unit_of_measure', 20)
                ->default('unit')
                ->after('unit_price')
                ->comment('Unité de mesure: kg, t, l, pcs, m, m², m³, etc.');

            $table->decimal('unit_weight', 10, 4)
                ->nullable()
                ->after('unit_of_measure')
                ->comment('Poids unitaire en kg (pour calcul du tonnage)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['unit_of_measure', 'unit_weight']);
        });
    }
};
