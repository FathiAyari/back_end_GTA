<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
            'available_space' => "200",
            "price"=>120,
            'created_at' => Carbon::now(),
            'id' => 1,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 2,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 3,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 4,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 5,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 6,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 7,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 8,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 9,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 11,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>111,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 19,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 119,
        ]);
        \DB::table('products')->insert([
            'name' => "Savon liquide",
            "price"=>30,
            'description' => "savon liquide 200ml",
            'quantity' => 120,
            'available_space' => 150,
            'created_at' => Carbon::now(),
            'id' => 49,
        ]);
    }
}
