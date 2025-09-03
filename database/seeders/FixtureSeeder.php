<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fixture;
use App\Models\Team;
use App\Models\League;

class FixtureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leagues = League::all();
        $teams = Team::all();
        
        // Create fixtures for each league
        foreach ($leagues as $league) {
            // Create 20 fixtures for each league
            for ($i = 0; $i < 20; $i++) {
                // Select two random different teams
                $homeTeam = $teams->random();
                $awayTeam = $teams->where('id', '!=', $homeTeam->id)->random();
                
                $statuses = ['scheduled', 'live', 'finished', 'postponed'];
                
                Fixture::create([
                    'home_team_id' => $homeTeam->id,
                    'away_team_id' => $awayTeam->id,
                    'league_id' => $league->id,
                    'kickoff_time' => now()->addDays(rand(0, 30))->addHours(rand(0, 23))->addMinutes(rand(0, 59)),
                    'venue' => $homeTeam->stadium,
                    'home_score' => rand(0, 5),
                    'away_score' => rand(0, 5),
                    'status' => $statuses[array_rand($statuses)],
                    'match_summary' => 'An exciting match between ' . $homeTeam->name . ' and ' . $awayTeam->name,
                ]);
            }
        }
    }
}
