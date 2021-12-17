<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AssignFactory extends Factory
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
            'teacher_id' => 2,
            'lop_id' => 1,
            'subject_id'=>1,
        ];
    }
}
