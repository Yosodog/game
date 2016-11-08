<?php

use Illuminate\Database\Seeder;
use \App\Models\BuildingTypes;
use \App\Models\Effects;
use \App\Models\Properties;

class BuildingTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Fill the database with the default buildings. It's gonna look dirty
     *
     * @return void
     */
    public function run()
    {
        $building = BuildingTypes::create([
            "name" => 'School',
            "category" => 'services',
            "description" => 'A School',
            "energy" => 5,
            "baseCost" => 1000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Literacy")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 5,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 2,
        ]);

        $building = BuildingTypes::create([
            "name" => 'University',
            "category" => 'services',
            "description" => 'A university',
            "energy" => 10,
            "baseCost" => 10000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Literacy")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 10,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 10,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Fire Station',
            "category" => 'services',
            "description" => 'A fire station',
            "energy" => 5,
            "baseCost" => 2000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 3,
        ]);

        $property = Properties::where("name", "Crime")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 2,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Police Station',
            "category" => 'services',
            "description" => 'A Police Station',
            "energy" => 5,
            "baseCost" => 1000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 3,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Crime")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 10,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Clinic',
            "category" => 'services',
            "description" => 'A clinic',
            "energy" => 5,
            "baseCost" => 1000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 3,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Disease")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 5,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Crime")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 1,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Hospital',
            "category" => 'services',
            "description" => 'A hospital',
            "energy" => 10,
            "baseCost" => 10000,
            "buildingTime" => 3,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 5,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Disease")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 15,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Crime")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 3,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Cemetery',
            "category" => 'services',
            "description" => 'A cemetery',
            "energy" => 1,
            "baseCost" => 1000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Disease")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 5,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Airport',
            "category" => 'transportation',
            "description" => 'An airport',
            "energy" => 10,
            "baseCost" => 10000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 15,
        ]);

        $building = BuildingTypes::create([
            "name" => 'International Airport',
            "category" => 'transportation',
            "description" => 'An International Airport',
            "energy" => 100,
            "baseCost" => 1000000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 30,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Bus Depot',
            "category" => 'transportation',
            "description" => 'A bus depot',
            "energy" => 10,
            "baseCost" => 10000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 5,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Harbor',
            "category" => 'transportation',
            "description" => 'A harbor',
            "energy" => 10,
            "baseCost" => 10000,
            "buildingTime" => 10,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 15,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Landfill',
            "category" => 'services',
            "description" => 'A landfill',
            "energy" => 2,
            "baseCost" => 1000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Disease")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 3,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Metro',
            "category" => 'transportation',
            "description" => 'A metro',
            "energy" => 50,
            "baseCost" => 50000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 10,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Prison',
            "category" => 'services',
            "description" => 'A prison',
            "energy" => 10,
            "baseCost" => 20000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Crime")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 5,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 1,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Railway',
            "category" => 'transportation',
            "description" => 'Railway',
            "energy" => 50,
            "baseCost" => 100000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 10,
        ]);

        $building = BuildingTypes::create([
            "name" => 'Road',
            "category" => 'transportation',
            "description" => 'Road',
            "energy" => 50,
            "baseCost" => 100000,
            "buildingTime" => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where("name", "Unemployment")->firstOrFail();

        Effects::create([
            "property" => $property->id,
            "relation" => $building->id,
            "affect" => 3,
        ]);
    }
}
