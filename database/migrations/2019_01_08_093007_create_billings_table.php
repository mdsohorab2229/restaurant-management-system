<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('order_id');
            $table->double('deposit',8,2);
            $table->integer('type')->comment('0=Cash,1=Check , 2=Bksh, 3=Rocket, 4=Card');
            $table->string('transaction')->nullable()->comment('transaction number');
            $table->string('card')->nullable()->comment('Card number');
            $table->double('due',8,2);
            $table->double('profit',8,2);
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
        Schema::dropIfExists('billings');
    }
}
