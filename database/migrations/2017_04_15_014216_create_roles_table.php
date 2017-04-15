<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('alliance_id')->unsigned();
            $table->string('name');
            $table->boolean('canChangeName');
            $table->boolean('canRemoveMember');
            $table->boolean('canDisbandAlliance');
            $table->boolean('canChangeCosmetics');
            $table->boolean('canCreateRoles');
            $table->boolean('canEditRoles');
            $table->boolean('canRemoveRoles');
            
            $table->foreign('alliance_id')->references('id')->on('alliances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
