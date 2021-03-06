<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropOldJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("jobs");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $jobs = new AddJobsTable();
        $jobs->up();
    }
}
