<?php

namespace Database\Factories;

use App\Models\Fixture;
use App\Models\Lineup;
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
            'formation' => $this->faker->randomElement(['4-4-2', '4-3-3', '4-2-3-1', '3-5-2', '5-3-2']),
        ];
    }
}
