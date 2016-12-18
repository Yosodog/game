<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->enum('type', ['building', 'research', 'military', 'government']);
            $table->enum('status', ['queued', 'active', 'completed', 'cancelled']);
            $table->integer('nation_id')->unsigned();
            $table->integer('city_id')->unsigned()->nullable()->comment('Only set if the job is related to a city');
            $table->integer('item_id')->unsigned()->comment('The ID of the item that is being queued. EX: Building ID, Law ID, etc');
            $table->smallInteger('totalTurns')->unsigned()->comment('The total amount of turns this should take');
            $table->smallInteger('turnsLeft')->unsigned();

            $table->foreign('nation_id')->references('id')->on('nations');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs');
    }
}
