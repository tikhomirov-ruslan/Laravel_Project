<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Property;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserPropertyBookingSeeder extends Seeder
{
    public function run(): void
    {
        $guest = User::query()->updateOrCreate(
            ['email' => 'user1@example.com'],
            ['name' => 'Aliya Seitova', 'password' => 'password', 'role' => 'customer']
        );

        $secondGuest = User::query()->updateOrCreate(
            ['email' => 'user2@example.com'],
            ['name' => 'Nursultan Bekov', 'password' => 'password', 'role' => 'customer']
        );

        $owner = User::query()->updateOrCreate(
            ['email' => 'owner@example.com'],
            ['name' => 'Yermek Tuleuov', 'password' => 'password', 'role' => 'owner']
        );

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Administrator', 'password' => 'password', 'role' => 'admin']
        );

        $apartment = Category::query()->where('slug', 'apartment')->first();
        $apartments = Category::query()->where('slug', 'apartments')->first();
        $studio = Category::query()->where('slug', 'studio')->first();
        $loft = Category::query()->where('slug', 'loft')->first();

        $propertiesData = [
            [
                'title' => 'Cozy apartment near Arbat',
                'description' => 'A bright apartment in central Almaty, close to Arbat, the metro, and cafes. A good fit for couples or business trips.',
                'address' => '105 Panfilov Street, Almaty',
                'price_per_night' => 24000,
                'max_guests' => 2,
                'category_id' => $apartment?->id,
                'amenities' => ['Wi-Fi', 'Kitchen', 'Washing machine', 'Smart TV'],
            ],
            [
                'title' => 'Apartment with Kok-Tobe view',
                'description' => 'A modern apartment with a spacious living room and a beautiful city view. Ideal for a family stay.',
                'address' => '172 Dostyk Avenue, Almaty',
                'price_per_night' => 38000,
                'max_guests' => 4,
                'category_id' => $apartments?->id,
                'amenities' => ['Wi-Fi', 'Parking', 'Air conditioning', 'Mountain view', 'Balcony'],
            ],
            [
                'title' => 'Studio near Mega Center',
                'description' => 'A compact and comfortable studio for one or two guests with easy access to Al-Farabi Avenue.',
                'address' => '247a Rozybakiev Street, Almaty',
                'price_per_night' => 21000,
                'max_guests' => 2,
                'category_id' => $studio?->id,
                'amenities' => ['Wi-Fi', 'Kitchen', 'Workspace', 'Air conditioning'],
            ],
            [
                'title' => 'Loft in the Golden Square',
                'description' => 'A stylish loft with high ceilings, a comfortable bedroom, and a workspace. Great for tourists and remote workers.',
                'address' => '83 Kabanbay Batyr Street, Almaty',
                'price_per_night' => 32000,
                'max_guests' => 3,
                'category_id' => $loft?->id,
                'amenities' => ['Wi-Fi', 'Workspace', 'Smart TV', 'Self check-in'],
            ],
            [
                'title' => 'Family apartment near Esentai',
                'description' => 'A spacious apartment with two bedrooms and a kitchen. Suitable for families with children or guests staying for several days.',
                'address' => '30/8 Satpayev Street, Almaty',
                'price_per_night' => 41000,
                'max_guests' => 5,
                'category_id' => $apartment?->id,
                'amenities' => ['Wi-Fi', 'Kitchen', 'Parking', 'Washing machine', 'Balcony'],
            ],
            [
                'title' => 'Mountain-side apartment with a quiet yard',
                'description' => 'A quiet neighborhood, fresh air, and convenient transport access. A strong choice for a relaxed stay.',
                'address' => '58 Samal-2 Microdistrict, Almaty',
                'price_per_night' => 29000,
                'max_guests' => 3,
                'category_id' => $apartments?->id,
                'amenities' => ['Wi-Fi', 'Mountain view', 'Parking', 'Air conditioning'],
            ],
        ];

        foreach ($propertiesData as $propertyData) {
            $amenityNames = $propertyData['amenities'];
            unset($propertyData['amenities']);

            $property = Property::query()->updateOrCreate(
                ['title' => $propertyData['title']],
                array_merge($propertyData, ['user_id' => $owner->id]),
            );

            $amenityIds = Amenity::query()
                ->whereIn('name', $amenityNames)
                ->pluck('id');

            $property->amenities()->sync($amenityIds);
        }

        $firstProperty = Property::query()->where('title', 'Cozy apartment near Arbat')->first();
        $secondProperty = Property::query()->where('title', 'Apartment with Kok-Tobe view')->first();
        $thirdProperty = Property::query()->where('title', 'Studio near Mega Center')->first();

        if ($firstProperty) {
            $pastBooking = Booking::query()->updateOrCreate(
                [
                    'user_id' => $guest->id,
                    'property_id' => $firstProperty->id,
                    'start_date' => now()->subDays(12)->toDateString(),
                ],
                [
                    'end_date' => now()->subDays(9)->toDateString(),
                    'total_price' => $firstProperty->price_per_night * 3,
                    'status' => 'confirmed',
                ]
            );

            Review::query()->updateOrCreate(
                ['booking_id' => $pastBooking->id],
                [
                    'user_id' => $guest->id,
                    'property_id' => $firstProperty->id,
                    'rating' => 5,
                    'comment' => 'Very convenient location, clean and quiet. Check-in was quick.',
                ]
            );
        }

        if ($secondProperty) {
            Booking::query()->updateOrCreate(
                [
                    'user_id' => $secondGuest->id,
                    'property_id' => $secondProperty->id,
                    'start_date' => now()->addDays(6)->toDateString(),
                ],
                [
                    'end_date' => now()->addDays(9)->toDateString(),
                    'total_price' => $secondProperty->price_per_night * 3,
                    'status' => 'confirmed',
                ]
            );
        }

        if ($thirdProperty) {
            Booking::query()->updateOrCreate(
                [
                    'user_id' => $guest->id,
                    'property_id' => $thirdProperty->id,
                    'start_date' => now()->addDays(14)->toDateString(),
                ],
                [
                    'end_date' => now()->addDays(17)->toDateString(),
                    'total_price' => $thirdProperty->price_per_night * 3,
                    'status' => 'confirmed',
                ]
            );
        }
    }
}
