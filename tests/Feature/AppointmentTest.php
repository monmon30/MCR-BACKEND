<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create(), 'api');
        Appointment::factory(6)->create();
    }

    public function test_doctor_can_fetch_the_not_done_appointments()
    {
        $apps = Appointment::where('done', 0)->get();

        $response = $this->get('/api/appointments');
        $response->assertStatus(200);
        $response->assertJson($this->collectionData($apps));
    }

    private function resourceData($app)
    {
        return [
            "data" => [
                "type" => "appointments",
                "appointment_id" => $app->id,
                "attributes" => [
                    "reason" => $app->reason,
                    "schedule" => $app->schedule,
                    "doctor" => $app->user_id,
                    "done" => $app->done,
                ],
            ],
        ];
    }

    private function collectionData($apps)
    {
        $appArr = [];
        foreach ($apps as $app) {
            array_push($appArr, $this->resourceData($app));
        }

        return [
            "data" => $appArr,
            "links" => [
                "self" => url("/api/appointments"),
            ],
        ];
    }
}
