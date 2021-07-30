<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create(), 'api');
    }

    public function test_user_can_add_patient()
    {
        $response = $this->post('/api/patients', [
            'firstname' => "mon",
            'middlename' => "lag",
            'lastname' => "cun",
            'suffix' => "jr",
            'birthday' => "1991-12-01",
            'sex' => "M",
            'address' => 'tambunting',
            'contact_number' => '09123456789',
            'landline' => '123-1234',
            'email' => 'monmon@test.com',
            'weight' => 65,
            'height' => 165,
        ]);

        $patient = Patient::first();

        $this->assertEquals($patient->firstname, "MON");
        $this->assertEquals($patient->lastname, "CUN");
        $this->assertEquals($patient->middlename, "LAG");
        $this->assertEquals($patient->suffix, "JR");
        $this->assertEquals($patient->birthday, "1991-12-01");
        $this->assertEquals($patient->sex, "M");
        $this->assertEquals($patient->address, "TAMBUNTING");
        $this->assertEquals($patient->contact_number, "09123456789");
        $this->assertEquals($patient->landline, "123-1234");
        $this->assertEquals($patient->email, "monmon@test.com");
        $this->assertEquals($patient->weight, 65);
        $this->assertEquals($patient->height, 165);
        $this->assertCount(1, Patient::all());
        $response->assertCreated();
        $response->assertJson($this->resourceData($patient));
    }

    public function test_user_can_fetch_patients()
    {
        Patient::factory(3)->create();
        $patients = Patient::all();
        $res = $this->get('/api/patients');
        $res->assertOk();

        $this->assertCount(3, $patients);
        $res->assertJson($this->collectionData($patients));
        $res->assertJsonStructure(['meta', 'data', 'links']);
    }

    public function test_user_can_fetch_patient()
    {
        $patient = Patient::factory()->create();
        $res = $this->get("/api/patients/$patient->id");
        $res->assertOk();
        $res->assertJson($this->resourceData($patient));
    }

    public function test_user_can_update_patient_data()
    {
        $patient = Patient::factory()->create(['firstname' => 'etits']);
        $res = $this->put("/api/patients/$patient->id", [
            'firstname' => "monmon",
            'middlename' => "lagas",
            'lastname' => "cunanan",
            'suffix' => "III",
            'birthday' => "1992-12-02",
            'sex' => "f",
            'address' => 'sampaloc',
            'contact_number' => '09112223333',
            'landline' => '888-8888',
            'email' => 'nomnom@test.com',
            'weight' => 64,
            'height' => 100,
        ]);

        $_patient = Patient::first();

        $this->assertEquals($_patient->firstname, "MONMON");
        $this->assertEquals($_patient->middlename, "LAGAS");
        $this->assertEquals($_patient->lastname, "CUNANAN");
        $this->assertEquals($_patient->suffix, "III");
        $this->assertEquals($_patient->birthday, "1992-12-02");
        $this->assertEquals($_patient->sex, "F");
        $this->assertEquals($_patient->address, "SAMPALOC");
        $this->assertEquals($_patient->contact_number, "09112223333");
        $this->assertEquals($_patient->landline, "888-8888");
        $this->assertEquals($_patient->email, "nomnom@test.com");
        $this->assertEquals($_patient->weight, 64);
        $this->assertEquals($_patient->height, 100);
        $res->assertOk();
        $res->assertJson($this->resourceData($_patient));
    }

    public function test_user_can_delete_patient()
    {
        $patient = Patient::factory()->create();
        $res = $this->delete("/api/patients/$patient->id");
        $this->assertSoftDeleted($patient);
        $this->assertCount(0, Patient::all());
        $res->assertNoContent();

    }

    private function resourceData($patient)
    {
        return [
            "data" => [
                "type" => "patient",
                "patient_id" => $patient->id,
                "attributes" => [
                    "fullname" => $patient->fullname,
                    "firstname" => $patient->firstname,
                    "middlename" => $patient->middlename,
                    "lastname" => $patient->lastname,
                    "suffix" => $patient->suffix,
                    "birthday" => $patient->birthday,
                    "sex" => $patient->sex,
                    "address" => $patient->address,
                    "contact_number" => $patient->contact_number,
                    "landline" => $patient->landline,
                    "email" => $patient->email,
                    "weight" => $patient->weight,
                    "height" => $patient->height,
                ],
            ],
            'links' => [
                'self' => url("/api/patient/$patient->id"),
            ],
        ];
    }

    private function collectionData($patients)
    {
        $patientArr = [];
        foreach ($patients as $patient) {
            array_push($patientArr, $this->resourceData($patient));
        }

        return [
            "data" => $patientArr,
            "links" => [
                "self" => url("/api/patients"),
            ],
        ];
    }

}
