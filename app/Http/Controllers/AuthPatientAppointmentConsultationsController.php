<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConsultationCollection;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Http\Request;

class AuthPatientAppointmentConsultationsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Appointment $appointment, Patient $patient)
    {
        return new ConsultationCollection(Consultation::where('appointment_id', $appointment->id)
                ->where('patient_id', $patient->id)
                ->get()
        );
    }
}
