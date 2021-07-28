<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function test_user_can_login()
    {
        $auth = User::factory()->create([
            'email' => 'mon@test.com',
            'password' => Hash::make('water123'),
        ]);

        $response = $this->post("/api/auth/login", [
            'email' => "mon@test.com",
            'password' => "water123",
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token',
        ]);
    }
}
