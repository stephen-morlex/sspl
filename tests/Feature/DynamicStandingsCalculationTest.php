<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Standing;
use App\Models\League;
use App\Models\Team;
use App\Models\Fixture;

class DynamicStandingsCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_standings_are_calculated_from_fixtures()
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
        
        // Initially, both teams should have zero stats
        $this->assertEquals(0, $standing1->played);
        $this->assertEquals(0, $standing1->won);
        $this->assertEquals(0, $standing1->drawn);
        $this->assertEquals(0, $standing1->lost);
        $this->assertEquals(0, $standing1->goals_for);
        $this->assertEquals(0, $standing1->goals_against);
        $this->assertEquals(0, $standing1->goal_difference);
        $this->assertEquals(0, $standing1->points);
        
        // Create some fixtures
        Fixture::create([
            'home_team_id' => $team1->id,
            'away_team_id' => $team2->id,
            'league_id' => $league->id,
            'kickoff_time' => now()->addDay(),
            'venue' => 'Test Stadium',
            'home_score' => 2,
            'away_score' => 1,
            'status' => 'finished',
        ]);
        
        Fixture::create([
            'home_team_id' => $team2->id,
            'away_team_id' => $team1->id,
            'league_id' => $league->id,
            'kickoff_time' => now()->addDays(2),
            'venue' => 'Test Stadium 2',
            'home_score' => 1,
            'away_score' => 1,
            'status' => 'finished',
        ]);
        
        // Refresh the models to ensure they have the latest data
        $standing1->refresh();
        $standing2->refresh();
        
        // Team A should have:
        // - 2 games played (1 win, 1 draw)
        // - 3 goals for (2 + 1)
        // - 2 goals against (1 + 1)
        // - 1 goal difference (3 - 2)
        // - 4 points (3 for win + 1 for draw)
        $this->assertEquals(2, $standing1->played);
        $this->assertEquals(1, $standing1->won);
        $this->assertEquals(1, $standing1->drawn);
        $this->assertEquals(0, $standing1->lost);
        $this->assertEquals(3, $standing1->goals_for);
        $this->assertEquals(2, $standing1->goals_against);
        $this->assertEquals(1, $standing1->goal_difference);
        $this->assertEquals(4, $standing1->points);
        
        // Team B should have:
        // - 2 games played (0 wins, 1 draw, 1 loss)
        // - 2 goals for (1 + 1)
        // - 3 goals against (2 + 1)
        // - -1 goal difference (2 - 3)
        // - 1 point (1 for draw)
        $this->assertEquals(2, $standing2->played);
        $this->assertEquals(0, $standing2->won);
        $this->assertEquals(1, $standing2->drawn);
        $this->assertEquals(1, $standing2->lost);
        $this->assertEquals(2, $standing2->goals_for);
        $this->assertEquals(3, $standing2->goals_against);
        $this->assertEquals(-1, $standing2->goal_difference);
        $this->assertEquals(1, $standing2->points);
        
        // Team A should be in 1st position, Team B in 2nd
        $this->assertEquals(1, $standing1->position);
        $this->assertEquals(2, $standing2->position);
    }
}