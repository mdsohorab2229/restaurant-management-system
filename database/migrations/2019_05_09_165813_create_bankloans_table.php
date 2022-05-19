<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankloansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankloans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('banklist_id');
            $table->string('loan_term');
            $table->string('loan_type');
            $table->string('loan_duration');
            $table->double('amount',8,2);
            $table->double('interest',8,2);
            $table->date('submit_date');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('bankloans');
    }
}
