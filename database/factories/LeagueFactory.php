<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\League>
 */
class LeagueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Premier League', 'La Liga', 'Bundesliga', 'Serie A', 'Ligue 1']) . ' ' . $this->faker->year(),
            'country' => $this->faker->country(),
            'season_start_year' => 2025,
            'season_end_year' => 2026,
            'logo_path' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraph(),
            'is_active' => true,
        ];
    }
}
