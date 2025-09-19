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
    public bool $isDeletion = false;

    /**
     * Create a new job instance.
     */
    public function __construct(MatchEvent $event, bool $isDeletion = false)
    {
        $this->event = $event;
        $this->isDeletion = $isDeletion;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check if the event has already been processed
        if (!$this->isDeletion && $this->event->processed_at) {
            // Already processed, exit early
            return;
        }

        // Process the event in a database transaction
        DB::transaction(function () {
            // Mark the event as processed (unless it's a deletion)
            if (!$this->isDeletion) {
                $this->event->update(['processed_at' => now()]);
            }

            // Update fixture scores if this is a goal event
            $this->updateFixtureScores();

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

        // Determine increment or decrement based on isDeletion flag
        $multiplier = $this->isDeletion ? -1 : 1;

        // Update stats based on event type
        switch ($this->event->event_type) {
            case 'goal':
                $playerMatchStat->increment('goals', 1 * $multiplier);
                break;
            case 'penalty_goal':
                $playerMatchStat->increment('goals', 1 * $multiplier);
                $playerMatchStat->increment('penalty_goals', 1 * $multiplier);
                break;
            case 'own_goal':
                $playerMatchStat->increment('own_goals', 1 * $multiplier);
                break;
            case 'yellow_card':
                $playerMatchStat->increment('yellow_cards', 1 * $multiplier);
                break;
            case 'red_card':
                $playerMatchStat->increment('red_cards', 1 * $multiplier);
                break;
            case 'second_yellow':
                $playerMatchStat->increment('yellow_cards', 1 * $multiplier);
                $playerMatchStat->increment('red_cards', 1 * $multiplier);
                break;
            case 'substitution':
                // This would typically involve tracking substitutions in/out
                // For now, we'll just increment both as placeholders
                $playerMatchStat->increment('substitutions_in', 1 * $multiplier);
                $playerMatchStat->increment('substitutions_out', 1 * $multiplier);
                break;
            case 'corner':
                $playerMatchStat->increment('corners', 1 * $multiplier);
                break;
            case 'offside':
                $playerMatchStat->increment('offsides', 1 * $multiplier);
                break;
            case 'foul':
                $playerMatchStat->increment('fouls_committed', 1 * $multiplier);
                break;
            case 'penalty_missed':
                $playerMatchStat->increment('penalties_missed', 1 * $multiplier);
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

        // Determine increment or decrement based on isDeletion flag
        $multiplier = $this->isDeletion ? -1 : 1;

        // Update stats based on event type
        switch ($this->event->event_type) {
            case 'goal':
                $teamMatchStat->increment('goals_for', 1 * $multiplier);
                break;
            case 'penalty_goal':
                $teamMatchStat->increment('goals_for', 1 * $multiplier);
                $teamMatchStat->increment('penalty_goals', 1 * $multiplier);
                break;
            case 'own_goal':
                // For own goals, increment goals_against for the team that scored it
                $teamMatchStat->increment('goals_against', 1 * $multiplier);
                break;
            case 'yellow_card':
                $teamMatchStat->increment('yellow_cards', 1 * $multiplier);
                break;
            case 'red_card':
                $teamMatchStat->increment('red_cards', 1 * $multiplier);
                break;
            case 'second_yellow':
                $teamMatchStat->increment('yellow_cards', 1 * $multiplier);
                $teamMatchStat->increment('red_cards', 1 * $multiplier);
                break;
            case 'substitution':
                $teamMatchStat->increment('substitutions_in', 1 * $multiplier);
                $teamMatchStat->increment('substitutions_out', 1 * $multiplier);
                break;
            case 'corner':
                $teamMatchStat->increment('corners', 1 * $multiplier);
                break;
            case 'offside':
                $teamMatchStat->increment('offsides', 1 * $multiplier);
                break;
            case 'foul':
                $teamMatchStat->increment('fouls_committed', 1 * $multiplier);
                break;
            case 'penalty_missed':
                $teamMatchStat->increment('penalties_missed', 1 * $multiplier);
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

            $opposingTeamStat->increment('goals_against', 1 * $multiplier);
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

        // Determine increment or decrement based on isDeletion flag
        $multiplier = $this->isDeletion ? -1 : 1;

        // Update stats based on event type
        switch ($this->event->event_type) {
            case 'goal':
                $playerStat->increment('goals', 1 * $multiplier);
                break;
            case 'penalty_goal':
                $playerStat->increment('goals', 1 * $multiplier);
                $playerStat->increment('penalty_goals', 1 * $multiplier);
                break;
            case 'own_goal':
                $playerStat->increment('own_goals', 1 * $multiplier);
                break;
            case 'yellow_card':
                $playerStat->increment('yellow_cards', 1 * $multiplier);
                break;
            case 'red_card':
                $playerStat->increment('red_cards', 1 * $multiplier);
                break;
            case 'second_yellow':
                $playerStat->increment('yellow_cards', 1 * $multiplier);
                $playerStat->increment('red_cards', 1 * $multiplier);
                break;
            case 'substitution':
                $playerStat->increment('substitutions_in', 1 * $multiplier);
                $playerStat->increment('substitutions_out', 1 * $multiplier);
                break;
            case 'corner':
                $playerStat->increment('corners', 1 * $multiplier);
                break;
            case 'offside':
                $playerStat->increment('offsides', 1 * $multiplier);
                break;
            case 'foul':
                $playerStat->increment('fouls_committed', 1 * $multiplier);
                break;
            case 'penalty_missed':
                $playerStat->increment('penalties_missed', 1 * $multiplier);
                break;
        }

        // Increment matches played for relevant events
        if (in_array($this->event->event_type, [
            'goal', 'penalty_goal', 'own_goal', 'yellow_card', 'red_card', 
            'second_yellow', 'substitution', 'corner', 'offside', 'foul', 
            'penalty_missed'
        ])) {
            if ($this->isDeletion) {
                $playerStat->decrement('matches_played');
            } else {
                $playerStat->increment('matches_played');
            }
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

        // Determine increment or decrement based on isDeletion flag
        $multiplier = $this->isDeletion ? -1 : 1;

        // Update stats based on event type
        switch ($this->event->event_type) {
            case 'goal':
                $teamStat->increment('goals_for', 1 * $multiplier);
                break;
            case 'penalty_goal':
                $teamStat->increment('goals_for', 1 * $multiplier);
                $teamStat->increment('penalty_goals', 1 * $multiplier);
                break;
            case 'own_goal':
                $teamStat->increment('goals_against', 1 * $multiplier);
                break;
            case 'yellow_card':
                $teamStat->increment('yellow_cards', 1 * $multiplier);
                break;
            case 'red_card':
                $teamStat->increment('red_cards', 1 * $multiplier);
                break;
            case 'second_yellow':
                $teamStat->increment('yellow_cards', 1 * $multiplier);
                $teamStat->increment('red_cards', 1 * $multiplier);
                break;
            case 'substitution':
                $teamStat->increment('substitutions_in', 1 * $multiplier);
                $teamStat->increment('substitutions_out', 1 * $multiplier);
                break;
            case 'corner':
                $teamStat->increment('corners', 1 * $multiplier);
                break;
            case 'offside':
                $teamStat->increment('offsides', 1 * $multiplier);
                break;
            case 'foul':
                $teamStat->increment('fouls_committed', 1 * $multiplier);
                break;
            case 'penalty_missed':
                $teamStat->increment('penalties_missed', 1 * $multiplier);
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

            $opposingTeamStat->increment('goals_against', 1 * $multiplier);
        }

        // Increment matches played for relevant events
        if (in_array($this->event->event_type, [
            'goal', 'penalty_goal', 'own_goal', 'yellow_card', 'red_card', 
            'second_yellow', 'substitution', 'corner', 'offside', 'foul', 
            'penalty_missed'
        ])) {
            if ($this->isDeletion) {
                $teamStat->decrement('matches_played');
            } else {
                $teamStat->increment('matches_played');
            }
        }
    }

    /**
     * Update fixture scores when goal events occur.
     */
    protected function updateFixtureScores(): void
    {
        // Only update scores for goal-related events
        if (!in_array($this->event->event_type, ['goal', 'penalty_goal', 'own_goal'])) {
            return;
        }

        // Get the fixture
        $fixture = $this->event->fixture;

        // If the event has updated_score data, use that
        if (!empty($this->event->updated_score)) {
            $fixture->home_score = $this->event->updated_score['home'] ?? $fixture->home_score;
            $fixture->away_score = $this->event->updated_score['away'] ?? $fixture->away_score;
            $fixture->save();
            return;
        }

        // Otherwise, calculate based on the event type
        if ($this->isDeletion) {
            // For deletion, decrement the score
            if ($this->event->event_type === 'own_goal') {
                // For own goals, decrement the score of the opposing team
                if ($this->event->team_id === $fixture->home_team_id) {
                    $fixture->away_score = max(0, $fixture->away_score - 1);
                } else {
                    $fixture->home_score = max(0, $fixture->home_score - 1);
                }
            } else {
                // For regular goals, decrement the score of the team that scored
                if ($this->event->team_id === $fixture->home_team_id) {
                    $fixture->home_score = max(0, $fixture->home_score - 1);
                } else {
                    $fixture->away_score = max(0, $fixture->away_score - 1);
                }
            }
        } else {
            // For creation, increment the score
            if ($this->event->event_type === 'own_goal') {
                // For own goals, increment the score of the opposing team
                if ($this->event->team_id === $fixture->home_team_id) {
                    $fixture->away_score++;
                } else {
                    $fixture->home_score++;
                }
            } else {
                // For regular goals, increment the score of the team that scored
                if ($this->event->team_id === $fixture->home_team_id) {
                    $fixture->home_score++;
                } else {
                    $fixture->away_score++;
                }
            }
        }

        $fixture->save();
    }
}