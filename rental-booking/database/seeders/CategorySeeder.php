<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Entire apartment', 'slug' => 'entire-apartment', 'description' => 'Whole flat or apartment'],
            ['name' => 'Private room', 'slug' => 'private-room', 'description' => 'Your own room in shared space'],
            ['name' => 'Hotel room', 'slug' => 'hotel-room', 'description' => 'Service hotel room'],
            ['name' => 'House', 'slug' => 'house', 'description' => 'Entire house or villa'],
            ['name' => 'Unique stay', 'slug' => 'unique-stay', 'description' => 'Cabins, castles, etc.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
