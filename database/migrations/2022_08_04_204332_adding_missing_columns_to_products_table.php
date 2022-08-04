<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingMissingColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('sub_cat')->nullable()->after('category_id');
            $table->string('url', 2000)->nullable()->after('sub_cat');
            $table->integer('new_arrival')->nullable()->after('points');
            $table->integer('best_seller')->nullable()->after('new_arrival');
            $table->integer('best_offer')->nullable()->after('best_seller');
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
            $table->dropColumn('sub_cat');
            $table->dropColumn('url');
            $table->dropColumn('new_arrival');
            $table->dropColumn('best_seller');
            $table->dropColumn('best_offer');
        });
    }
}
