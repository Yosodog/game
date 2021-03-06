<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingQueueKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("building_queue_key", function(Blueprint $table) {
            $table->increments("id");
            $table->timestamps();
            $table->integer("cityID")->unsigned();
            $table->integer("jobID")
                ->unsigned()
                ->nullable()
                ->comment("The ID with the associated job in the queue. If null, then the building is not currently under construction");
            $table->integer("buildingID")->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("building_queue_key");
    }
}
