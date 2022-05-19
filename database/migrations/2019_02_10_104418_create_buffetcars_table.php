<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuffetcarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buffetcars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment("car/company name");
            $table->string('address');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->double('amount',8,2);
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
        Schema::dropIfExists('buffetcars');
    }
}
