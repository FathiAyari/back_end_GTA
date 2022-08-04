<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->insert([
            'name' => "Super Admin",
            'id' => 1,
        ]);
        \DB::table('roles')->insert([
            'name' => "Admin",
            'id' => 2,
        ]);
        \DB::table('roles')->insert([
            'name' => "Employee",
            'id' => 3,
        ]);
        \DB::table('roles')->insert([
            'name' => "Stock Manager",
            'id' => 4,
        ]);
    }
}
