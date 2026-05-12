<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Apartment', 'slug' => 'apartment', 'description' => 'A private apartment for short-term stays'],
            ['name' => 'Serviced apartment', 'slug' => 'apartments', 'description' => 'Modern apartments in residential complexes'],
            ['name' => 'Studio', 'slug' => 'studio', 'description' => 'Compact housing for one or two guests'],
            ['name' => 'House', 'slug' => 'house', 'description' => 'A private house or cottage'],
            ['name' => 'Loft', 'slug' => 'loft', 'description' => 'A spacious home with a modern layout'],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
