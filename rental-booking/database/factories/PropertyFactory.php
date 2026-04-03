<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'address' => $this->faker->address,
            'price_per_night' => $this->faker->numberBetween(50, 500),
            'max_guests' => $this->faker->numberBetween(1, 10),
        ];
    }
}
