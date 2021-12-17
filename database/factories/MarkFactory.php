<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MarkFactory extends Factory
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
            'student_id' => 1,
            'type_id' =>1,
            'subject_id' => 1,
            'mark' => 9,
        ];
    }
}
