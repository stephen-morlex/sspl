<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;
use App\Models\League;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fixture>
 */
class FixtureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'home_team_id' => Team::factory(),
            'away_team_id' => Team::factory(),
            'league_id' => League::factory(),
            'kickoff_time' => $this->faker->dateTimeBetween('now', '+1 month'),
            'venue' => $this->faker->streetName() . ' Stadium',
            'home_score' => null,
            'away_score' => null,
            'status' => $this->faker->randomElement(['scheduled', 'live', 'finished', 'postponed']),
            'match_summary' => $this->faker->optional()->paragraph(),
        ];
    }
}
