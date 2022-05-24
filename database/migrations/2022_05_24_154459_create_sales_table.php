<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', $precision = 10, $scale = 2)->default(0);
            $table->integer('items');
            $table->decimal('cash', $precision = 10, $scale = 2);
            $table->decimal('change', $precision = 10, $scale = 2);
            $table->enum('status', ['PAID', 'PENDING', 'CANCELLED'])->default('PAID');
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('sales');
    }
}
