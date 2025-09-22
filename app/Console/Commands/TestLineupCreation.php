<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\Lineup;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Console\Command;

class TestLineupCreation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:lineup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test lineup creation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get a fixture
        $fixture = Fixture::first();
        if (!$fixture) {
            $this->error('No fixture found. Please seed the database first.');
            return 1;
        }

        // Get teams for the fixture
        $homeTeam = $fixture->homeTeam;
        $awayTeam = $fixture->awayTeam;

        $this->info("Creating lineups for fixture: {$homeTeam->name} vs {$awayTeam->name}");

        // Get players for each team
        $homePlayers = $homeTeam->players->take(11); // Take first 11 players
        $awayPlayers = $awayTeam->players->take(11); // Take first 11 players

        // Create lineups for home team
        foreach ($homePlayers as $index => $player) {
            Lineup::create([
                'fixture_id' => $fixture->id,
                'team_id' => $homeTeam->id,
                'player_id' => $player->id,
                'position' => $player->position,
                'is_starting' => $index < 11, // First 11 are starters
                'status' => $index < 11 ? 'starting' : 'bench',
            ]);
        }

        // Create lineups for away team
        foreach ($awayPlayers as $index => $player) {
            Lineup::create([
                'fixture_id' => $fixture->id,
                'team_id' => $awayTeam->id,
                'player_id' => $player->id,
                'position' => $player->position,
                'is_starting' => $index < 11, // First 11 are starters
                'status' => $index < 11 ? 'starting' : 'bench',
            ]);
        }

        $this->info('Lineups created successfully!');
        $this->info("Total lineups created: " . Lineup::count());

        return 0;
    }
}