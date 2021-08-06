<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Patient;
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

    public function test_doctor_can_make_the_appointment_done()
    {
        $pat = Patient::factory()->create();
        $app = Appointment::factory()->create(['patient_id' => $pat->id, 'done' => false, 'user_id' => null]);
        $res = $this->post("/api/patients/$pat->id/appointments/$app->id/done");

        $res->assertOk();
        $_app = Appointment::where('id', $app->id)->where('patient_id', $pat->id)->first();
        $this->assertEquals($_app->patient_id, $pat->id);
        $this->assertTrue($_app->done);
        $this->assertNotNull($_app->user_id);
        $this->assertEquals(auth()->user()->id, $_app->user_id);
        $res->assertJson($this->resourceData($_app));

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
