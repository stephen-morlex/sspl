<?php

namespace App\Services;

use App\Models\Lineup;
use InvalidArgumentException;

class LineupService
{
    /**
     * Make a substitution between a starting player and a bench player.
     *
     * @throws InvalidArgumentException
     */
    public function makeSubstitution(Lineup $lineup, string $startingPlayerId, string $benchPlayerId, int $minute): bool
    {
        // Validate the players belong to the same lineup
        $startingLineupPlayer = $lineup->lineupPlayers()
            ->where('player_id', $startingPlayerId)
            ->where('role', 'starting')
            ->first();

        $benchLineupPlayer = $lineup->lineupPlayers()
            ->where('player_id', $benchPlayerId)
            ->where('role', 'bench')
            ->first();

        if (! $startingLineupPlayer) {
            throw new InvalidArgumentException('Starting player not found in lineup or not a starter');
        }

        if (! $benchLineupPlayer) {
            throw new InvalidArgumentException('Bench player not found in lineup or not on the bench');
        }

        // Check if the starting player has already been substituted
        if ($startingLineupPlayer->substituted_out_minute !== null) {
            throw new InvalidArgumentException('Starting player has already been substituted');
        }

        // Check if the bench player has already entered the pitch
        if ($benchLineupPlayer->entered_at_minute !== null) {
            throw new InvalidArgumentException('Bench player has already entered the pitch');
        }

        // Update the starting player
        $startingLineupPlayer->substituted_out_minute = $minute;
        $startingLineupPlayer->save();

        // Update the bench player
        $benchLineupPlayer->entered_at_minute = $minute;
        $benchLineupPlayer->role = 'starting';
        $benchLineupPlayer->save();

        return true;
    }

    /**
     * Get the current starting players (including those who have been substituted in).
     */
    public function getCurrentStartingPlayers(Lineup $lineup, ?int $minute = null): array
    {
        $startingPlayers = $lineup->lineupPlayers()
            ->where('role', 'starting')
            ->with('player')
            ->get();

        // If we have a specific minute, filter out players who were substituted out before this minute
        if ($minute !== null) {
            $startingPlayers = $startingPlayers->filter(function ($lineupPlayer) use ($minute) {
                return $lineupPlayer->substituted_out_minute === null ||
                       $lineupPlayer->substituted_out_minute > $minute;
            });
        } else {
            // Otherwise, filter out players who have been substituted out
            $startingPlayers = $startingPlayers->filter(function ($lineupPlayer) {
                return $lineupPlayer->substituted_out_minute === null;
            });
        }

        return $startingPlayers->toArray();
    }

    /**
     * Get the current bench players (excluding those who have been substituted in).
     */
    public function getCurrentBenchPlayers(Lineup $lineup, ?int $minute = null): array
    {
        $benchPlayers = $lineup->lineupPlayers()
            ->where('role', 'bench')
            ->with('player')
            ->get();

        // If we have a specific minute, filter out players who entered before this minute
        if ($minute !== null) {
            $benchPlayers = $benchPlayers->filter(function ($lineupPlayer) use ($minute) {
                return $lineupPlayer->entered_at_minute === null ||
                       $lineupPlayer->entered_at_minute > $minute;
            });
        } else {
            // Otherwise, filter out players who have entered the pitch
            $benchPlayers = $benchPlayers->filter(function ($lineupPlayer) {
                return $lineupPlayer->entered_at_minute === null;
            });
        }

        return $benchPlayers->toArray();
    }
}
