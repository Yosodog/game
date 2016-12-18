<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->integer('popGrowth');
            $table->integer('birthRate')->unsigned();
            $table->integer('deathRate')->unsigned();
            $table->integer('immigration');
            $table->integer('avgIncome')->unsigned();
            $table->tinyInteger('satisfaction');
            $table->tinyInteger('crime')->unsigned();
            $table->tinyInteger('literacy')->unsigned();
            $table->tinyInteger('disease')->unsigned();
            $table->tinyInteger('happiness')->unsigned();
            $table->tinyInteger('unemployment')->unsigned();
            $table->tinyInteger('pollution')->unsigned();
            $table->integer('land')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('popGrowth');
            $table->dropColumn('birthRate');
            $table->dropColumn('deathRate');
            $table->dropColumn('immigration');
            $table->dropColumn('avgIncome');
            $table->dropColumn('satisfaction');
            $table->dropColumn('crime');
            $table->dropColumn('literacy');
            $table->dropColumn('disease');
            $table->dropColumn('happiness');
            $table->dropColumn('unemployment');
            $table->dropColumn('pollution');
            $table->dropColumn('land');
        });
    }
}
