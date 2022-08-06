<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PopulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('populations')->insert([
            'name' => "GTA",
            'id' => 1,
        ]);

    }
}
