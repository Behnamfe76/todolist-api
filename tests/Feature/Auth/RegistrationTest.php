<?php

test('new users can register', function () {
    // Send the registration request
    $response = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201);

    $response->assertJsonStructure([
        'user' => ['id', 'name', 'email'],
        'token',
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);

    $user = \App\Models\User::where('email', 'test@example.com')->first();
    $this->assertTrue(\Illuminate\Support\Facades\Hash::check('password', $user->password));
});
