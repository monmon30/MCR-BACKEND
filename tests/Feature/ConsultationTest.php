<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create(), 'api');
    }

    public function test_user_can_add_consultations_on_patient()
    {
        $patient = Patient::factory()->create();
        $app = Appointment::factory()->create(['patient_id' => $patient->id]);

        $response = $this->post("/api/patients/$patient->id/consultations", [
            "findings" => "jebs ng jebs pag umaga",
            "prescription" => "diatabs pre",
            "recommendation" => "iwasan kumain ng peanut pre.",
            "weight" => 60,
            "height" => 160,
            "temperature" => "36.4",
            "blood_pressure" => "120/80",
            "appointment_id" => $app->id,
        ]);

        $patientCon = $patient->consultations()->first();
        $this->assertEquals($patientCon->findings, "jebs ng jebs pag umaga");
        $this->assertEquals($patientCon->prescription, "diatabs pre");
        $this->assertEquals($patientCon->recommendation, "iwasan kumain ng peanut pre.");
        $this->assertEquals($patientCon->weight, 60);
        $this->assertEquals($patientCon->height, 160);
        $this->assertEquals($patientCon->user_id, auth()->user()->id);
        $this->assertEquals("36.4", $patientCon->temperature);
        $this->assertEquals("120/80", $patientCon->blood_pressure);
        $this->assertEquals($app->id, $patientCon->appointment_id);

        $response->assertCreated();
        $response->assertJson($this->resourceData($patientCon));
    }

    public function test_user_can_fetch_all_the_patients_consultation()
    {
        $patient = Patient::factory()->create();
        $consultations = Consultation::factory(2)->create(['patient_id' => $patient->id]);
        $res = $this->get("/api/patients/$patient->id/consultations");
        $res->assertOk();
        $res->assertJson($this->collectionData($consultations));
    }

    public function test_user_can_fetch_the_patients_consultations()
    {
        $patient = Patient::factory()->create();
        $consultation = Consultation::factory()->create(['patient_id' => $patient->id]);
        $res = $this->get("/api/patients/$patient->id/consultations/$consultation->id");
        $res->assertOk();
        $res->assertJson($this->resourceData($consultation));
    }

    public function test_user_can_update_the_patients_consultation()
    {
        $patient = Patient::factory()->create();
        $patient2 = Patient::factory()->create();
        $consultation = Consultation::factory()->create([
            'patient_id' => $patient->id,
            'findings' => 'betlog',
        ]);

        $res = $this->put("/api/patients/$patient->id/consultations/$consultation->id", [
            "findings" => "findings 2",
            "prescription" => "prescription 2",
            "recommendation" => "recommendation 2",
            "weight" => "120",
            "height" => "240",
            "added_by" => $consultation->user->fullname,
        ]);
        $con = Consultation::first();
        $this->assertEquals($con->findings, "findings 2");
        $this->assertEquals($con->prescription, "prescription 2");
        $this->assertEquals($con->recommendation, "recommendation 2");
        $this->assertEquals($con->weight, "120");
        $this->assertEquals($con->height, "240");
        $res->assertOk();
        $res->assertJson($this->resourceData($con));

    }

    public function test_user_can_delete_patient_consultation()
    {
        $patient = Patient::factory()->create();
        $consultation = Consultation::factory()->create(['patient_id' => $patient->id]);
        $res = $this->delete("/api/patients/$patient->id/consultations/$consultation->id");
        $this->assertSoftDeleted($consultation);
        $this->assertCount(0, Consultation::all());
        $res->assertNoContent();

    }

    private function resourceData($consultation)
    {
        return [
            "data" => [
                "type" => "consultations",
                "consultation_id" => $consultation->id,
                "attributes" => [
                    "patient_id" => $consultation->patient_id,
                    "findings" => $consultation->findings,
                    "prescription" => $consultation->prescription,
                    "recommendation" => $consultation->recommendation,
                    "weight" => $consultation->weight,
                    "height" => $consultation->height,
                    "temperature" => $consultation->temperature,
                    "blood_pressure" => $consultation->blood_pressure,
                    "added_by" => $consultation->user->fullname,
                    "appointment_id" => $consultation->appointment_id,
                ],
            ],
            "links" => [
                "self" => url("/api/patients/" . $consultation->patient_id . "/consultation/" . $consultation->id),
            ],
        ];
    }

    private function collectionData($consultations)
    {
        $consultationArr = [];
        foreach ($consultations as $consultation) {
            array_push($consultationArr, $this->resourceData($consultation));
        }

        return [
            "data" => $consultationArr,
            "links" => [
                "self" => url("/api/consultations"),
            ],
        ];
    }
}
