<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
                "type" => "patient",
                "patient_id" => $this->id,
                "attributes" => [
                    "fullname" => $this->fullname,
                    "firstname" => $this->firstname,
                    "middlename" => $this->middlename,
                    "lastname" => $this->lastname,
                    "suffix" => $this->suffix,
                    "birthday" => $this->birthday,
                    "sex" => $this->sex,
                    "address" => $this->address,
                    "contact_number" => $this->contact_number,
                    "landline" => $this->landline,
                    "email" => $this->email,
                    "weight" => $this->weight,
                    "height" => $this->height,
                ],
            ],
            'links' => [
                'self' => url("/api/patient/$this->id"),
            ],
        ];
    }
}
