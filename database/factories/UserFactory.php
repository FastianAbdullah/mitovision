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
           
            'name' => $this->faker->name(),
            'email' =>$this->faker->unique()->safeEmail(),
            'pricing_id' => 1,
            'password' => $this->faker->password(),
        ];
    }
}
