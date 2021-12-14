<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Account;
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Account::class;
    public function definition()
    {
        return [
            'username' => $this->faker->userName(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
        ];
    }
}