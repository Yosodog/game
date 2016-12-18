<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsPercentageToEffects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('effects', function (Blueprint $table) {
            $table->boolean('isPercentage')->default(0)->comment('Does this effect increase/decrease something by a percentage?');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('effects', function (Blueprint $table) {
            $table->dropColumn('isPercentage');
        });
    }
}
