<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
            'name' => "Super admins",
            'id' => 1,
            'created_at'=>Carbon::now()
        ]);

    }
}
