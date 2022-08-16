<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('activities')->insert([
            'name' => "test name",
            "description"=>"cura shape",
            "type"=>"Emergency",
            "color"=>0xffed6591,
            'id' => 1,
        ]);
    }
}
