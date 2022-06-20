<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->integer('category_id')->default(0);
            $table->integer('brand_id')->default(0);
            $table->string('unit')->nullable();
            $table->integer('min_qty')->default(0);
            $table->string('tags')->nullable();
            $table->string('barcode')->nullable();
            $table->string('featured_img',2000)->nullable();
            $table->string('video_provider')->nullable();
            $table->string('videolink')->nullable();
            $table->float('unit_price')->default(0);
            $table->float('discount')->default(0);
            $table->string('price_discount_unit')->nullable();
            $table->float('points')->default(0);
            $table->integer('qty')->default(0);
            $table->string('sku')->nullable();
            $table->string('short_desc',2000)->nullable();
            $table->text('long_desc')->nullable();
            $table->string('shiping_type')->nullable();
            $table->float('flat_shipping_cost')->default(0);
            $table->integer('mul_prod_qty')->default(0);
            $table->integer('low_qty_warning')->default(0);
            $table->string('stock_visibilty')->nullable();
            $table->integer('featured_status')->default(0);
            $table->integer('todays_deal')->default(0);
            $table->string('shiping_time')->nullable();
            $table->float('tax')->default(0);
            $table->string('tax_unit')->nullable();
            $table->float('vat')->default(0);
            $table->string('vat_unit')->nullable();
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
        Schema::dropIfExists('products');
    }
}
