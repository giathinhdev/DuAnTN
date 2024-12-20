<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// CreateTablesTable.php
public function up()
{
    Schema::create('tables', function (Blueprint $table) {
        $table->id(); // PK
        $table->string('type');
        $table->integer('capacity');
        $table->string('status'); // e.g., available, booked
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('tables');
}


};
