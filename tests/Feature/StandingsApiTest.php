<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Standing;
use App\Models\League;
use App\Models\Team;
use App\Models\Fixture;

class StandingsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_returns_correct_standings_data()
    {
        // Create a league
        $league = League::factory()->create();
        
        // Create teams
        $team1 = Team::factory()->create(['name' => 'Team A']);
        $team2 = Team::factory()->create(['name' => 'Team B']);
        
        // Create standings
        $standing1 = Standing::create([
            'team_id' => $team1->id,
            'league_id' => $league->id,
        ]);
        
        $standing2 = Standing::create([
            'team_id' => $team2->id,
            'league_id' => $league->id,
        ]);
        
        // Create some fixtures
        Fixture::create([
            'home_team_id' => $team1->id,
            'away_team_id' => $team2->id,
            'league_id' => $league->id,
            'kickoff_time' => now()->addDay(),
            'venue' => 'Test Stadium',
            'home_score' => 3,
            'away_score' => 1,
            'status' => 'finished',
        ]);
        
        Fixture::create([
            'home_team_id' => $team2->id,
            'away_team_id' => $team1->id,
            'league_id' => $league->id,
            'kickoff_time' => now()->addDays(2),
            'venue' => 'Test Stadium 2',
            'home_score' => 2,
            'away_score' => 2,
            'status' => 'finished',
        ]);
        
        // Call the API endpoint
        $response = $this->get('/api/standings');
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'team_id',
                'league_id',
                'team',
                'league',
                'played',
                'won',
                'drawn',
                'lost',
                'goals_for',
                'goals_against',
                'goal_difference',
                'points',
                'position',
                'created_at',
                'updated_at',
            ]
        ]);
        
        // Get the JSON response
        $standings = $response->json();
        
        // Find the standings for our teams
        $teamAStanding = collect($standings)->firstWhere('team_id', $team1->id);
        $teamBStanding = collect($standings)->firstWhere('team_id', $team2->id);
        
        // Verify Team A's statistics
        $this->assertEquals(2, $teamAStanding['played']);
        $this->assertEquals(1, $teamAStanding['won']);
        $this->assertEquals(1, $teamAStanding['drawn']);
        $this->assertEquals(0, $teamAStanding['lost']);
        $this->assertEquals(5, $teamAStanding['goals_for']); // 3 + 2
        $this->assertEquals(3, $teamAStanding['goals_against']); // 1 + 2
        $this->assertEquals(2, $teamAStanding['goal_difference']); // 5 - 3
        $this->assertEquals(4, $teamAStanding['points']); // (1 * 3) + (1 * 1)
        $this->assertEquals(1, $teamAStanding['position']); // Should be in 1st place
        
        // Verify Team B's statistics
        $this->assertEquals(2, $teamBStanding['played']);
        $this->assertEquals(0, $teamBStanding['won']);
        $this->assertEquals(1, $teamBStanding['drawn']);
        $this->assertEquals(1, $teamBStanding['lost']);
        $this->assertEquals(3, $teamBStanding['goals_for']); // 1 + 2
        $this->assertEquals(5, $teamBStanding['goals_against']); // 3 + 2
        $this->assertEquals(-2, $teamBStanding['goal_difference']); // 3 - 5
        $this->assertEquals(1, $teamBStanding['points']); // (0 * 3) + (1 * 1)
        $this->assertEquals(2, $teamBStanding['position']); // Should be in 2nd place
    }
}