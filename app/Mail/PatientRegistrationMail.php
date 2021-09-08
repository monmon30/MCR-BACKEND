<?php

namespace App\Mail;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $patient;
    private $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Patient $patient, $password)
    {
        $this->patient = $patient;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.patient.registration', [
            'patient' => $this->patient,
            'password' => $this->password,
            'url' => env('FRONTEND_URL'),
        ]);
    }
}
