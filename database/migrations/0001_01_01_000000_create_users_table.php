<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('phonenumber')->nullable();
            $table->string('poste')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            // Améliorations essentielles
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->timestamp('password_changed_at')->nullable();

            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            // Index essentiels
            $table->index(['email', 'is_active']);
            $table->index('username');
        });

        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->nullable();
            $table->string('email')->nullable();
            $table->string('ip_address', 45);
            $table->enum('status', ['success', 'failed'])->default('failed');
            $table->string('failure_reason')->nullable();
            $table->timestamp('attempted_at');

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->index(['email', 'attempted_at']);
            $table->index(['ip_address', 'attempted_at']);
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
            $table->timestamp('created_at')->nullable();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });

        // SUPPRIMÉ : personal_access_tokens (déjà créée par Sanctum)
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('login_attempts');
        Schema::dropIfExists('users');
        // NE PAS supprimer personal_access_tokens car elle appartient à Sanctum
    }
};