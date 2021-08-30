<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCanResetPasswordTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create(), 'api');
    }

    public function test_user_can_reset_password_of_user()
    {
        $user = User::factory()->create();
        $response = $this->post("/api/users/$user->id/password/reset", [
            "password" => "fire123",
        ]);
        $_user = User::find($user->id);
        $response->assertStatus(200);
        $this->assertTrue(Hash::check("fire123", $_user->password));
        $response->assertJson($this->resourceData($_user));
    }

    private function resourceData(User $user)
    {
        return [
            "data" => [
                "type" => "users",
                "user_id" => $user->id,
                "attributes" => [
                    "fullname" => $user->fullname,
                    "firstname" => $user->firstname,
                    "middlename" => $user->middlename,
                    "lastname" => $user->lastname,
                    "email" => $user->email,
                    "roles" => $user->roles,
                    "birthday" => $user->birthday,
                ],
            ],
            "links" => [
                "self" => url("/api/users/$user->id"),
            ],
        ];
    }
}
