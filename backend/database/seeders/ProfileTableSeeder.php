<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profiles')->insert([
            'name'        => 'Manager',
            'description' => 'Manager',
        ]);

        DB::table('profiles')->insert([
            'name'        => 'Employee',
            'description' => 'Employee',
        ]);
    }
}
