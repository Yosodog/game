<?php

use Illuminate\Database\Seeder;

class FakeNationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 500;

        for ($x = 0; $x < $limit; $x++)
        {
            // Create a fake user first
            $user = new \App\Models\User();
            $user->name = $faker->userName;
            $user->email = $faker->safeEmail;
            $user->password = bcrypt(str_random(10));
            $user->hasNation = true;
            $user->save();

            // Create the user's nation
            $flagQuery = \App\Models\Flags::inRandomOrder()->first();
            $flagID = $flagQuery->id;
            $nation = \App\Models\Nation\Nations::create([
                'user_id' => $user->id,
                'name' => $faker->company,
                'flagID' => $flagID,
            ]);

            // Create it's cities
            // Select how many cities the nation should have
            $numCities = random_int(1, 20);

            for ($y = 0; $y < $numCities; $y++)
            {
                \App\Models\Nation\Cities::create([
                    'nation_id' => $nation->id,
                    'name' => $faker->company,
                ]);
            }
        }
    }
}
