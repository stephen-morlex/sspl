<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Livewire\MatchdayLive;
use App\Models\Fixture;
use App\Models\Team;
use App\Models\League;
use Livewire\Livewire;

class MatchdayLiveTest extends TestCase
{
    /** @test */
    public function it_can_render_the_matchday_live_component()
    {
        Livewire::test(MatchdayLive::class)
            ->assertStatus(200);
    }
    
    /** @test */
    public function it_displays_live_and_upcoming_fixtures()
    {
        // Create test data
        $league = League::factory()->create();
        $homeTeam = Team::factory()->create();
        $awayTeam = Team::factory()->create();
        
        // Create a live fixture
        $liveFixture = Fixture::factory()->create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'status' => 'live',
            'home_score' => 1,
            'away_score' => 0,
        ]);
        
        // Create a scheduled fixture
        $scheduledFixture = Fixture::factory()->create([
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'league_id' => $league->id,
            'status' => 'scheduled',
        ]);
        
        Livewire::test(MatchdayLive::class)
            ->assertSee($liveFixture->homeTeam->name)
            ->assertSee($liveFixture->awayTeam->name)
            ->assertSee($scheduledFixture->homeTeam->name)
            ->assertSee($scheduledFixture->awayTeam->name);
    }
}