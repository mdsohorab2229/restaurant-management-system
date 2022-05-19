<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('occupation')->comment("0=Std,1=Govt,2=Private,3=Busness,4=Others");
            $table->string('organization')->nullable();
            $table->string('organization_address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('birthdate')->nullable();
            $table->string('identity_no')->comment("NID/Passpoart No");
            $table->integer('district_id');
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('guests');
    }
}
