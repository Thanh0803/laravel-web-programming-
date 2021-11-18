<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Level;
use Faker\Generator as Faker;
class LevelFactory extends Factory
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
            'level' => $this->faker->text(),
            //'email' => $this->faker->email(),
            'admin_id' => 1,
        ];
    }
}
