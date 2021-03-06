<?php

namespace Database\Seeders;

use App\Models\BuildingTypes;
use App\Models\Effects;
use App\Models\Properties;
use Illuminate\Database\Seeder;

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
        $building = BuildingTypes::updateOrCreate(
            ['name' => 'School'],
            [
                'category' => 'services',
                'description' => 'A School',
                'energy' => 5,
                'baseCost' => 5000000,
                'buildingTime' => 30,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Literacy')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 5,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 2,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'University'],
            [
                'category' => 'services',
                'description' => 'A university',
                'energy' => 10,
                'baseCost' => 20000000,
                'buildingTime' => 60,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Literacy')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 10,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 10,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Fire Station'],
            [
                'category' => 'services',
                'description' => 'A fire station',
                'energy' => 5,
                'baseCost' => 5000000,
                'buildingTime' => 25,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 3,
        ]);

        $property = Properties::where('name', 'Crime')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 2,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Police Station'],
            [
                'category' => 'services',
                'description' => 'A Police Station',
                'energy' => 5,
                'baseCost' => 5000000,
                'buildingTime' => 25,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 3,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Crime')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 10,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Clinic'],
            [
                'category' => 'services',
                'description' => 'A clinic',
                'energy' => 5,
                'baseCost' => 5000000,
                'buildingTime' => 30,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 3,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Disease')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 5,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Crime')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 1,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Hospital'],
            [
                'category' => 'services',
                'description' => 'A hospital',
                'energy' => 10,
                'baseCost' => 25000000,
                'buildingTime' => 60,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 5,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Disease')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 15,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Crime')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 3,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Cemetery'],
            [
                'category' => 'services',
                'description' => 'A cemetery',
                'energy' => 1,
                'baseCost' => 5000000,
                'buildingTime' => 15,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Disease')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 5,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Airport'],
            [
                'category' => 'transportation',
                'description' => 'An airport',
                'energy' => 10,
                'baseCost' => 30000000,
                'buildingTime' => 60,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 15,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'International Airport'],
            [
                'category' => 'transportation',
                'description' => 'An International Airport',
                'energy' => 100,
                'baseCost' => 100000000,
                'buildingTime' => 180,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 30,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Bus Depot'],
            [
                'category' => 'transportation',
                'description' => 'A bus depot',
                'energy' => 10,
                'baseCost' => 5000000,
                'buildingTime' => 30,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 5,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Harbor'],
            [
                'category' => 'transportation',
                'description' => 'A harbor',
                'energy' => 10,
                'baseCost' => 50000000,
                'buildingTime' => 60,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 15,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Landfill'],
            [
                'category' => 'services',
                'description' => 'A landfill',
                'energy' => 2,
                'baseCost' => 10000000,
                'buildingTime' => 15,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 1,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Disease')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 3,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Metro'],
            [
                'category' => 'transportation',
                'description' => 'A metro',
                'energy' => 50,
                'baseCost' => 60000000,
                'buildingTime' => 45,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 10,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Prison'],
            [
                'category' => 'services',
                'description' => 'A prison',
                'energy' => 10,
                'baseCost' => 25000000,
                'buildingTime' => 60,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Crime')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 5,
        ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 1,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Railway'],
            [
                'category' => 'transportation',
                'description' => 'Railway',
                'energy' => 50,
                'baseCost' => 100000000,
                'buildingTime' => 180,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 10,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Road'],
            [
                'category' => 'transportation',
                'description' => 'Road',
                'energy' => 50,
                'baseCost' => 70000000,
                'buildingTime' => 45,
            ]);

        // Get ID of property this next effect will affect
        $property = Properties::where('name', 'Unemployment')->firstOrFail();

        Effects::create([
            'property' => $property->id,
            'relation' => $building->id,
            'affect' => 3,
        ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Coal Mine'],
            [
                'category' => 'raw',
                'description' => 'A Coal mine',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'coal',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Oil Well'],
            [
                'category' => 'raw',
                'description' => 'An Oil Well',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'oil',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Oil Refinery'],
            [
                'category' => 'manufactory',
                'description' => 'An Oil Refinery',
                'energy' => 20,
                'baseCost' => 100000,
                'buildingTime' => 60,
                'produces' => 1,
                'producedResource' => 'gas',
                'producedAmount' => 10,
                'requires' => 1,
                'requiredResource' => 'oil',
                'requiredAmount' => 5,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Wheat Farm'],
            [
                'category' => 'raw',
                'description' => 'A Wheat Farm',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'wheat',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Ranch'],
            [
                'category' => 'raw',
                'description' => 'A ranch',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'livestock',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Wheat Refinery'],
            [
                'category' => 'manufactory',
                'description' => 'A Wheat Refinery',
                'energy' => 20,
                'baseCost' => 100000,
                'buildingTime' => 60,
                'produces' => 1,
                'producedResource' => 'bread',
                'producedAmount' => 5,
                'requires' => 1,
                'requiredResource' => 'wheat',
                'requiredAmount' => 5,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Meat Processor'],
            [
                'category' => 'manufactory',
                'description' => 'A Meat Processor',
                'energy' => 20,
                'baseCost' => 100000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'meat',
                'producedAmount' => 5,
                'requires' => 1,
                'requiredResource' => 'livestock',
                'requiredAmount' => 5,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Water Tower'],
            [
                'category' => 'raw',
                'description' => 'A Water Tower',
                'energy' => 1,
                'baseCost' => 10000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'water',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Clay Mine'],
            [
                'category' => 'raw',
                'description' => 'A Clay Mine',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'clay',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Cement Kiln'],
            [
                'category' => 'raw',
                'description' => 'A Cement Kiln',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'cement',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Timber Mill'],
            [
                'category' => 'raw',
                'description' => 'A Timber Mill',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'timber',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Brick House'],
            [
                'category' => 'manufactory',
                'description' => 'A Brick house',
                'energy' => 20,
                'baseCost' => 100000,
                'buildingTime' => 60,
                'produces' => 1,
                'producedResource' => 'brick',
                'producedAmount' => 5,
                'requires' => 1,
                'requiredResource' => 'clay',
                'requiredAmount' => 5,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Concrete Mixer'],
            [
                'category' => 'manufactory',
                'description' => 'A Concrete Mixer',
                'energy' => 20,
                'baseCost' => 100000,
                'buildingTime' => 60,
                'produces' => 1,
                'producedResource' => 'concrete',
                'producedAmount' => 5,
                'requires' => 1,
                'requiredResource' => 'cement',
                'requiredAmount' => 5,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Lumber Refinery'],
            [
                'category' => 'manufactory',
                'description' => 'A Lumber Refinery',
                'energy' => 20,
                'baseCost' => 100000,
                'buildingTime' => 60,
                'produces' => 1,
                'producedResource' => 'lumber',
                'producedAmount' => 5,
                'requires' => 1,
                'requiredResource' => 'timber',
                'requiredAmount' => 5,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Rubber Processor'],
            [
                'category' => 'raw',
                'description' => 'A Rubber Processor',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 60,
                'produces' => 1,
                'producedResource' => 'rubber',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Iron Mine'],
            [
                'category' => 'raw',
                'description' => 'An Iron Mine',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'iron',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Bauxite Mill'],
            [
                'category' => 'raw',
                'description' => 'A Bauxite Mill',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'bauxite',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Lead Mine'],
            [
                'category' => 'raw',
                'description' => 'A Lead Mine',
                'energy' => 10,
                'baseCost' => 25000,
                'buildingTime' => 30,
                'produces' => 1,
                'producedResource' => 'lead',
                'producedAmount' => 10,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Steel Mill'],
            [
                'category' => 'manufactory',
                'description' => 'A Steel Mill',
                'energy' => 20,
                'baseCost' => 100000,
                'buildingTime' => 60,
                'produces' => 1,
                'producedResource' => 'steel',
                'producedAmount' => 5,
                'requires' => 1,
                'requiredResource' => 'iron',
                'requiredAmount' => 5,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Aluminum Factory'],
            [
                'category' => 'manufactory',
                'description' => 'An Aluminum Factory',
                'energy' => 20,
                'baseCost' => 100000,
                'buildingTime' => 60,
                'produces' => 1,
                'producedResource' => 'aluminum',
                'producedAmount' => 5,
                'requires' => 1,
                'requiredResource' => 'bauxite',
                'requiredAmount' => 5,
            ]);

        $building = BuildingTypes::updateOrCreate(
            ['name' => 'Ammo Factory'],
            [
                'category' => 'manufactory',
                'description' => 'An Ammo Factory',
                'energy' => 20,
                'baseCost' => 100000,
                'buildingTime' => 60,
                'produces' => 1,
                'producedResource' => 'ammo',
                'producedAmount' => 5,
                'requires' => 1,
                'requiredResource' => 'lead',
                'requiredAmount' => 5,
            ]);

    }
}
