<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_no');
            $table->integer('guest_id');
            $table->string('adults');
            $table->string('children')->nullable();
            $table->string('arrival');
            $table->string('departure');
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->integer('checking')->default(0)->comment('0=checking_in, 1=checking_out, 2=checking_cancel');
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
        Schema::dropIfExists('room_bookings');
    }
}
