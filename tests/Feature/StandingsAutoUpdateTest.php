<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Standing;
use App\Models\League;
use App\Models\Team;
use App\Models\Fixture;

class StandingsAutoUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_standings_are_updated_when_new_fixture_is_finished()
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
        
        // Initially both teams have 0 points
        $this->assertEquals(0, $standing1->points);
        $this->assertEquals(0, $standing2->points);
        
        // Create and finish a fixture
        $fixture = Fixture::create([
            'home_team_id' => $team1->id,
            'away_team_id' => $team2->id,
            'league_id' => $league->id,
            'kickoff_time' => now()->addDay(),
            'venue' => 'Test Stadium',
            'home_score' => 2,
            'away_score' => 0,
            'status' => 'finished',
        ]);
        
        // Refresh standings
        $standing1->refresh();
        $standing2->refresh();
        
        // Team A should now have 3 points (win), Team B should have 0 points
        $this->assertEquals(3, $standing1->points);
        $this->assertEquals(0, $standing2->points);
        
        // Team A should be in 1st position
        $this->assertEquals(1, $standing1->position);
        $this->assertEquals(2, $standing2->position);
        
        // Change the fixture result
        $fixture->update([
            'home_score' => 1,
            'away_score' => 1,
        ]);
        
        // Refresh standings again
        $standing1->refresh();
        $standing2->refresh();
        
        // Both teams should now have 1 point (draw)
        $this->assertEquals(1, $standing1->points);
        $this->assertEquals(1, $standing2->points);
        
        // Both teams should be tied for position
        // (They might be in either order depending on other factors)
    }
}