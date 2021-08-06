<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentPatientTest extends TestCase
{
    use RefreshDatabase;
    public function setup(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        User::factory()->create(['roles' => config('roles.roles')[1]]);
        Patient::factory()->create();
    }

    public function test_patient_can_make_an_appointment()
    {
        $doc = User::first()->roles;
        $pat = Patient::first();

        $res = $this->post("/api/patients/$pat->id/appointments", [
            "schedule" => now(),
            "reason" => "nagtatae",
        ]);
        $app = Appointment::first();
        $this->assertCount(1, Appointment::all());
        $this->assertNotNull($app->schedule);
        $this->assertEquals("nagtatae", $app->reason);
        $res->assertOk();
        $res->assertJson([
            "data" => [
                "type" => "patient",
                "patient_id" => $pat->id,
                "attributes" => [
                    "fullname" => $pat->fullname,
                    "firstname" => $pat->firstname,
                    "middlename" => $pat->middlename,
                    "lastname" => $pat->lastname,
                    "suffix" => $pat->suffix,
                    "birthday" => $pat->birthday,
                    "sex" => $pat->sex,
                    "address" => $pat->address,
                    "contact_number" => $pat->contact_number,
                    "landline" => $pat->landline,
                    "email" => $pat->email,
                    "weight" => $pat->weight,
                    "height" => $pat->height,
                ],
                "appointments" => [
                    "data" => [
                        [
                            "data" => [
                                "type" => "appointments",
                                "appointment_id" => $app->id,
                                "attributes" => [
                                    "reason" => $app->reason,
                                    "schedule" => $app->schedule,
                                    "doctor" => $app->user_id,
                                    "done" => $app->done,
                                    "patient_id" => $pat->id,
                                    "patient_name" => $pat->fullname,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'links' => [
                'self' => url("/api/patient/$pat->id"),
            ],
        ]);
    }

    public function test_fetch_patient_appointments()
    {
        $pat = Patient::first();
        $doc = User::first();
        $apps = Appointment::factory(3)->create(['patient_id' => $pat->id, "done" => 0]);
        $res = $this->get("/api/patients/$pat->id/appointments");
        $res->assertOk();
        $res->assertJson([
            "data" => [
                "type" => "patient",
                "patient_id" => $pat->id,
                "attributes" => [
                    "fullname" => $pat->fullname,
                    "firstname" => $pat->firstname,
                    "middlename" => $pat->middlename,
                    "lastname" => $pat->lastname,
                    "suffix" => $pat->suffix,
                    "birthday" => $pat->birthday,
                    "sex" => $pat->sex,
                    "address" => $pat->address,
                    "contact_number" => $pat->contact_number,
                    "landline" => $pat->landline,
                    "email" => $pat->email,
                    "weight" => $pat->weight,
                    "height" => $pat->height,
                ],
                "appointments" => $this->collectionData($apps),

            ],
            'links' => [
                'self' => url("/api/patient/$pat->id"),
            ],
        ]);

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
