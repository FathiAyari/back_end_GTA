<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->insert([
            'name' => "Creme de soin",
            'description' => "Creme de soin 200ml",
            'quantity' => "100",
            'avalaible_space' => "200",
            'id' => 1,
        ]);
    }
}
