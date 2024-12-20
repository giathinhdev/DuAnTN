<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// CreateOrderItemsTable.php
public function up()
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id(); // PK
        $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade'); // FK
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // FK
        $table->integer('quantity');
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('order_items');
}


};