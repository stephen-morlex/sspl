<?php

namespace Database\Factories;

use App\Models\Lineup;
use App\Models\LineupPlayer;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineupPlayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LineupPlayer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'lineup_id' => Lineup::factory(),
            'player_id' => Player::factory(),
            'role' => $this->faker->randomElement(['starting', 'bench']),
            'position_on_pitch' => null,
            'entered_at_minute' => null,
            'substituted_out_minute' => null,
        ];
    }
}
