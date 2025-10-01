<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('client_id')->primary();
            $table->string('code')->unique();
            $table->string('name_client');
            $table->string('name_representant')->nullable();
            $table->string('marketteur')->nullable();
            $table->uuid('client_type_id')->nullable();
            $table->foreign('client_type_id')
                ->references('client_type_id')
                ->on('client_types')
                ->onDelete('set null');

            $table->string('adresse')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('ifu')->unique()->nullable();
            $table->string('phonenumber', 20)->nullable();
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->double('base_reduction')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['client_type_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
