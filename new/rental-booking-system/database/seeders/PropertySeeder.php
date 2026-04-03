<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получим владельцев (role=owner)
        $owners = User::where('role', 'owner')->get();

        foreach ($owners as $owner) {
            Property::create([
                'owner_id' => $owner->id,
                'title' => 'Cozy Apartment in City Center',
                'description' => 'A beautiful apartment with all amenities.',
                'address' => '123 Main St, Almaty',
                'price_per_night' => 75.00,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'max_guests' => 4,
                'is_available' => true,
            ]);

            Property::create([
                'owner_id' => $owner->id,
                'title' => 'Luxury Villa with Pool',
                'description' => 'Spacious villa perfect for families.',
                'address' => '45 Hillside Ave, Astana',
                'price_per_night' => 250.00,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'max_guests' => 8,
                'is_available' => true,
            ]);
        }
    }
}
