<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $categoryId = Category::query()->inRandomOrder()->value('id');

        if (! $categoryId) {
            $name = fake()->unique()->words(2, true);
            $categoryId = Category::query()->create([
                'name' => Str::title($name),
                'slug' => Str::slug($name),
                'description' => fake()->sentence(),
            ])->id;
        }

        return [
            'user_id' => User::factory(),
            'category_id' => $categoryId,
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'address' => fake()->address(),
            'price_per_night' => fake()->numberBetween(50, 500),
            'max_guests' => fake()->numberBetween(1, 10),
        ];
    }
}
