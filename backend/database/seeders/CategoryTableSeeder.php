<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Arte',
        ]);

        Category::create([
            'name' => 'Informatica',
        ]);

        Category::create([
            'name' => 'Material',
        ]);

        Category::create([
            'name' => 'Maqueta',
        ]);
    }
}
