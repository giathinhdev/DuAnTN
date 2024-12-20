<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // PK
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // FK
            $table->string('name');
            $table->string('img')->nullable(); // Hình ảnh có thể NULL
            $table->text('description')->nullable(); // Thay đổi để cho phép NULL
            $table->decimal('sale_price', 10, 2)->nullable(); // Giảm giá có thể NULL
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};