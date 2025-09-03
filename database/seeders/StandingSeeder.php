<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Standing;
use App\Models\Team;
use App\Models\League;

class StandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leagues = League::all();
        $teams = Team::all();
        
        // Create standings for each league
        foreach ($leagues as $league) {
            // Create standings for each team in the league
            foreach ($teams->take(20) as $team) {
                Standing::create([
                    'team_id' => $team->id,
                    'league_id' => $league->id,
                    // All statistics are calculated dynamically from fixtures
                ]);
            }
        }
    }
}
