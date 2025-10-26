<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banques', function (Blueprint $table) {
            $table->uuid('banque_id')->primary();
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->string('adresse')->nullable();
            $table->string('contact_info')->nullable();
            $table->boolean('isActive')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banques');
    }
};
