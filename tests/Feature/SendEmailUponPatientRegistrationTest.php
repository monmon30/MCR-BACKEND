<?php

namespace Tests\Feature;

use App\Mail\PatientRegistrationMail;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendEmailUponPatientRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
        $this->actingAs(User::factory()->create(), 'api');
    }

    public function test_send_email_upon_registration_of_patient()
    {
        Mail::fake();

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
            'password' => 'water123',
        ]);

        Mail::assertSent(PatientRegistrationMail::class);

        $response->assertCreated();
    }

    public function test_the_contents_of_email()
    {
        $patient = Patient::factory()->create();

        $mailable = new PatientRegistrationMail($patient, 'water123');

        $mailable->assertSeeInHtml($patient->fullname);

        $mailable->assertSeeInHtml($patient->email);

        $mailable->assertSeeInHtml('water123');
    }
}
