<?php

use App\Models\Amenity;
use App\Models\Category;
use App\Models\User;

test('owner can create property', function () {
    $owner = User::factory()->owner()->create();
    $category = Category::query()->create([
        'name' => 'Apartment',
        'slug' => 'apartment',
        'description' => 'Apartment category',
    ]);
    $amenity = Amenity::query()->create(['name' => 'Wi-Fi']);

    $response = $this->actingAs($owner, 'sanctum')->postJson('/api/properties', [
        'title' => 'City Loft',
        'description' => 'Spacious loft in the city center.',
        'address' => '10 Main Street',
        'price_per_night' => 140,
        'max_guests' => 3,
        'category_id' => $category->id,
        'amenities' => [$amenity->id],
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.title', 'City Loft');

    $this->assertDatabaseHas('properties', [
        'title' => 'City Loft',
        'user_id' => $owner->id,
    ]);
});

test('customer cannot create property', function () {
    $customer = User::factory()->create();
    $category = Category::query()->create([
        'name' => 'House',
        'slug' => 'house',
        'description' => 'House category',
    ]);

    $response = $this->actingAs($customer, 'sanctum')->postJson('/api/properties', [
        'title' => 'Forbidden Listing',
        'description' => 'Should not be created.',
        'address' => '11 Main Street',
        'price_per_night' => 90,
        'max_guests' => 2,
        'category_id' => $category->id,
    ]);

    $response->assertForbidden();
});
