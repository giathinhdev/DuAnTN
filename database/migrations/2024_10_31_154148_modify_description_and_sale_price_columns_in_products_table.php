<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDescriptionAndSalePriceColumnsInProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->change(); // Thay đổi cột description thành nullable
            $table->decimal('sale_price', 10, 2)->nullable()->change(); // Thay đổi cột sale_price thành nullable
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change(); // Khôi phục lại cột description không nullable
            $table->decimal('sale_price', 10, 2)->nullable(false)->change(); // Khôi phục lại cột sale_price không nullable
        });
    }
}

