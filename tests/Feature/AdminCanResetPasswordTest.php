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

    public function test_example()
    {
        $user = User::factory()->create();
        $response = $this->post("/api/users/$user->id/password/reset", [
            "password" => "fire123",
        ]);
        $_user = User::find($user->id);
        $response->assertStatus(200);
        $this->assertTrue(Hash::check("fire123", $_user->password));
    }
}
