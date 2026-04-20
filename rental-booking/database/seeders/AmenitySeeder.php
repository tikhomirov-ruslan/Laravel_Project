<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Wi-Fi', 'Kitchen', 'Parking', 'Air conditioning', 'Pool'] as $name) {
            Amenity::query()->firstOrCreate(['name' => $name]);
        }
    }
}
