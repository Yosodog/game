<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPropertiesFromCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn([
                'popGrowth',
                'birthRate',
                'deathRate',
                'immigration',
                'avgIncome',
                'satisfaction',
                'crime',
                'literacy',
                'disease',
                'happiness',
                'unemployment',
                'pollution',
            ]);
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
        });
    }
}
