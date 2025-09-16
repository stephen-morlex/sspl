<?php

namespace Database\Factories;

use App\Models\Fixture;
use App\Models\MatchEvent;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatchEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MatchEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Create related models if they don't exist
        $fixture = Fixture::first() ?? Fixture::factory()->create();
        $team = Team::first() ?? Team::factory()->create();
        $player = Player::first() ?? Player::factory()->create(['team_id' => $team->id]);

        return [
            'match_id' => $fixture->id,
            'team_id' => $team->id,
            'player_id' => $player->id,
            'event_type' => $this->faker->randomElement([
                'goal', 'penalty_goal', 'own_goal', 'yellow_card', 'red_card',
                'second_yellow', 'substitution', 'corner', 'offside', 'foul',
                'penalty_missed', 'injury', 'VAR_review'
            ]),
            'minute' => $this->faker->numberBetween(0, 90),
            'period' => $this->faker->randomElement(['1H', 'HT', '2H', 'ET', 'FT', 'PENALTIES']),
            'details' => null,
            'pitch_position' => null,
            'updated_score' => null,
            'source' => $this->faker->word,
            'created_by' => $this->faker->name,
        ];
    }
}