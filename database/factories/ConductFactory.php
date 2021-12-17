<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ConductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'student_id' =>1,
            'mark' => $this->faker->text(),
            'semester' => 1,
        ];
    }
}
