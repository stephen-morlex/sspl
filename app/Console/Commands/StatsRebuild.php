<?php

namespace App\Console\Commands;

use App\Models\MatchEvent;
use App\Models\PlayerMatchStat;
use App\Models\PlayerStat;
use App\Models\TeamMatchStat;
use App\Models\TeamStat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StatsRebuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:rebuild {--season=} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild aggregated player and team stats from match events';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Check if force flag is set or ask for confirmation
        if (!$this->option('force')) {
            if (!$this->confirm('This will truncate all existing aggregated stats. Are you sure you want to continue?')) {
                $this->info('Operation cancelled.');
                return Command::SUCCESS;
            }
        }

        // Check if app is in maintenance mode
        if (!$this->option('force') && !$this->laravel->isDownForMaintenance()) {
            $this->warn('It is recommended to put the application in maintenance mode before running this command.');
            if (!$this->confirm('Do you want to continue without maintenance mode?')) {
                $this->info('Operation cancelled.');
                return Command::SUCCESS;
            }
        }

        try {
            DB::transaction(function () {
                $this->info('Truncating existing stats tables...');
                
                // Truncate aggregated stats tables
                PlayerStat::truncate();
                TeamStat::truncate();
                
                $this->info('Rebuilding player stats...');
                $this->rebuildPlayerStats();
                
                $this->info('Rebuilding team stats...');
                $this->rebuildTeamStats();
                
                $this->info('Stats rebuild completed successfully!');
            });
        } catch (\Exception $e) {
            $this->error('Stats rebuild failed: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * Rebuild player stats from match events.
     */
    protected function rebuildPlayerStats(): void
    {
        // Get all processed match events
        $events = MatchEvent::whereNotNull('processed_at')
            ->get();

        // Group events by player
        $playerEvents = $events->groupBy('player_id')->filter();

        foreach ($playerEvents as $playerId => $events) {
            // Create or get player stat record
            $playerStat = PlayerStat::firstOrCreate(['player_id' => $playerId]);

            // Reset all stats
            $playerStat->update(array_fill_keys(array_keys($playerStat->getAttributes()), 0));
            $playerStat->player_id = $playerId;
            $playerStat->save();

            // Process each event
            foreach ($events as $event) {
                switch ($event->event_type) {
                    case 'goal':
                        $playerStat->increment('goals');
                        break;
                    case 'penalty_goal':
                        $playerStat->increment('goals');
                        $playerStat->increment('penalty_goals');
                        break;
                    case 'own_goal':
                        $playerStat->increment('own_goals');
                        break;
                    case 'yellow_card':
                        $playerStat->increment('yellow_cards');
                        break;
                    case 'red_card':
                        $playerStat->increment('red_cards');
                        break;
                    case 'second_yellow':
                        $playerStat->increment('yellow_cards');
                        $playerStat->increment('red_cards');
                        break;
                    case 'substitution':
                        $playerStat->increment('substitutions_in');
                        $playerStat->increment('substitutions_out');
                        break;
                    case 'corner':
                        $playerStat->increment('corners');
                        break;
                    case 'offside':
                        $playerStat->increment('offsides');
                        break;
                    case 'foul':
                        $playerStat->increment('fouls_committed');
                        break;
                    case 'penalty_missed':
                        $playerStat->increment('penalties_missed');
                        break;
                }

                // Increment matches played for relevant events
                if (in_array($event->event_type, [
                    'goal', 'penalty_goal', 'own_goal', 'yellow_card', 'red_card', 
                    'second_yellow', 'substitution', 'corner', 'offside', 'foul', 
                    'penalty_missed'
                ])) {
                    $playerStat->increment('matches_played');
                }
            }
        }
    }

    /**
     * Rebuild team stats from match events.
     */
    protected function rebuildTeamStats(): void
    {
        // Get all processed match events
        $events = MatchEvent::whereNotNull('processed_at')
            ->get();

        // Group events by team
        $teamEvents = $events->groupBy('team_id')->filter();

        foreach ($teamEvents as $teamId => $events) {
            // Create or get team stat record
            $teamStat = TeamStat::firstOrCreate(['team_id' => $teamId]);

            // Reset all stats
            $teamStat->update(array_fill_keys(array_keys($teamStat->getAttributes()), 0));
            $teamStat->team_id = $teamId;
            $teamStat->save();

            // Process each event
            foreach ($events as $event) {
                switch ($event->event_type) {
                    case 'goal':
                        $teamStat->increment('goals_for');
                        break;
                    case 'penalty_goal':
                        $teamStat->increment('goals_for');
                        $teamStat->increment('penalty_goals');
                        break;
                    case 'own_goal':
                        $teamStat->increment('goals_against');
                        break;
                    case 'yellow_card':
                        $teamStat->increment('yellow_cards');
                        break;
                    case 'red_card':
                        $teamStat->increment('red_cards');
                        break;
                    case 'second_yellow':
                        $teamStat->increment('yellow_cards');
                        $teamStat->increment('red_cards');
                        break;
                    case 'substitution':
                        $teamStat->increment('substitutions_in');
                        $teamStat->increment('substitutions_out');
                        break;
                    case 'corner':
                        $teamStat->increment('corners');
                        break;
                    case 'offside':
                        $teamStat->increment('offsides');
                        break;
                    case 'foul':
                        $teamStat->increment('fouls_committed');
                        break;
                    case 'penalty_missed':
                        $teamStat->increment('penalties_missed');
                        break;
                }

                // Update goals against for the opposing team if it's a goal
                if (in_array($event->event_type, ['goal', 'penalty_goal'])) {
                    // Find the opposing team
                    $match = $event->fixture;
                    $opposingTeamId = $match->home_team_id == $event->team_id ? $match->away_team_id : $match->home_team_id;

                    $opposingTeamStat = TeamStat::firstOrCreate(['team_id' => $opposingTeamId]);
                    $opposingTeamStat->increment('goals_against');
                }

                // Increment matches played for relevant events
                if (in_array($event->event_type, [
                    'goal', 'penalty_goal', 'own_goal', 'yellow_card', 'red_card', 
                    'second_yellow', 'substitution', 'corner', 'offside', 'foul', 
                    'penalty_missed'
                ])) {
                    $teamStat->increment('matches_played');
                }
            }
        }
    }
}