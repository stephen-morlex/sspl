<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Standing;
use App\Models\League;
use App\Models\Team;

class StandingPositionTest extends TestCase
{
    use RefreshDatabase;

    public function test_standings_are_ordered_correctly_by_position()
    {
        // Create a league
        $league = League::factory()->create();
        
        // Create teams
        $team1 = Team::factory()->create(['name' => 'Team A']);
        $team2 = Team::factory()->create(['name' => 'Team B']);
        $team3 = Team::factory()->create(['name' => 'Team C']);
        
        // Create standings with different points
        $standing1 = Standing::create([
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
            'points' => 22, // 7*3 + 1*1
        ]);
        
        $standing2 = Standing::create([
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
            'points' => 21, // 6*3 + 3*1
        ]);
        
        $standing3 = Standing::create([
            'team_id' => $team3->id,
            'league_id' => $league->id,
            'position' => 0,
            'played' => 10,
            'won' => 6,
            'drawn' => 2,
            'lost' => 2,
            'goals_for' => 15,
            'goals_against' => 10,
            'goal_difference' => 5,
            'points' => 20, // 6*3 + 2*1
        ]);
        
        // Refresh the models to ensure they have the latest data
        $standing1->refresh();
        $standing2->refresh();
        $standing3->refresh();
        
        // Test that positions are calculated correctly
        $this->assertEquals(1, $standing1->position); // Team A should be 1st (more points)
        $this->assertEquals(2, $standing2->position); // Team B should be 2nd (less points)
        $this->assertEquals(3, $standing3->position); // Team C should be 3rd (least points)
    }
    
    public function test_standings_with_same_points_ordered_by_goal_difference()
    {
        // Create a league
        $league = League::factory()->create();
        
        // Create teams
        $team1 = Team::factory()->create(['name' => 'Team A']);
        $team2 = Team::factory()->create(['name' => 'Team B']);
        $team3 = Team::factory()->create(['name' => 'Team C']);
        
        // Create standings with same points but different goal differences
        $standing1 = Standing::create([
            'team_id' => $team1->id,
            'league_id' => $league->id,
            'position' => 0,
            'played' => 10,
            'won' => 6,
            'drawn' => 3,
            'lost' => 1,
            'goals_for' => 20,
            'goals_against' => 10,
            'goal_difference' => 10,
            'points' => 21, // 6*3 + 3*1
        ]);
        
        $standing2 = Standing::create([
            'team_id' => $team2->id,
            'league_id' => $league->id,
            'position' => 0,
            'played' => 10,
            'won' => 6,
            'drawn' => 3,
            'lost' => 1,
            'goals_for' => 18,
            'goals_against' => 12,
            'goal_difference' => 6,
            'points' => 21, // 6*3 + 3*1
        ]);
        
        $standing3 = Standing::create([
            'team_id' => $team3->id,
            'league_id' => $league->id,
            'position' => 0,
            'played' => 10,
            'won' => 6,
            'drawn' => 3,
            'lost' => 1,
            'goals_for' => 15,
            'goals_against' => 15,
            'goal_difference' => 0,
            'points' => 21, // 6*3 + 3*1
        ]);
        
        // Refresh the models to ensure they have the latest data
        $standing1->refresh();
        $standing2->refresh();
        $standing3->refresh();
        
        // Test that positions are calculated correctly based on goal difference
        $this->assertEquals(1, $standing1->position); // Team A should be 1st (best goal difference)
        $this->assertEquals(2, $standing2->position); // Team B should be 2nd (medium goal difference)
        $this->assertEquals(3, $standing3->position); // Team C should be 3rd (worst goal difference)
    }
}