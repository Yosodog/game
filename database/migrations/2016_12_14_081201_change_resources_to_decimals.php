<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeResourcesToDecimals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->decimal('money', 18, 8)->change();
            $table->decimal('coal', 18, 8)->change();
            $table->decimal('oil', 18, 8)->change();
            $table->decimal('gas', 18, 8)->change();
            $table->decimal('rubber', 18, 8)->change();
            $table->decimal('steel', 18, 8)->change();
            $table->decimal('iron', 18, 8)->change();
            $table->decimal('bauxite', 18, 8)->change();
            $table->decimal('aluminum', 18, 8)->change();
            $table->decimal('lead', 18, 8)->change();
            $table->decimal('ammo', 18, 8)->change();
            $table->decimal('clay', 18, 8)->change();
            $table->decimal('cement', 18, 8)->change();
            $table->decimal('timber', 18, 8)->change();
            $table->decimal('brick', 18, 8)->change();
            $table->decimal('concrete', 18, 8)->change();
            $table->decimal('lumber', 18, 8)->change();
            $table->decimal('wheat', 18, 8)->change();
            $table->decimal('livestock', 18, 8)->change();
            $table->decimal('bread', 18, 8)->change();
            $table->decimal('meat', 18, 8)->change();
            $table->decimal('water', 18, 8)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->integer('money')->change();
            $table->integer('coal')->change();
            $table->integer('oil')->change();
            $table->integer('gas')->change();
            $table->integer('rubber')->change();
            $table->integer('steel')->change();
            $table->integer('iron')->change();
            $table->integer('bauxite')->change();
            $table->integer('aluminum')->change();
            $table->integer('lead')->change();
            $table->integer('ammo')->change();
            $table->integer('clay')->change();
            $table->integer('cement')->change();
            $table->integer('timber')->change();
            $table->integer('brick')->change();
            $table->integer('concrete')->change();
            $table->integer('lumber')->change();
            $table->integer('wheat')->change();
            $table->integer('livestock')->change();
            $table->integer('bread')->change();
            $table->integer('meat')->change();
            $table->integer('water')->change();
        });
    }
}
