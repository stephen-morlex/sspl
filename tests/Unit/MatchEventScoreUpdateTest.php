<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\MatchEvent;
use App\Models\Fixture;
use App\Models\Team;
use App\Models\League;
use App\Models\Player;

class MatchEventScoreUpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function creating_a_goal_event_updates_home_team_score()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        $player = Player::factory()->create(['team_id' => $homeTeam->id]);
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'status' => 'live'
        ]);

        $this->assertEquals(0, $fixture->home_score);
        $this->assertEquals(0, $fixture->away_score);

        MatchEvent::create([
            'match_id' => $fixture->id,
            'team_id' => $homeTeam->id,
            'player_id' => $player->id,
            'event_type' => 'goal',
            'minute' => 45,
            'period' => '1H'
        ]);

        $fixture->refresh();
        $this->assertEquals(1, $fixture->home_score);
        $this->assertEquals(0, $fixture->away_score);
    }

    /** @test */
    public function creating_a_goal_event_updates_away_team_score()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        $player = Player::factory()->create(['team_id' => $awayTeam->id]);
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'status' => 'live'
        ]);

        $this->assertEquals(0, $fixture->home_score);
        $this->assertEquals(0, $fixture->away_score);

        MatchEvent::create([
            'match_id' => $fixture->id,
            'team_id' => $awayTeam->id,
            'player_id' => $player->id,
            'event_type' => 'goal',
            'minute' => 45,
            'period' => '1H'
        ]);

        $fixture->refresh();
        $this->assertEquals(0, $fixture->home_score);
        $this->assertEquals(1, $fixture->away_score);
    }

    /** @test */
    public function creating_a_penalty_goal_event_updates_home_team_score()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        $player = Player::factory()->create(['team_id' => $homeTeam->id]);
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'status' => 'live'
        ]);

        $this->assertEquals(0, $fixture->home_score);
        $this->assertEquals(0, $fixture->away_score);

        MatchEvent::create([
            'match_id' => $fixture->id,
            'team_id' => $homeTeam->id,
            'player_id' => $player->id,
            'event_type' => 'penalty_goal',
            'minute' => 45,
            'period' => '1H'
        ]);

        $fixture->refresh();
        $this->assertEquals(1, $fixture->home_score);
        $this->assertEquals(0, $fixture->away_score);
    }

    /** @test */
    public function creating_an_own_goal_event_updates_opposite_team_score()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        $player = Player::factory()->create(['team_id' => $homeTeam->id]);
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'status' => 'live'
        ]);

        $this->assertEquals(0, $fixture->home_score);
        $this->assertEquals(0, $fixture->away_score);

        MatchEvent::create([
            'match_id' => $fixture->id,
            'team_id' => $homeTeam->id, // Player from home team scores an own goal
            'player_id' => $player->id,
            'event_type' => 'own_goal',
            'minute' => 45,
            'period' => '1H'
        ]);

        $fixture->refresh();
        $this->assertEquals(0, $fixture->home_score); // Home team doesn't get the point
        $this->assertEquals(1, $fixture->away_score); // Away team gets the point
    }

    /** @test */
    public function deleting_a_goal_event_decrements_score()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        $player = Player::factory()->create(['team_id' => $homeTeam->id]);
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'status' => 'live'
        ]);

        $matchEvent = MatchEvent::create([
            'match_id' => $fixture->id,
            'team_id' => $homeTeam->id,
            'player_id' => $player->id,
            'event_type' => 'goal',
            'minute' => 45,
            'period' => '1H'
        ]);

        $fixture->refresh();
        $this->assertEquals(1, $fixture->home_score);

        $matchEvent->delete();
        
        $fixture->refresh();
        $this->assertEquals(0, $fixture->home_score);
    }

    /** @test */
    public function non_goal_events_do_not_affect_scores()
    {
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        $player = Player::factory()->create(['team_id' => $homeTeam->id]);
        
        $fixture = Fixture::create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'kickoff_time' => now(),
            'venue' => 'Test Venue',
            'status' => 'live'
        ]);

        $this->assertEquals(0, $fixture->home_score);
        $this->assertEquals(0, $fixture->away_score);

        MatchEvent::create([
            'match_id' => $fixture->id,
            'team_id' => $homeTeam->id,
            'player_id' => $player->id,
            'event_type' => 'yellow_card',
            'minute' => 45,
            'period' => '1H'
        ]);

        $fixture->refresh();
        $this->assertEquals(0, $fixture->home_score);
        $this->assertEquals(0, $fixture->away_score);
    }
}