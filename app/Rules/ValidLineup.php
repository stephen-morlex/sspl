<?php

namespace App\Rules;

use App\Models\Lineup;
use App\Models\Player;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidLineup implements ValidationRule
{
    protected string $teamId;

    protected ?Lineup $existingLineup;

    public function __construct(string $teamId, ?Lineup $existingLineup = null)
    {
        $this->teamId = $teamId;
        $this->existingLineup = $existingLineup;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if we have both starting and bench players
        $startingPlayers = $value['startingPlayers'] ?? [];
        $benchPlayers = $value['benchPlayers'] ?? [];

        // Validate maximum 11 starting players
        if (count($startingPlayers) > 11) {
            $fail('A lineup cannot have more than 11 starting players.');

            return;
        }

        // Validate minimum 11 starting players
        if (count($startingPlayers) < 11) {
            $fail('A lineup must have exactly 11 starting players.');

            return;
        }

        // Collect all player IDs
        $allPlayerIds = [];
        foreach ($startingPlayers as $player) {
            if (isset($player['player_id'])) {
                $allPlayerIds[] = $player['player_id'];
            }
        }
        foreach ($benchPlayers as $player) {
            if (isset($player['player_id'])) {
                $allPlayerIds[] = $player['player_id'];
            }
        }

        // Check for duplicate players
        if (count($allPlayerIds) !== count(array_unique($allPlayerIds))) {
            $fail('A player cannot be selected more than once in the lineup.');

            return;
        }

        // Validate that all players belong to the selected team
        if (! empty($allPlayerIds)) {
            $players = Player::whereIn('id', $allPlayerIds)->get();
            foreach ($players as $player) {
                if ($player->team_id !== $this->teamId) {
                    $fail('All players must belong to the selected team.');

                    return;
                }
            }
        }

        // Validate that injured/suspended players are not starters (unless overridden)
        $startingPlayerIds = array_column($startingPlayers, 'player_id');
        if (! empty($startingPlayerIds)) {
            $startingPlayers = Player::whereIn('id', $startingPlayerIds)->get();
            foreach ($startingPlayers as $player) {
                if (($player->is_injured || $player->is_suspended) && ! $this->isOverridden($player->id, $value)) {
                    $fail("Player {$player->first_name} {$player->last_name} is injured or suspended and cannot be a starter.");

                    return;
                }
            }
        }
    }

    /**
     * Check if a player's inclusion is overridden.
     */
    protected function isOverridden(string $playerId, array $data): bool
    {
        // This would be where you check for override confirmation
        // For now, we'll just return false
        return false;
    }
}
