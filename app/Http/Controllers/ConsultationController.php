<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultationRequest;
use App\Http\Resources\ConsultationCollection;
use App\Http\Resources\ConsultationResource;
use App\Models\Consultation;
use App\Models\Patient;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Patient $patient)
    {
        $consultations = Consultation::where("patient_id", $patient->id)->get();
        return new ConsultationCollection($consultations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsultationRequest $request, Patient $patient)
    {
        $data = $patient->consultations()->create([
            'user_id' => auth()->user()->id,
            'findings' => $request->findings,
            'recommendation' => $request->recommendation,
            'prescription' => $request->prescription,
            'weight' => $request->weight,
            'height' => $request->height,
        ]);

        return new ConsultationResource($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient, Consultation $consultation)
    {
        return new ConsultationResource(
            $consultation->where('patient_id', $patient->id)
                ->first()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultationRequest $request, Patient $patient, Consultation $consultation)
    {
        $consultation->where("patient_id", $patient->id)->update($request->validated());
        return new ConsultationResource($consultation->where("patient_id", $patient->id)->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient, Consultation $consultation)
    {
        $consultation->delete();
        return response()->json([], 204);
    }
}
