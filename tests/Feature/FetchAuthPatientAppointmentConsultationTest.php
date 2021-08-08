<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchAuthPatientAppointmentConsultationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function test_fetch_appointment_consultation_for_auth_patient()
    {
        $pat = Patient::factory()->create();
        $app = Appointment::factory()->create(['patient_id' => $pat->id]);
        $con = Consultation::factory()->create(['appointment_id' => $app->id, 'patient_id' => $pat->id]);
        $cons = Consultation::all();
        $response = $this->get("/api/appointments/$app->id/patients/$pat->id");
        $response->assertStatus(200);
        $response->assertJson($this->collectionData($cons));
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
                    "consultation_date" => $consultation->consultation_date,
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
