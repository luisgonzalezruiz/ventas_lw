<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('barcode', 25)->unique()->nullable();
            $table->decimal('cost', $precision = 10, $scale = 2)->default(0);
            $table->decimal('price', $precision = 10, $scale = 2)->default(0);
            $table->integer('stock');
            $table->integer('alerts');
            $table->string('image', 100)->nullable();
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
