<?php

use App\Models\User;
use App\Models\Property;

test('user can book available property', function () {
    $user = User::factory()->create();
    $property = Property::factory()->create(['price_per_night' => 100]);

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/bookings', [
        'property_id' => $property->id,
        'start_date' => now()->addDays(3)->toDateString(),
        'end_date' => now()->addDays(5)->toDateString(),
    ]);

    $response->assertStatus(201);
    expect($response->json('total_price'))->toEqual(200);
});

test('cannot double book same dates', function () {
    // аналогично
});
