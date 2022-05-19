<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('guest_id');
            $table->integer('room_booking_id');
            $table->date('payment_date');
            $table->string('payment_method')->nullable();
            $table->string('transaction_no')->nullable();
            $table->string('card_no')->nullable();
            $table->double('sub_total', 8,2)->nullable();
            $table->double('discount', 8,2)->nullable();
            $table->double('vat', 8,2)->nullable();
            $table->double('grand_total', 8,2)->nullable();
            $table->double('paid_amount', 8,2)->nullable();
            $table->double('due', 8,2)->nullable();
            $table->text('comment')->nullable();
            $table->integer('status')->default(1)->comment('0=Inactive, 1=Active');
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
        Schema::dropIfExists('guest_payments');
    }
}
