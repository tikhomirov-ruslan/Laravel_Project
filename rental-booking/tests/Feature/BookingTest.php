<?php

use App\Models\Booking;
use App\Models\Property;
use App\Models\User;

test('user can book available property', function () {
    $user = User::factory()->create();
    $property = Property::factory()->create(['price_per_night' => 100]);

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/bookings', [
        'property_id' => $property->id,
        'start_date' => now()->addDays(3)->toDateString(),
        'end_date' => now()->addDays(5)->toDateString(),
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.total_price', 200.0)
        ->assertJsonPath('data.status', 'confirmed');
});

test('cannot double book same dates', function () {
    $user = User::factory()->create();
    $property = Property::factory()->create(['price_per_night' => 100]);

    Booking::query()->create([
        'user_id' => $user->id,
        'property_id' => $property->id,
        'start_date' => now()->addDays(10)->toDateString(),
        'end_date' => now()->addDays(12)->toDateString(),
        'total_price' => 200,
        'status' => 'confirmed',
    ]);

    $response = $this->actingAs($user, 'sanctum')->postJson('/api/bookings', [
        'property_id' => $property->id,
        'start_date' => now()->addDays(11)->toDateString(),
        'end_date' => now()->addDays(13)->toDateString(),
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['start_date']);
});

test('admin can see all bookings while customer sees only own bookings', function () {
    $admin = User::factory()->admin()->create();
    $customerA = User::factory()->create();
    $customerB = User::factory()->create();
    $property = Property::factory()->create();

    Booking::query()->create([
        'user_id' => $customerA->id,
        'property_id' => $property->id,
        'start_date' => now()->addDays(2)->toDateString(),
        'end_date' => now()->addDays(4)->toDateString(),
        'total_price' => 100,
        'status' => 'confirmed',
    ]);

    Booking::query()->create([
        'user_id' => $customerB->id,
        'property_id' => $property->id,
        'start_date' => now()->addDays(6)->toDateString(),
        'end_date' => now()->addDays(8)->toDateString(),
        'total_price' => 100,
        'status' => 'confirmed',
    ]);

    $adminResponse = $this->actingAs($admin, 'sanctum')->getJson('/api/bookings');
    $customerResponse = $this->actingAs($customerA, 'sanctum')->getJson('/api/bookings');

    $adminResponse->assertOk();
    expect($adminResponse->json('data'))->toHaveCount(2);

    $customerResponse->assertOk();
    expect($customerResponse->json('data'))->toHaveCount(1);
});
