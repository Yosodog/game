<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBuildTimeToBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('building_types', function (Blueprint $table) {
            $table->smallInteger('buildingTime')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('building_types', function (Blueprint $table) {
            $table->dropColumn('buildingTime');
        });
    }
}
