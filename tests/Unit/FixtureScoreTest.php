<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Fixture;
use App\Models\Team;
use App\Models\League;

class FixtureScoreTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function fixture_scores_default_to_zero()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'status' => 'scheduled'
        ]);

        $this->assertEquals(0, $fixture->home_score);
        $this->assertEquals(0, $fixture->away_score);
    }

    /** @test */
    public function can_increment_home_team_score()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'status' => 'scheduled'
        ]);

        $fixture->incrementHomeScore();
        $this->assertEquals(1, $fixture->home_score);
        $this->assertEquals(0, $fixture->away_score);
    }

    /** @test */
    public function can_increment_away_team_score()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'status' => 'scheduled'
        ]);

        $fixture->incrementAwayScore();
        $this->assertEquals(0, $fixture->home_score);
        $this->assertEquals(1, $fixture->away_score);
    }

    /** @test */
    public function can_decrement_home_team_score()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'home_score' => 2,
            'away_score' => 1,
            'status' => 'scheduled'
        ]);

        $fixture->decrementHomeScore();
        $this->assertEquals(1, $fixture->home_score);
        $this->assertEquals(1, $fixture->away_score);
    }

    /** @test */
    public function cannot_decrement_home_team_score_below_zero()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'home_score' => 0,
            'away_score' => 0,
            'status' => 'scheduled'
        ]);

        $fixture->decrementHomeScore();
        $this->assertEquals(0, $fixture->home_score);
    }

    /** @test */
    public function cannot_decrement_away_team_score_below_zero()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'home_score' => 0,
            'away_score' => 0,
            'status' => 'scheduled'
        ]);

        $fixture->decrementAwayScore();
        $this->assertEquals(0, $fixture->away_score);
    }
}