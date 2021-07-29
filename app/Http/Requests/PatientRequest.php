<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => "",
            'middlename' => "",
            'lastname' => "",
            'suffix' => "",
            'birthday' => "",
            'sex' => "",
            'address' => "",
            'contact_number' => "",
            'landline' => "",
            'email' => "",
            'weight' => "",
            'height' => "",
        ];
    }
}
