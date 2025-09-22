<?php

namespace Database\Factories;

use App\Enums\LineupStatus;
use App\Models\Fixture;
use App\Models\Lineup;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lineup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fixture_id' => Fixture::factory(),
            'team_id' => Team::factory(),
            'player_id' => Player::factory(),
            'position' => $this->faker->randomElement(['GK', 'DEF', 'MID', 'FWD']),
            'is_starting' => $this->faker->boolean(80), // 80% chance of starting
            'status' => $this->faker->randomElement(array_column(LineupStatus::cases(), 'value')),
        ];
    }
}