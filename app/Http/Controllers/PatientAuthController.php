<?php

namespace App\Http\Controllers;

use App\Http\Resources\PatientAuthResource;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientAuthController extends Controller
{
    public $patient_id;

    public function __construct()
    {
        $this->patient_id = Patient::checkPatientid(request()->header('Auth_Patient'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PatientAuthResource($this->authPatient());
    }

    private function authPatient()
    {
        return Patient::where('id', $this->patient_id)->first();
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $pat = Patient::where('email', $credentials['email'])->firstOrFail();
        if (Hash::check($credentials['password'], $pat->password)) {
            return new PatientResource($pat);
        } else {
            return response()->json(['error' => 'Invalid Credentials'], 500);
        }
    }

    // public function show(Patient $patient)
    // {
    //     //
    // }

    // public function update(Request $request, Patient $patient)
    // {
    //     //
    // }

    // public function destroy(Patient $patient)
    // {
    //     //
    // }
}
