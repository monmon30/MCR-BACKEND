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

    public function test_fetch_all_user_accounts()
    {
        User::factory(3)->create();
        $users = User::all();
        $res = $this->get('/api/users');
        $res->assertOk();
        $res->assertJson($this->collectionData($users));
    }

    public function test_update_user_account()
    {
        $user = User::factory()->create();
        $res = $this->put("/api/users/$user->id", [
            "firstname" => "foon",
            "middlename" => "moon",
            "lastname" => "loon",
            "email" => "moon@test.com",
            "roles" => config('roles.roles')[1],
            "birthday" => "1993-01-08",
        ]);
        $res->assertOk();
        $_user = User::find($user->id);

        $this->assertEquals('FOON', $_user->firstname);
        $this->assertEquals('MOON', $_user->middlename);
        $this->assertEquals('LOON', $_user->lastname);
        $this->assertEquals('moon@test.com', $_user->email);
        $this->assertEquals('1993-01-08', $_user->birthday);
        $this->assertEquals(config('roles.roles')[1], $_user->roles);
        $res->assertExactJson($this->resourceData($_user));
        $res->assertJson($this->resourceData($_user));
    }

    public function test_fetch_user()
    {
        $user = User::factory()->create();

        $res = $this->get("/api/users/$user->id");
        $res->assertOk();
        $res->assertJson($this->resourceData($user));
    }

    public function test_delete_user_account()
    {
        $user = User::factory()->create();
        $res = $this->delete("/api/users/$user->id");
        $res->assertNoContent();
        $this->assertSoftDeleted($user);
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

    private function collectionData($users)
    {
        $userArr = [];
        foreach ($users as $user) {
            array_push($userArr, $this->resourceData($user));
        }

        return [
            "data" => $userArr,
            "links" => [
                "self" => url("/api/users"),
            ],
        ];
    }
}
