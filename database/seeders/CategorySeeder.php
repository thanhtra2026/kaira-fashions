<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Nam' => 'nam', 'Nữ' => 'nu', 'Trẻ em' => 'tre-em'];

        foreach ($categories as $name => $slug) {
            Category::updateOrCreate(['slug' => $slug], ['name' => $name]);
        }
    }
}