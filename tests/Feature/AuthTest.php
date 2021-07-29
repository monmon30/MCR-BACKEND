<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            'password' => 'water123',
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

    public function test_fetch_auth_user_data()
    {
        $auth = User::factory()->create();
        $this->actingAs($auth, 'api');
        $res = $this->get('/api/auth/user');
        $res->assertOk();

        $this->assertNotNull($auth->firstname);
        $this->assertNotNull($auth->middlename);
        $this->assertNotNull($auth->lastname);
        $this->assertNotNull($auth->birthday);

        $res->assertExactJson([
            "data" => [
                "type" => "auth user",
                "user_id" => $auth->id,
                "attributes" => [
                    "firstname" => $auth->firstname,
                    "middlename" => $auth->middlename,
                    "lastname" => $auth->lastname,
                    "email" => $auth->email,
                    "birthday" => $auth->birthday,
                ],
            ],
            "links" => [
                "self" => url("/api/users/$auth->id"),
            ],
        ]);
    }
}
