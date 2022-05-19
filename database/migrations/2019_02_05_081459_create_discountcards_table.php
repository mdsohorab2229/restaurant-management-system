<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discountcards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('cardnumber');
            $table->string('discount');
            $table->string('expiredate');
            $table->integer('status')->default(0)->comment('0=Not Used, 1=Used');
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
        Schema::dropIfExists('discountcards');
    }
}
