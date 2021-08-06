<?php

namespace Database\Factories;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ConsultationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Consultation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "patient_id" => Patient::factory(),
            "user_id" => User::factory(),
            "findings" => "findings",
            "recommendation" => "recommendation",
            "prescription" => "prescription",
            "temperature" => "36.4",
            "blood_pressure" => "120/80",
            "weight" => strval(Arr::random([50, 55, 60])),
            "height" => strval(Arr::random([150, 155, 160])),
        ];
    }
}
