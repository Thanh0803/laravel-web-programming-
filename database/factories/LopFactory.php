<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LopFactory extends Factory
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
            'grade_id' => 3,
            'teacher_id' => 3,
        ];
    }
}
