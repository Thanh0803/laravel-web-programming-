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
            'className' => $this->faker->text(),
            // 'headTeacher' => 1,
            'user_id' => 1,
        ];
    }
}
