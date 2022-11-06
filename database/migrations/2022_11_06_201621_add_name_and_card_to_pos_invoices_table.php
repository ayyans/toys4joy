<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameAndCardToPosInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_invoices', function (Blueprint $table) {
            $table->after('change', function($table) {
                $table->string('name')->nullable();
                $table->string('card')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pos_invoices', function (Blueprint $table) {
            $table->dropColumn('name', 'card');
        });
    }
}
