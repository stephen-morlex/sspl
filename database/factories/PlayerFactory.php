<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'team_id' => Team::factory(),
            'position' => $this->faker->randomElement(['GK', 'DEF', 'MID', 'FWD']),
            'shirt_number' => $this->faker->numberBetween(1, 99),
            'date_of_birth' => $this->faker->date(),
            'nationality' => $this->faker->country(),
            'height' => $this->faker->numberBetween(160, 200),
            'weight' => $this->faker->numberBetween(60, 100),
            'bio' => $this->faker->paragraph(),
            'photo_path' => $this->faker->imageUrl(),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
