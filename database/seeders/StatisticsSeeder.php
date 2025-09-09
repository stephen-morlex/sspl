<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Statistics;
use App\Models\Player;
use App\Models\Fixture;
use Illuminate\Support\Str;

class StatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $players = Player::all();
        $fixtures = Fixture::all();
        
        // Create statistics for each player in each fixture they played
        foreach ($players->take(50) as $player) {
            // Create 5 statistics records for each player
            foreach ($fixtures->random(5) as $fixture) {
                Statistics::create([
                    'id' => (string) Str::ulid(),
                    'player_id' => $player->id,
                    'match_id' => $fixture->id,
                    'goals' => rand(0, 3),
                    'assists' => rand(0, 2),
                    'penalties' => rand(0, 1),
                    'penalties_scored' => rand(0, 1),
                    'shots_on_goal' => rand(0, 5),
                    'woodwork_hits' => rand(0, 2),
                    'tackles_won' => rand(0, 10),
                    'aerial_duels_won' => rand(0, 15),
                    'fouls_committed' => rand(0, 5),
                    'yellow_cards' => rand(0, 1),
                    'sprints' => rand(10, 50),
                    'intensive_runs' => rand(5, 30),
                    'distance_km' => rand(5, 15),
                    'top_speed_kmh' => rand(20, 35),
                    'crosses' => rand(0, 10),
                ]);
            }
        }
    }
}