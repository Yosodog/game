<?php

use Illuminate\Database\Seeder;
use \App\Models\Properties;

class PropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Properties::create([
            "name" => "Birth Rate",
            "baseValue" => 100,
        ]);

        Properties::create([
            "name" => "Death Rate",
            "baseValue" => 40,
        ]);

        Properties::create([
            "name" => "Immigration",
            "baseValue" => 10,
        ]);

        Properties::create([
            "name" => "Crime",
            "baseValue" => 50,
        ]);

        Properties::create([
            "name" => "Disease",
            "baseValue" => 50,
        ]);

        Properties::create([
            "name" => "Govt Satisfaction",
            "baseValue" => 50,
        ]);

        Properties::create([
            "name" => "Avg Income",
            "baseValue" => 30,
        ]);

        Properties::create([
            "name" => "Unemployment",
            "baseValue" => 50,
        ]);

        Properties::create([
            "name" => "Literacy",
            "baseValue" => 30,
        ]);
    }
}
