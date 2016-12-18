<?php

use Illuminate\Database\Seeder;

class FlagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Gets a list of the flags in the flags/countries directory and inserts them into the database
     *
     * @return void
     */
    public function run()
    {
        try {
            $flags = scandir(__DIR__.'/../../public/img/flags/countries');
        } catch (\Exception $e) {
            // If the directory doesn't exist just... don't run this shit
            return;
        }

        foreach ($flags as $flag)
        {
            if ($flag === '.' || $flag === '..')
                continue;

            $url = 'img/flags/countries/'.$flag;
            $name = str_replace('_', ' ', preg_replace('/\\.[^.\\s]{3,4}$/', '', $flag));

            \App\Models\Flags::create([
                'url' => $url,
                'name' => $name,
            ]);
        }

    }
}
