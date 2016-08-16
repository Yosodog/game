<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNationStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nations', function (Blueprint $table) {
            $table->string('government');
            $table->string("currency");
            $table->integer("flagID")->unsigned();
            $table->integer("allianceID")->nullable()->unsigned();
            $table->integer("minsInactive")->unsigned();

            $table->foreign("allianceID")->references('id')->on('alliances');
            $table->foreign("flagID")->references('id')->on('flags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nations', function ($table) {
            $table->dropColumn('government');
            $table->dropColumn("currency");
            $table->dropColumn("flagID");
            $table->dropColumn("allianceID");
            $table->dropColumn("minsInactive");
        });
    }
}
