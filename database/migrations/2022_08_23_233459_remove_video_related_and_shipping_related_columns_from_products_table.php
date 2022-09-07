<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveVideoRelatedAndShippingRelatedColumnsFromProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('video_provider');
            $table->dropColumn('videolink');
            $table->dropColumn('shiping_type');
            $table->dropColumn('flat_shipping_cost');
            $table->dropColumn('low_qty_warning');
            $table->dropColumn('stock_visibilty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
