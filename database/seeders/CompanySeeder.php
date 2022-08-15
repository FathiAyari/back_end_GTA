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
            'tax_id' => "1235454",
            'phone_number' => "53280515",
            'id' => 1,
        ]);
    }
}
