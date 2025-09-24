<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('product_id')->primary();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();

            $table->uuid('product_category_id');
            $table->foreign('product_category_id')
                ->references('product_category_id')
                ->on('product_categories')
                ->onDelete('cascade');

            $table->decimal('unit_price', 12, 2);
            $table->decimal('cost', 12, 2)->default(0);
            $table->decimal('minimum_cost', 12, 2)->default(0);
            $table->integer('min_stock_level')->default(0)->comment('Quantité minimum en stock');
            $table->boolean('is_active')->default(true);
            $table->string('picture')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['product_category_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};