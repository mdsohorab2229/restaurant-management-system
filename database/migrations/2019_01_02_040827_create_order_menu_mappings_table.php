<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMenuMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_menu_mappings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->integer('menu_id')->unsigned()->nullable();
            $table->double('cost')->default(0)->nullable();
            $table->double('sell_price')->default(0)->nullable();
            $table->double('quantity');
            $table->double('price');
            $table->integer('type')->default(0)->comment('0=Order, 1=Reorder');
            $table->integer('served_status')->default(0)->comment('0=pending, 1=served');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('order_menu_mappings');
    }
}
