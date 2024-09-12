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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id', 65)->unique();
            $table->string('stock_no', 65);
            $table->string('var', 65);
            $table->integer('amount');
            $table->integer('mrp_amount');
            $table->text('product_description');
            $table->string('category');
            $table->string('sub_category');
            $table->string('material_type');
            $table->string('finish');
            $table->string('tool_size');
            $table->string('minimum_order_quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
