<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "data" => [
                "type" => "consultations",
                "consultation_id" => $this->id,
                "attributes" => [
                    "patient_id" => $this->patient_id,
                    "findings" => $this->findings,
                    "prescription" => $this->prescription,
                    "recommendation" => $this->recommendation,
                    "weight" => $this->weight,
                    "height" => $this->height,
                    "added_by" => $this->user->fullname,
                ],
            ],
            "links" => [
                "self" => url("/api/patients/$this->patient_id/consultation/$this->id"),
            ],
        ];

    }
}