<?php

namespace Database\Factories;

use App\Models\PricingModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ID' => $this->faker->unique()->numberBetween(0,1000),
            'name' => $this->faker->name(),
            'email' =>$this->faker->unique()->safeEmail(),
            'PID' => PricingModel::all()->random()->pid,
            'password' => $this->faker->password(),
        ];
    }
}
