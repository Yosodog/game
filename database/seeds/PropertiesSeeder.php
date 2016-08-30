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
            "pointsPerPerson" => 0.0010,
        ]);

        Properties::create([
            "name" => "Death Rate",
            "pointsPerPerson" => 0.0010,
        ]);

        Properties::create([
            "name" => "Immigration",
            "pointsPerPerson" => 0.0010,
        ]);

        Properties::create([
            "name" => "Crime",
            "pointsPerPerson" => 0.0010,
        ]);

        Properties::create([
            "name" => "Disease",
            "pointsPerPerson" => 0.0010,
        ]);

        Properties::create([
            "name" => "Govt Satisfaction",
            "pointsPerPerson" => 0.0010,
        ]);

        Properties::create([
            "name" => "Avg Income",
            "pointsPerPerson" => 0.0010,
        ]);

        Properties::create([
            "name" => "Unemployment",
            "pointsPerPerson" => 0.0010,
        ]);

        Properties::create([
            "name" => "Literacy",
            "pointsPerPerson" => 0.0010,
        ]);
    }
}
