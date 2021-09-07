<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\PDFService;

class PatientConsultationsReportController extends Controller
{
    public function __invoke(Patient $patient)
    {
        $data = [
            "patient" => $patient,
            "consultations" => $patient->consultations,
        ];

        return response()->json(["data" => PDFService::generate_pdf_base64($data, 'pdf.patient', $patient->fullname . 'pdf')]);
    }
}
