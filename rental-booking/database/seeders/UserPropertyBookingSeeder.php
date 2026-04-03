<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Amenity;

class UserPropertyBookingSeeder extends Seeder
{
    public function run()
    {
        // Создаём обычных пользователей, если их ещё нет
        User::firstOrCreate(
            ['email' => 'user1@example.com'],
            ['name' => 'User One', 'password' => bcrypt('password'), 'role' => 'customer']
        );
        User::firstOrCreate(
            ['email' => 'user2@example.com'],
            ['name' => 'User Two', 'password' => bcrypt('password'), 'role' => 'customer']
        );

        // Администратор
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        // Если нет ни одного свойства, создаём 5 свойств
        if (Property::count() == 0) {
            $users = User::where('role', 'customer')->get();
            if ($users->isEmpty()) {
                $users = User::all();
            }

            Property::factory(5)->make()->each(function ($property) use ($users) {
                $property->user_id = $users->random()->id;
                $property->save();
                // Привязываем случайные удобства
                $amenities = Amenity::inRandomOrder()->take(3)->get();
                $property->amenities()->attach($amenities);
            });
        }

        // Создаём бронирование, если ещё нет
        if (Booking::count() == 0) {
            $user = User::where('email', 'user1@example.com')->first();
            $property = Property::first();

            if ($user && $property) {
                Booking::create([
                    'user_id' => $user->id,
                    'property_id' => $property->id,
                    'start_date' => now()->addDays(5),
                    'end_date' => now()->addDays(7),
                    'total_price' => $property->price_per_night * 2,
                    'status' => 'confirmed',
                ]);
            }
        }
    }
}
