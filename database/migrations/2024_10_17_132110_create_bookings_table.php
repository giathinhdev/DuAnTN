<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// CreateBookingsTable.php
public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id(); // PK
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK
        $table->foreignId('table_id')->constrained('tables')->onDelete('cascade'); // FK
        $table->string('name');
        $table->string('phone');
        $table->string('message');
        $table->date('booking_date');
        $table->time('booking_time');
        $table->integer('number_of_guests');
        $table->string('payment_method');
        $table->dateTime('payment_date')->nullable();
        $table->string('booking_status'); // e.g., confirmed, canceled
        $table->string('order_status'); // e.g., paid, pending
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('bookings');
}

};
