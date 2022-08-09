<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReampOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('orders'); // drop existing orders table
        Schema::create('orders', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('order_number');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->string('order_type');
            $table->unsignedDouble('subtotal');
            $table->unsignedDouble('discount');
            $table->unsignedDouble('total_amount');
            $table->string('payment_status');
            $table->string('order_status');
            $table->string('transaction_number')->nullable();
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
