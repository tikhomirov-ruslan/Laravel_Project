<?php

use App\Models\User;
use App\Models\Property;

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('owner can create property', function () {
    $owner = User::factory()->create(['role' => 'owner']);
    $response = $this->actingAs($owner, 'sanctum')
        ->postJson('/api/properties', [
            'title' => 'Test Property',
            'description' => 'Desc',
            'address' => 'Address',
            'price_per_night' => 100,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'max_guests' => 4,
        ]);
    $response->assertStatus(201);
    $this->assertDatabaseHas('properties', ['title' => 'Test Property']);
});
