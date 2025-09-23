<?php

namespace Database\Factories;

use App\Models\Coach;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoachFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coach::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'team_id' => Team::factory(),
            'date_of_birth' => $this->faker->date(),
            'nationality' => $this->faker->country(),
            'bio' => $this->faker->paragraph(),
            'photo_path' => null,
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
