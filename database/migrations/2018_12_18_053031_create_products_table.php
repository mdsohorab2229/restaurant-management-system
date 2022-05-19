<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned()->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_barcode')->nullable();
            $table->string('name');
            $table->text('discription')->nullable();
            $table->integer('product_category_id')->unsigned();
            $table->integer('brand_id')->unsigned()->nullable();
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->double('cost', 8,2)->nullable();
            $table->integer('status')->default(1)->comment('0=Inactive, 1=Active');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
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
