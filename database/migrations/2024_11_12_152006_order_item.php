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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id'); // Primary Key
            $table->unsignedBigInteger('order_id'); // Foreign Key for orders table
            $table->unsignedBigInteger('product_id'); // Foreign Key for products table
            $table->integer('quantity');
            $table->decimal('item_price', 10, 2);
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade'); // order_id references orders
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade'); // product_id references products
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
