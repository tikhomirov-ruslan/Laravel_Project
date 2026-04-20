<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Entire apartment', 'slug' => 'entire-apartment', 'description' => 'Whole flat or apartment'],
            ['name' => 'Private room', 'slug' => 'private-room', 'description' => 'Your own room in shared space'],
            ['name' => 'Hotel room', 'slug' => 'hotel-room', 'description' => 'Service hotel room'],
            ['name' => 'House', 'slug' => 'house', 'description' => 'Entire house or villa'],
            ['name' => 'Unique stay', 'slug' => 'unique-stay', 'description' => 'Cabins, castles, and unusual places'],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            );
        }
    }
}
