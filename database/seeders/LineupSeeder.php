<?php

namespace Database\Seeders;

use App\Models\Coach;
use App\Models\Fixture;
use App\Models\FixtureCoach;
use App\Models\Lineup;
use App\Models\LineupPlayer;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LineupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some teams if they don't exist
        if (Team::count() < 4) {
            Team::factory(4)->create();
        }

        // Get all teams
        $teams = Team::all();

        // Create some players for each team if they don't exist
        foreach ($teams as $team) {
            if ($team->players()->count() < 18) {
                Player::factory(18)->create(['team_id' => $team->id]);
            }
        }

        // Create some coaches if they don't exist
        if (Coach::count() < $teams->count()) {
            Coach::factory($teams->count())->create();
        }

        // Create some fixtures if they don't exist
        if (Fixture::count() < 2) {
            $homeTeam = $teams->first();
            $awayTeam = $teams->skip(1)->first();
            Fixture::factory(2)->create([
                'home_team_id' => $homeTeam->id,
                'away_team_id' => $awayTeam->id,
            ]);
        }

        // Get all fixtures
        $fixtures = Fixture::all();

        // Create lineups for each fixture
        foreach ($fixtures as $fixture) {
            // Check if lineups already exist for this fixture
            if (Lineup::where('fixture_id', $fixture->id)->count() >= 2) {
                continue; // Skip if lineups already exist
            }

            // Create lineup for home team
            $homeLineup = Lineup::create([
                'fixture_id' => $fixture->id,
                'team_id' => $fixture->home_team_id,
                'formation' => '4-3-3',
            ]);

            // Create lineup for away team
            $awayLineup = Lineup::create([
                'fixture_id' => $fixture->id,
                'team_id' => $fixture->away_team_id,
                'formation' => '4-4-2',
            ]);

            // Get players for home team
            $homePlayers = Player::where('team_id', $fixture->home_team_id)->take(18)->get();
            
            // Ensure we have exactly one goalkeeper for starting lineup
            $homeGoalkeeper = $homePlayers->firstWhere('position', 'GK') ?? 
                              $homePlayers->first() ?? 
                              Player::factory()->create(['team_id' => $fixture->home_team_id, 'position' => 'GK']);
            
            // Get remaining players for starting lineup (10 outfield players)
            $homeOutfieldPlayers = $homePlayers->filter(fn($p) => $p->id !== $homeGoalkeeper->id)->take(10);
            
            // Get bench players (remaining players)
            $homeBenchPlayers = $homePlayers->filter(fn($p) => 
                $p->id !== $homeGoalkeeper->id && 
                !$homeOutfieldPlayers->contains('id', $p->id)
            )->take(7);

            // Get players for away team
            $awayPlayers = Player::where('team_id', $fixture->away_team_id)->take(18)->get();
            
            // Ensure we have exactly one goalkeeper for starting lineup
            $awayGoalkeeper = $awayPlayers->firstWhere('position', 'GK') ?? 
                             $awayPlayers->first() ?? 
                             Player::factory()->create(['team_id' => $fixture->away_team_id, 'position' => 'GK']);
            
            // Get remaining players for starting lineup (10 outfield players)
            $awayOutfieldPlayers = $awayPlayers->filter(fn($p) => $p->id !== $awayGoalkeeper->id)->take(10);
            
            // Get bench players (remaining players)
            $awayBenchPlayers = $awayPlayers->filter(fn($p) => 
                $p->id !== $awayGoalkeeper->id && 
                !$awayOutfieldPlayers->contains('id', $p->id)
            )->take(7);

            // Create starting players for home team (1 GK + 10 outfield)
            LineupPlayer::create([
                'lineup_id' => $homeLineup->id,
                'player_id' => $homeGoalkeeper->id,
                'role' => 'starting',
            ]);
            
            foreach ($homeOutfieldPlayers as $player) {
                LineupPlayer::create([
                    'lineup_id' => $homeLineup->id,
                    'player_id' => $player->id,
                    'role' => 'starting',
                ]);
            }

            // Create bench players for home team
            foreach ($homeBenchPlayers as $player) {
                LineupPlayer::create([
                    'lineup_id' => $homeLineup->id,
                    'player_id' => $player->id,
                    'role' => 'bench',
                ]);
            }

            // Create starting players for away team (1 GK + 10 outfield)
            LineupPlayer::create([
                'lineup_id' => $awayLineup->id,
                'player_id' => $awayGoalkeeper->id,
                'role' => 'starting',
            ]);
            
            foreach ($awayOutfieldPlayers as $player) {
                LineupPlayer::create([
                    'lineup_id' => $awayLineup->id,
                    'player_id' => $player->id,
                    'role' => 'starting',
                ]);
            }

            // Create bench players for away team
            foreach ($awayBenchPlayers as $player) {
                LineupPlayer::create([
                    'lineup_id' => $awayLineup->id,
                    'player_id' => $player->id,
                    'role' => 'bench',
                ]);
            }

            // Check if coaches are already assigned to fixture
            if (FixtureCoach::where('fixture_id', $fixture->id)->count() >= 2) {
                continue; // Skip if coaches already assigned
            }

            // Get coaches (create if needed)
            $homeCoach = Coach::first();
            $awayCoach = Coach::skip(1)->first();
            
            if (!$homeCoach) {
                $homeCoach = Coach::factory()->create();
            }
            
            if (!$awayCoach) {
                $awayCoach = Coach::factory()->create();
            }

            FixtureCoach::create([
                'fixture_id' => $fixture->id,
                'coach_id' => $homeCoach->id,
                'team_id' => $fixture->home_team_id,
            ]);

            FixtureCoach::create([
                'fixture_id' => $fixture->id,
                'coach_id' => $awayCoach->id,
                'team_id' => $fixture->away_team_id,
            ]);
        }
    }
}
