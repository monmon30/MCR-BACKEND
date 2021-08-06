<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
                "type" => "appointments",
                "appointment_id" => $this->id,
                "attributes" => [
                    "reason" => $this->reason,
                    "schedule" => $this->schedule,
                    "doctor" => $this->user_id,
                    "done" => boolval($this->done),
                ],
            ],
            "links" => [
                "self" => url("/api/appointments/$this->id"),
            ],
        ];
    }
}
