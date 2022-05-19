<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuffetincludecarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buffetincludecars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buffetcar_id');
            $table->string('car_number');
            $table->string('supervisor_name');
            $table->string('phone');
            $table->string('arrival_time');
            $table->string('from');
            $table->double('amount',8,2)->nullable();
            $table->double('paid_amount',8,2)->nullable();
            $table->double('due',8,2)->nullable();
            $table->string('discription')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('buffetincludecars');
    }
}
