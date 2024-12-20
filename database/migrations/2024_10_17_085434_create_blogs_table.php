<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// CreateBlogsTable.php
public function up()
{
    Schema::create('blogs', function (Blueprint $table) {
        $table->id(); // PK
        $table->foreignId('users_id')->constrained('users')->onDelete('cascade'); // FK
        $table->string('title');
        $table->string('img')->nullable(); // Optional image URL
        $table->text('content');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('blogs');
}

};
