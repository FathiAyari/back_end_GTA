<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('orders')->insert([
            'product_id' => 1,
            "quantity" => 30,
            'company_id' => 1,
            "created_at" => Carbon::now()->format('Y-m-d'),
            'id' => 1,
        ]);
        \DB::table('orders')->insert([
            'product_id' => 2,
            "quantity" => 30,
            'company_id' => 1,

            "created_at" => Carbon::now()->format('Y-m-d'),
            'id' => 2,
        ]);
        \DB::table('orders')->insert([
            'product_id' => 2,
            "quantity" => 30,
            'company_id' => 1,
            "created_at" => Carbon::now()->format('Y-m-d'),
            'id' =>3 ,
        ]);
    }
}
