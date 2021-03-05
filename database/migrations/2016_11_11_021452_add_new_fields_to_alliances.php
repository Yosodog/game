<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToAlliances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alliances', function (Blueprint $table) {
            $table->string('discord')->nullable();
            $table->text('member_board');
            $table->boolean('accepting_members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alliances', function (Blueprint $table) {
            $table->dropColumn('discord');
            $table->dropColumn('member_board');
            $table->dropColumn('accepting_members')->default(1);
        });
    }
}
