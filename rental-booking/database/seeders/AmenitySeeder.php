<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities =
            [
                'Wi-Fi',
                'Кухня',
                'Парковка',
                'Кондиционер',
                'Бассейн'
            ];

        foreach ($amenities as $name) {
            Amenity::create(['name' => $name]);
        }
    }
}
