<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Квартира', 'slug' => 'apartment', 'description' => 'Отдельная квартира для краткосрочного проживания'],
            ['name' => 'Апартаменты', 'slug' => 'apartments', 'description' => 'Современные апартаменты в жилых комплексах'],
            ['name' => 'Студия', 'slug' => 'studio', 'description' => 'Компактное жильё для одного или двух гостей'],
            ['name' => 'Дом', 'slug' => 'house', 'description' => 'Отдельный дом или коттедж'],
            ['name' => 'Лофт', 'slug' => 'loft', 'description' => 'Просторное жильё в современном стиле'],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            );
        }
    }
}
