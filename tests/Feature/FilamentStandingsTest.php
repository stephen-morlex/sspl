<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Standing;
use App\Models\League;
use App\Models\Team;

class FilamentStandingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_standings_are_displayed_in_admin_panel()
    {
        // Create a league
        $league = League::factory()->create();
        
        // Create teams
        $team1 = Team::factory()->create(['name' => 'Team A']);
        $team2 = Team::factory()->create(['name' => 'Team B']);
        
        // Create standings
        Standing::create([
            'team_id' => $team1->id,
            'league_id' => $league->id,
            'position' => 0,
            'played' => 10,
            'won' => 7,
            'drawn' => 1,
            'lost' => 2,
            'goals_for' => 20,
            'goals_against' => 10,
            'goal_difference' => 10,
            'points' => 22,
        ]);
        
        Standing::create([
            'team_id' => $team2->id,
            'league_id' => $league->id,
            'position' => 0,
            'played' => 10,
            'won' => 6,
            'drawn' => 3,
            'lost' => 1,
            'goals_for' => 18,
            'goals_against' => 8,
            'goal_difference' => 10,
            'points' => 21,
        ]);
        
        // Test that we can retrieve standings
        $standings = Standing::with(['team', 'league'])->get();
        
        $this->assertCount(2, $standings);
        $this->assertEquals('Team A', $standings[0]->team->name);
        $this->assertEquals('Team B', $standings[1]->team->name);
    }
}