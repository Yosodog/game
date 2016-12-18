<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nationID')->unsigned();
            $table->integer('money')->unsigned();
            $table->integer('coal')->unsigned();
            $table->integer('oil')->unsigned();
            $table->integer('gas')->unsigned();
            $table->integer('rubber')->unsigned();
            $table->integer('steel')->unsigned();
            $table->integer('iron')->unsigned();
            $table->integer('bauxite')->unsigned();
            $table->integer('aluminum')->unsigned();
            $table->integer('lead')->unsigned();
            $table->integer('ammo')->unsigned();
            $table->integer('clay')->unsigned();
            $table->integer('cement')->unsigned();
            $table->integer('timber')->unsigned();
            $table->integer('brick')->unsigned();
            $table->integer('concrete')->unsigned();
            $table->integer('lumber')->unsigned();
            $table->integer('wheat')->unsigned();
            $table->integer('livestock')->unsigned();
            $table->integer('bread')->unsigned();
            $table->integer('meat')->unsigned();
            $table->integer('water')->unsigned();

            $table->foreign('nationID')->references('id')->on('nations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('resources');
    }
}
