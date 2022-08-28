<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlanningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('plannings')->insert([
            'user_id' => 1,
            "activity_id"=>1,
            "start_time"=>"2020-08-05 08:00:00",
            "end_time"=>"2020-08-05 12:00:00",
            "real_end_time"=>"2020-08-05 12:00:00",
            "real_start_time"=>"2020-08-05 08:00:00",
            "status"=>0,
            "note"=>"test",
            'id' => 1,
        ]);
    }
}
