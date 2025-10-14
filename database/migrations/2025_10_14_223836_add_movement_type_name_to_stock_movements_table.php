<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            // Nouveau champ saisi manuellement
            $table->string('movement_type')
                ->nullable()
                ->after('reference')
                ->comment('Type de mouvement saisi manuellement');
        });
    }

    public function down(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropColumn('movement_type');
        });
    }
};
