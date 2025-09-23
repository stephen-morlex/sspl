<?php

namespace Database\Factories;

use App\Models\Coach;
use App\Models\Fixture;
use App\Models\FixtureCoach;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class FixtureCoachFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FixtureCoach::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fixture_id' => Fixture::factory(),
            'coach_id' => Coach::factory(),
            'team_id' => Team::factory(),
        ];
    }
}
