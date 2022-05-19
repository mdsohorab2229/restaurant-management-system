<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('nick_name')->nullable();
            $table->text('discription')->nullable();
            $table->double('cost',8,2);
            $table->double('price',8,2);
            $table->double('discount',8,2)->nullable();
            $table->string('discount_method')->nullable()->comment('0=Amount, 1=Percentage(%)');
            $table->string('photo')->nullable();
            $table->string('availability')->default(1)->comment('0=Not Available, 1=Available');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('menus');
    }
}
