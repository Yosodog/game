<?php

use Illuminate\Database\Seeder;

class InstallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FlagTableSeeder::class);
        $this->call(PropertiesSeeder::class);
        $this->call(BuildingTypesSeeder::class);
    }
}
