<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;

class AppointmentPatientController extends Controller
{
    public function store(AppointmentRequest $request, Patient $patient)
    {
        $data = $patient->appointments()->create($request->validated());
        return new PatientResource(Patient::where('id', $data->patient_id)->first());
    }

    public function index(Patient $patient)
    {
        return new PatientResource($patient);
    }
}
