<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->double('quantity');
            $table->integer('unit_id')->unsigned();
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->double('price')->nullable();
            $table->double('total_price')->nullable();
            $table->integer('status')->default(1)->comment('0=Pending, 1=Approved, 2=canceled');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_prices');
    }
}
