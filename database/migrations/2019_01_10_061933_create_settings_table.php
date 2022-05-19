<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurant_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_suffix')->nullable();
            $table->string('currency_prefix')->nullable();
            $table->double('discount', 8, 2)->nullable();
            $table->string('discount_type')->nullable()->comment('amount, percentage');
            $table->string('discount_switch')->nullable()->comment('discount on/off');
            $table->double('tax', 8, 2)->nullable();
            $table->string('tax_type')->nullable()->comment('always percentage');
            $table->string('tax_switch')->nullable()->comment('tax on/off');
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
        Schema::dropIfExists('settings');
    }
}
