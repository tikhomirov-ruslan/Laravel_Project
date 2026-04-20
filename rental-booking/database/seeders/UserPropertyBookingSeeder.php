<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserPropertyBookingSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::query()->updateOrCreate(
            ['email' => 'user1@example.com'],
            ['name' => 'User One', 'password' => 'password', 'role' => 'customer']
        );

        User::query()->updateOrCreate(
            ['email' => 'user2@example.com'],
            ['name' => 'User Two', 'password' => 'password', 'role' => 'customer']
        );

        $owner = User::query()->updateOrCreate(
            ['email' => 'owner@example.com'],
            ['name' => 'Property Owner', 'password' => 'password', 'role' => 'owner']
        );

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => 'password', 'role' => 'admin']
        );

        if (Property::query()->count() === 0) {
            Property::factory(5)->create([
                'user_id' => $owner->id,
            ])->each(function (Property $property) {
                $amenityIds = Amenity::query()->inRandomOrder()->take(3)->pluck('id');
                $property->amenities()->sync($amenityIds);
            });
        }

        $property = Property::query()->first();

        if ($property) {
            Booking::query()->firstOrCreate(
                [
                    'user_id' => $customer->id,
                    'property_id' => $property->id,
                    'start_date' => now()->addDays(5)->toDateString(),
                ],
                [
                    'end_date' => now()->addDays(7)->toDateString(),
                    'total_price' => $property->price_per_night * 2,
                    'status' => 'confirmed',
                ],
            );
        }
    }
}
