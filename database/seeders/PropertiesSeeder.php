<?php

namespace Database\Seeders;

use App\Models\Properties;
use Illuminate\Database\Seeder;

class PropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Properties::updateOrCreate(
            ['name' => 'Birth Rate'],
            [
            'pointsPerPerson' => 0.0010,
            'higherIsBetter' => true,
            'isOutOf100' => false,
            'usesPointSystem' => false,
        ]);

        Properties::updateOrCreate(
            ['name' => 'Death Rate'],
            [
            'pointsPerPerson' => 0.0010,
            'higherIsBetter' => false,
            'isOutOf100' => false,
            'usesPointSystem' => false,
        ]);

        Properties::updateOrCreate(
            ['name' => 'Immigration'],
            [
            'name' => 'Immigration',
            'pointsPerPerson' => 0.0010,
            'higherIsBetter' => true,
            'isOutOf100' => false,
            'usesPointSystem' => false,
        ]);

        Properties::updateOrCreate(
            ['name' => 'Crime'],
            [
            'pointsPerPerson' => 0.0010,
            'higherIsBetter' => false,
            'isOutOf100' => true,
            'usesPointSystem' => true,
        ]);

        Properties::updateOrCreate(
            ['name' => 'Disease'],
            [
            'pointsPerPerson' => 0.0010,
            'higherIsBetter' => false,
            'isOutOf100' => true,
            'usesPointSystem' => true,
        ]);

        Properties::updateOrCreate(
            ['name' => 'Govt Satisfaction'],
            [
            'pointsPerPerson' => 0.0010,
            'higherIsBetter' => true,
            'isOutOf100' => true,
            'usesPointSystem' => false,
        ]);

        Properties::updateOrCreate(
            ['name' => 'Avg Income'],
            [
            'pointsPerPerson' => 0.0010,
            'higherIsBetter' => true,
            'isOutOf100' => false,
            'usesPointSystem' => false,
        ]);

        Properties::updateOrCreate(
            ['name' => 'Unemployment'],
            [
            'pointsPerPerson' => 0.0010,
            'higherIsBetter' => false,
            'isOutOf100' => true,
            'usesPointSystem' => true,
        ]);

        Properties::updateOrCreate(
            ['name' => 'Literacy'],
            [
            'pointsPerPerson' => 0.0010,
            'higherIsBetter' => true,
            'isOutOf100' => true,
            'usesPointSystem' => true,
        ]);

        Properties::updateOrCreate(
            ['name' => 'Growth Rate'],
            [
            'pointsPerPerson' => 0.0,
            'higherIsBetter' => true,
            'isOutOf100' => false,
            'usesPointSystem' => false,
        ]);
    }
}
