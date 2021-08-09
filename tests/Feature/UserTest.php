<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create(), 'api');
    }

    public function test_user_can_create_accounts()
    {
        $response = $this->post('/api/users', [
            'firstname' => 'fon',
            'middlename' => 'mon',
            'lastname' => 'lon',
            'email' => 'nom@test.com',
            'birthday' => '1992-02-02',
            'roles' => config('roles.roles')[0],
            'password' => 'tubig123',
        ]);
        $response->assertCreated();
        $user = User::where('email', 'nom@test.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('FON', $user->firstname);
        $this->assertEquals('MON', $user->middlename);
        $this->assertEquals('LON', $user->lastname);
        $this->assertEquals('nom@test.com', $user->email);
        $this->assertEquals('1992-02-02', $user->birthday);
        $this->assertEquals(config('roles.roles')[0], $user->roles);
        $this->assertTrue(Hash::check('tubig123', $user->password));
        $response->assertJson($this->resourceData($user));
    }

    public function resourceData(User $user)
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
