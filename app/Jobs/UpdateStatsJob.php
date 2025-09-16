<?php

namespace App\Jobs;

use App\Models\MatchEvent;
use App\Models\PlayerMatchStat;
use App\Models\PlayerStat;
use App\Models\TeamMatchStat;
use App\Models\TeamStat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public MatchEvent $event;

    /**
     * Create a new job instance.
     */
    public function __construct(MatchEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check if the event has already been processed
        if ($this->event->processed_at) {
            // Already processed, exit early
            return;
        }

        // Process the event in a database transaction
        DB::transaction(function () {
            // Mark the event as processed
            $this->event->update(['processed_at' => now()]);

            // Update player match stats if player is involved
            if ($this->event->player_id) {
                $this->updatePlayerMatchStats();
            }

            // Update team match stats
            if ($this->event->team_id) {
                $this->updateTeamMatchStats();
            }

            // Update aggregated player stats
            if ($this->event->player_id) {
                $this->updatePlayerStats();
            }

            // Update aggregated team stats
            if ($this->event->team_id) {
                $this->updateTeamStats();
            }
        });
    }

    /**
     * Update player match stats.
     */
    protected function updatePlayerMatchStats(): void
    {
        $playerMatchStat = PlayerMatchStat::firstOrCreate([
            'player_id' => $this->event->player_id,
            'match_id' => $this->event->match_id,
            'team_id' => $this->event->team_id,
        ]);

        // Increment stats based on event type
        switch ($this->event->event_type) {
            case 'goal':
                $playerMatchStat->increment('goals');
                break;
            case 'penalty_goal':
                $playerMatchStat->increment('goals');
                $playerMatchStat->increment('penalty_goals');
                break;
            case 'own_goal':
                $playerMatchStat->increment('own_goals');
                break;
            case 'yellow_card':
                $playerMatchStat->increment('yellow_cards');
                break;
            case 'red_card':
                $playerMatchStat->increment('red_cards');
                break;
            case 'second_yellow':
                $playerMatchStat->increment('yellow_cards');
                $playerMatchStat->increment('red_cards');
                break;
            case 'substitution':
                // This would typically involve tracking substitutions in/out
                // For now, we'll just increment both as placeholders
                $playerMatchStat->increment('substitutions_in');
                $playerMatchStat->increment('substitutions_out');
                break;
            case 'corner':
                $playerMatchStat->increment('corners');
                break;
            case 'offside':
                $playerMatchStat->increment('offsides');
                break;
            case 'foul':
                $playerMatchStat->increment('fouls_committed');
                break;
            case 'penalty_missed':
                $playerMatchStat->increment('penalties_missed');
                break;
        }
    }

    /**
     * Update team match stats.
     */
    protected function updateTeamMatchStats(): void
    {
        $teamMatchStat = TeamMatchStat::firstOrCreate([
            'team_id' => $this->event->team_id,
            'match_id' => $this->event->match_id,
        ]);

        // Increment stats based on event type
        switch ($this->event->event_type) {
            case 'goal':
                $teamMatchStat->increment('goals_for');
                break;
            case 'penalty_goal':
                $teamMatchStat->increment('goals_for');
                $teamMatchStat->increment('penalty_goals');
                break;
            case 'own_goal':
                // For own goals, increment goals_against for the team that scored it
                $teamMatchStat->increment('goals_against');
                break;
            case 'yellow_card':
                $teamMatchStat->increment('yellow_cards');
                break;
            case 'red_card':
                $teamMatchStat->increment('red_cards');
                break;
            case 'second_yellow':
                $teamMatchStat->increment('yellow_cards');
                $teamMatchStat->increment('red_cards');
                break;
            case 'substitution':
                $teamMatchStat->increment('substitutions_in');
                $teamMatchStat->increment('substitutions_out');
                break;
            case 'corner':
                $teamMatchStat->increment('corners');
                break;
            case 'offside':
                $teamMatchStat->increment('offsides');
                break;
            case 'foul':
                $teamMatchStat->increment('fouls_committed');
                break;
            case 'penalty_missed':
                $teamMatchStat->increment('penalties_missed');
                break;
        }

        // Update goals against for the opposing team if it's a goal
        if (in_array($this->event->event_type, ['goal', 'penalty_goal'])) {
            // Find the opposing team
            $match = $this->event->fixture;
            $opposingTeamId = $match->home_team_id == $this->event->team_id ? $match->away_team_id : $match->home_team_id;

            $opposingTeamStat = TeamMatchStat::firstOrCreate([
                'team_id' => $opposingTeamId,
                'match_id' => $this->event->match_id,
            ]);

            $opposingTeamStat->increment('goals_against');
        }
    }

    /**
     * Update aggregated player stats.
     */
    protected function updatePlayerStats(): void
    {
        $playerStat = PlayerStat::firstOrCreate([
            'player_id' => $this->event->player_id,
        ]);

        // Increment stats based on event type
        switch ($this->event->event_type) {
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
        if (in_array($this->event->event_type, [
            'goal', 'penalty_goal', 'own_goal', 'yellow_card', 'red_card', 
            'second_yellow', 'substitution', 'corner', 'offside', 'foul', 
            'penalty_missed'
        ])) {
            $playerStat->increment('matches_played');
        }
    }

    /**
     * Update aggregated team stats.
     */
    protected function updateTeamStats(): void
    {
        $teamStat = TeamStat::firstOrCreate([
            'team_id' => $this->event->team_id,
        ]);

        // Increment stats based on event type
        switch ($this->event->event_type) {
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
        if (in_array($this->event->event_type, ['goal', 'penalty_goal'])) {
            // Find the opposing team
            $match = $this->event->fixture;
            $opposingTeamId = $match->home_team_id == $this->event->team_id ? $match->away_team_id : $match->home_team_id;

            $opposingTeamStat = TeamStat::firstOrCreate([
                'team_id' => $opposingTeamId,
            ]);

            $opposingTeamStat->increment('goals_against');
        }

        // Increment matches played for relevant events
        if (in_array($this->event->event_type, [
            'goal', 'penalty_goal', 'own_goal', 'yellow_card', 'red_card', 
            'second_yellow', 'substitution', 'corner', 'offside', 'foul', 
            'penalty_missed'
        ])) {
            $teamStat->increment('matches_played');
        }
    }
}