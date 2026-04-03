<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $properties = Property::all();

        foreach ($properties as $property) {
            foreach ($customers as $customer) {
                // чтобы не было дубликатов, но unique constraint не даст создать повторно
                Review::firstOrCreate([
                    'property_id' => $property->id,
                    'user_id' => $customer->id,
                ], [
                    'rating' => rand(3, 5),
                    'comment' => 'Great place, very clean and comfortable!',
                ]);
            }
        }
    }
}
