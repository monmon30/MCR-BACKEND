<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                "type" => "users",
                "user_id" => $this->id,
                "attributes" => [
                    "fullname" => $this->fullname,
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
