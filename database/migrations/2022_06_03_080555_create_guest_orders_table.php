<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prod_id')->default(0);
            $table->integer('qty')->default(0);
            $table->string('cust_name')->nullable();
            $table->string('cust_email')->nullable();
            $table->string('cust_mobile')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('apartment')->nullable();
            $table->string('faddress')->nullable();
            $table->string('payment_id')->nullable();
            $table->integer('mode')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guest_orders');
    }
}
