<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cust_id')->default(0);
            $table->integer('cust_add_id')->default(0);
            $table->integer('cust_card_id')->default(0);
            $table->integer('prod_id')->default(0);
            $table->string('qty')->nullable();
            $table->float('amount')->default(0);
            $table->string('payment_id')->nullable();
            $table->integer('mode')->default(0); // 1=cash on delivery,2=online
            $table->integer('status')->default(1); //1=pending,2=confirm,3=shipped,4=cancel,5=deliver           
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
        Schema::dropIfExists('orders');
    }
}
