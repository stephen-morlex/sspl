<?php

namespace App\Console\Commands;

use App\Models\Lineup;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Console\Command;

class TestLineup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-lineup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the lineup feature implementation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Lineup Feature Implementation');
        $this->line('');

        // Check counts
        $teamCount = Team::count();
        $playerCount = Player::count();
        $lineupCount = Lineup::count();

        $this->info("Teams: $teamCount");
        $this->info("Players: $playerCount");
        $this->info("Lineups: $lineupCount");

        // Check if we have data
        if ($lineupCount > 0) {
            $lineup = Lineup::first();
            $this->info('');
            $this->info('Sample Lineup:');
            $this->info("Fixture: {$lineup->fixture->homeTeam->name} vs {$lineup->fixture->awayTeam->name}");
            $this->info("Team: {$lineup->team->name}");
            $this->info("Formation: {$lineup->formation}");
            $this->info("Starting Players: {$lineup->startingPlayers()->count()}");
            $this->info("Bench Players: {$lineup->benchPlayers()->count()}");
        } else {
            $this->warn('No lineups found. Please run the LineupSeeder.');
        }

        $this->line('');
        $this->info('Test completed successfully!');
    }
}
