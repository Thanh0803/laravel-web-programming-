<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Grade;
use Faker\Generator as Faker;

class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Grade::class;
    public function definition()
    {
        return [
            //
            'gradeName' => $this->faker->text(),
            'grade' => 11,
        ];
    }
}
