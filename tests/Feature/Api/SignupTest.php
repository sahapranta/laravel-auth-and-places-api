<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignupTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_successful_signup()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/signup', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_duplicate_email_registration()
    {
        User::factory()->create([
            'email' => 'existinguser@example.com',
        ]);

        $userData = [
            'name' => 'Existing User',
            'email' => 'existinguser@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/signup', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
