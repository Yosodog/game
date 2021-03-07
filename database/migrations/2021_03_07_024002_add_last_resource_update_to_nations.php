<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastResourceUpdateToNations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nations', function (Blueprint $table) {
            $table->bigInteger("resources_last_updated")->unsigned()->nullable();
            $table->dropColumn("minsInactive"); // Let's just get rid of this
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nations', function (Blueprint $table) {
            $table->dropColumn("resources_last_updated");
            $table->integer("minsInactive")->unsigned();
        });
    }
}
