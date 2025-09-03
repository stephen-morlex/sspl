<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching all matches.
     */
    public function test_can_fetch_all_matches(): void
    {
        $response = $this->get('/api/matches');

        $response->assertStatus(200);
    }

    /**
     * Test fetching a specific match.
     */
    public function test_can_fetch_a_specific_match(): void
    {
        // Create a match for testing
        $league = \App\Models\League::factory()->create();
        $homeTeam = \App\Models\Team::factory()->create();
        $awayTeam = \App\Models\Team::factory()->create();
        
        $match = \App\Models\Fixture::factory()->create([
            'league_id' => $league->id,
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
        ]);

        $response = $this->get('/api/matches/' . $match->id);

        $response->assertStatus(200);
    }

    /**
     * Test fetching matches by date.
     */
    public function test_can_fetch_matches_by_date(): void
    {
        $response = $this->get('/api/matches/date/2025-09-03');

        $response->assertStatus(200);
    }

    /**
     * Test fetching live matches.
     */
    public function test_can_fetch_live_matches(): void
    {
        $response = $this->get('/api/matches/live');

        $response->assertStatus(200);
    }
}
