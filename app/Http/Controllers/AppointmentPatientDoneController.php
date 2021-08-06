<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentPatientDoneController extends Controller
{
    public function mark_done(Request $request, Patient $patient, Appointment $appointment)
    {
        $appointment->where('patient_id', $patient->id)
            ->where('id', $appointment->id)
            ->update([
                'user_id' => auth()->user()->id,
                'done' => true,
            ]);

        return new AppointmentResource(Appointment::where('id', $appointment->id)->first());
    }
}
