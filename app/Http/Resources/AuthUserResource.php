<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
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
                "type" => "auth user",
                "user_id" => $this->id,
                "attributes" => [
                    "firstname" => $this->firstname,
                    "middlename" => $this->middlename,
                    "lastname" => $this->lastname,
                    "email" => $this->email,
                    "birthday" => $this->birthday,
                    "roles" => $this->roles,
                ],
            ],
            "links" => [
                "self" => url("/api/users/$this->id"),
            ],
        ];
    }
}
