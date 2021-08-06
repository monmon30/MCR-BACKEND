<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "schedule" => $this->faker->dateTime(),
            "reason" => $this->faker->paragraph(1),
            "patient_id" => Patient::factory(),
            "done" => boolval(mt_rand(0, 1)),
        ];
    }
}
