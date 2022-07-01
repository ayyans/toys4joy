<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSibblingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sibblings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('boy_one_name')->nullable();
            $table->string('boy_one_dob')->nullable();
            $table->string('boy_tow_name')->nullable();
            $table->string('boy_tow_dob')->nullable();
            $table->string('boy_three_name')->nullable();
            $table->string('boy_three_dob')->nullable();
            $table->string('boy_four_name')->nullable();
            $table->string('boy_four_dob')->nullable();
            $table->string('boy_five_name')->nullable();
            $table->string('boy_five_dob')->nullable();
            $table->string('girl_one_name')->nullable();
            $table->string('girl_one_dob')->nullable();
            $table->string('girl_tow_name')->nullable();
            $table->string('girl_tow_dob')->nullable();
            $table->string('girl_three_name')->nullable();
            $table->string('girl_three_dob')->nullable();
            $table->string('girl_four_name')->nullable();
            $table->string('girl_four_dob')->nullable();
            $table->string('girl_five_name')->nullable();
            $table->string('girl_five_dob')->nullable();
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
        Schema::dropIfExists('sibblings');
    }
}
