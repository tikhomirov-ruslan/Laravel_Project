<?php

use App\Models\Booking;
use App\Models\Property;
use App\Models\User;

test('user can review completed own booking', function () {
    $user = User::factory()->create();
    $property = Property::factory()->create();

    $booking = Booking::query()->create([
        'user_id' => $user->id,
        'property_id' => $property->id,
        'start_date' => now()->subDays(5)->toDateString(),
        'end_date' => now()->subDays(2)->toDateString(),
        'total_price' => 300,
        'status' => 'confirmed',
    ]);

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/reviews', [
        'booking_id' => $booking->id,
        'rating' => 5,
        'comment' => 'Excellent stay.',
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.rating', 5);
});

test('user cannot review booking before stay ends', function () {
    $user = User::factory()->create();
    $property = Property::factory()->create();

    $booking = Booking::query()->create([
        'user_id' => $user->id,
        'property_id' => $property->id,
        'start_date' => now()->subDay()->toDateString(),
        'end_date' => now()->addDay()->toDateString(),
        'total_price' => 300,
        'status' => 'confirmed',
    ]);

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/reviews', [
        'booking_id' => $booking->id,
        'rating' => 4,
        'comment' => 'Too early.',
    ]);

    $response->assertStatus(422)
        ->assertJsonPath('message', 'Cannot review a stay before it ends.');
});
