<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hotels',
                'slug' => Str::slug('hotel', '_'),
                'is_active' => true,
            ],
            [
                'name' => 'Car Rental',
                'slug' => Str::slug('car rental', '_'),
                'is_active' => true,
            ],
            [
                'name' => 'Tour',
                'slug' => Str::slug('tour', '_'),
                'is_active' => true,
            ],
          ];

          foreach ($categories as $category) {
              Category::create($category);
          }
    }
}
