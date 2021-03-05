<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('city_id')->unsigned();
            $table->integer('building_id')->unsigned();
            $table->smallInteger('quantity')->unsigned();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('building_id')->references('id')->on('building_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('buildings');
    }
}
