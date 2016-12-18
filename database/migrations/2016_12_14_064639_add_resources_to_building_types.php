<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResourcesToBuildingTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('building_types', function (Blueprint $table) {
            $table->boolean('produces')->default(0)->comment('Does this building produce resources?');
            $table->string('producedResource')->nullable()->comment('What resource does this building produce?');
            $table->smallInteger('producedAmount')->nullable()->comment('How much does this building produce?');
            $table->boolean('requires')->default(0)->comment('Does this building require resources to run?');
            $table->string('requiredResource')->nullable()->comment('What resource does this building require?');
            $table->smallInteger('requiredAmount')->nullable()->comment('What is the required amount for this building to run?');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('building_types', function (Blueprint $table) {
            $table->dropColumn('produces');
            $table->dropColumn('producedResource');
            $table->dropColumn('producedAmount');
            $table->dropColumn('requires');
            $table->dropColumn('requiredResource');
            $table->dropColumn('requiredAmount');
        });
    }
}
