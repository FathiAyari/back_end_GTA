<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('companies')->insert([
            'name' => "cura shape",
            "adresse" => "Tunis",
            "url" => "https://www.cura-shape.com/",
            'title' => "Cura Shape",
            'id' => 1,
        ]);
    }
}
