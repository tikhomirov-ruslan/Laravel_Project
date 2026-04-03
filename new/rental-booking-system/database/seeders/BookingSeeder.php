<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $properties = Property::all();

        foreach ($customers as $customer) {
            Booking::create([
                'property_id' => $properties->random()->id,
                'user_id' => $customer->id,
                'check_in' => Carbon::today()->addDays(rand(1, 10)),
                'check_out' => Carbon::today()->addDays(rand(11, 20)),
                'total_price' => rand(100, 1000),
                'status' => 'confirmed',
            ]);
        }
    }
}
