<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'short_name' => $this->faker->lexify('???'),
            'logo_path' => $this->faker->imageUrl(),
            'city' => $this->faker->city(),
            'stadium' => $this->faker->streetName() . ' Stadium',
            'founded_year' => $this->faker->numberBetween(1880, 2020),
            'description' => $this->faker->paragraph(),
        ];
    }
}
