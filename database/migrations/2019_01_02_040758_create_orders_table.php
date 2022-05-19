<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned()->nullable();
            $table->integer('order_no');
            $table->integer('waiter_id');
            $table->integer('chief_id')->nullable();
            $table->integer('table_id');
            $table->integer('sub_total');
            $table->double('discount', 8,2)->default(0.00);
            $table->double('tax', 8,2)->nullable();
            $table->double('amount');
            $table->string('status')->default(0)->comment('0=Panding, 1=Processing, 2=Complete , 3=Cancel');
            $table->string('confirm_status')->default(0)->comment('0=Not prepared, 1=Prepared');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
