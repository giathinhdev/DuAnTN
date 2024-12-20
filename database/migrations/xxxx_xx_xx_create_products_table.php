use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            // ... other columns
            $table->tinyInteger('status')->default(1); // Thay vì boolean
            // ... other columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
} 