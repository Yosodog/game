<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHigherIsBetterToProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
           $table->boolean('higherIsBetter')->comment('Is a higher score better? Things like literacy is better high, whereas crime should be lower');
            $table->boolean('isOutOf100')->comment("If the property is out of 100. Things like avg income shouldn't be capped");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('higherIsBetter');
            $table->dropColumn('isOutOf100');
        });
    }
}
