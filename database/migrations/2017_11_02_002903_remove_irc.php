<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveIrc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("alliances", function(Blueprint $table) {
            $table->dropColumn("IRCChan");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("alliances", function(Blueprint $table) {
            $table->string('IRCChan', 20)->nullable();
        });
    }
}
