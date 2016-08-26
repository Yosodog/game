<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EffectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("effects", function(Blueprint $table) {
            $table->increments("id");
            $table->integer("property")->unsigned()->comment("The ID of the property this effect affects");
            $table->integer("relation")->unsigned()->comment("The ID of the building, law, or whatever that this effect belongs to");
            $table->decimal("affect", 10, 2)->comment("The percentage this increases/decreases. The % should be multiplied by 100 before storing");

            $table->foreign("property")->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("effects");
    }
}
