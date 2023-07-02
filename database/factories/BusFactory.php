<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bus>
 */
class BusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration_number'=>fake()->unique()->regexify('[A-Z0-9]{7}'),
            'type'=>fake()->randomElement(['ac','normal','mini']),
            'capacity'=>fake()->numberBetween(10, 60)
        ];
    }
}
