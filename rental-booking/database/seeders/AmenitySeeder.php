<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            'Wi-Fi',
            'Kitchen',
            'Parking',
            'Air conditioning',
            'Washing machine',
            'Workspace',
            'Balcony',
            'Mountain view',
            'Smart TV',
            'Self check-in',
        ];

        foreach ($amenities as $name) {
            Amenity::query()->firstOrCreate(['name' => $name]);
        }
    }
}
