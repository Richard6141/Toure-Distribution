<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movement_types', function (Blueprint $table) {
            $table->uuid('stock_movement_type_id')->primary();
            $table->string('name')->unique();
            $table->enum('direction', ['in', 'out', 'transfer']);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['name', 'direction']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movement_types');
    }
};