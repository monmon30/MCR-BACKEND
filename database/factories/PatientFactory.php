<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            "firstname" => $this->faker->firstName(),
            "middlename" => $this->faker->lastName(),
            "lastname" => $this->faker->lastName(),
            "suffix" => $this->suffix(),
            "birthday" => $this->faker->date(),
            "sex" => $this->sex(),
            "address" => $this->faker->address(),
            "contact_number" => "09122348989",
            "landline" => $this->faker->phoneNumber(),
            "email" => $this->faker->safeEmail(),
            "weight" => 65,
            "height" => 165,
            "user_id" => User::factory(),
        ];
    }

    private function sex()
    {
        return Arr::random(["F", "M"], 1)[0];
    }

    private function suffix()
    {
        return Arr::random(['jr', 'sr', 'III'], 1)[0];
    }
}
