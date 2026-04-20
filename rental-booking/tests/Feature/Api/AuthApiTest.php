<?php

use App\Models\User;

test('user can register through api and receive token', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'API Owner',
        'email' => 'api-owner@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'role' => 'owner',
        'device_name' => 'pest',
    ]);

    $response->assertCreated()
        ->assertJsonPath('user.email', 'api-owner@example.com')
        ->assertJsonStructure(['token', 'user']);

    $this->assertDatabaseHas('users', [
        'email' => 'api-owner@example.com',
        'role' => 'owner',
    ]);
});

test('user can log in through api and receive token', function () {
    User::factory()->create([
        'email' => 'login@example.com',
        'password' => 'password',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'login@example.com',
        'password' => 'password',
        'device_name' => 'pest',
    ]);

    $response->assertOk()
        ->assertJsonPath('user.email', 'login@example.com')
        ->assertJsonStructure(['token']);
});
