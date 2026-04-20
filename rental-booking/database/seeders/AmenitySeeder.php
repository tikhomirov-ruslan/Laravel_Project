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
            'Кухня',
            'Парковка',
            'Кондиционер',
            'Стиральная машина',
            'Рабочее место',
            'Балкон',
            'Вид на горы',
            'Смарт ТВ',
            'Бесконтактное заселение',
        ];

        foreach ($amenities as $name) {
            Amenity::query()->firstOrCreate(['name' => $name]);
        }
    }
}
