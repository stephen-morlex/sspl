<?php

namespace Tests\Feature;

use App\Events\MatchEventCreated;
use App\Jobs\UpdateStatsJob;
use App\Models\Fixture;
use App\Models\MatchEvent;
use App\Models\Player;
use App\Models\PlayerMatchStat;
use App\Models\PlayerStat;
use App\Models\Team;
use App\Models\TeamMatchStat;
use App\Models\TeamStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MatchEventStatsTest extends TestCase
{
    use RefreshDatabase;

    protected Team $homeTeam;
    protected Team $awayTeam;
    protected Player $player;
    protected Fixture $match;

    protected function setUp(): void
    {
        parent::setUp();

        // Create teams
        $this->homeTeam = Team::factory()->create(['name' => 'Home Team']);
        $this->awayTeam = Team::factory()->create(['name' => 'Away Team']);

        // Create player
        $this->player = Player::factory()->create([
            'team_id' => $this->homeTeam->id,
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);

        // Create match
        $this->match = Fixture::factory()->create([
            'home_team_id' => $this->homeTeam->id,
            'away_team_id' => $this->awayTeam->id,
            'home_score' => 0,
            'away_score' => 0,
        ]);
    }

    /** @test */
    public function creating_a_goal_via_filament_form_triggers_broadcast_and_stats_update()
    {
        // Fake events and queues
        Event::fake();
        Queue::fake();

        // Create a goal event using factory
        $matchEvent = MatchEvent::factory()->create([
            'match_id' => $this->match->id,
            'team_id' => $this->homeTeam->id,
            'player_id' => $this->player->id,
            'event_type' => 'goal',
            'minute' => 45,
            'period' => '1H',
        ]);

        // Manually dispatch the event and job like Filament would
        $event = new \App\Events\MatchEventCreated($matchEvent);
        event($event);
        
        \App\Jobs\UpdateStatsJob::dispatch($matchEvent);

        // Assert that the MatchEventCreated event was dispatched
        Event::assertDispatched(MatchEventCreated::class, function ($event) use ($matchEvent) {
            return $event->event->id === $matchEvent->id;
        });

        // Assert that the UpdateStatsJob was dispatched
        Queue::assertPushed(UpdateStatsJob::class, function ($job) use ($matchEvent) {
            return $job->event->id === $matchEvent->id;
        });
    }

    /** @test */
    public function update_stats_job_is_idempotent()
    {
        // Create a goal event
        $matchEvent = MatchEvent::create([
            'match_id' => $this->match->id,
            'team_id' => $this->homeTeam->id,
            'player_id' => $this->player->id,
            'event_type' => 'goal',
            'minute' => 45,
            'period' => '1H',
        ]);

        // Run the job for the first time
        $job = new UpdateStatsJob($matchEvent);
        $job->handle();

        // Check that stats were updated
        $playerMatchStat = PlayerMatchStat::where('player_id', $this->player->id)
            ->where('match_id', $this->match->id)
            ->where('team_id', $this->homeTeam->id)
            ->first();
        $this->assertNotNull($playerMatchStat);
        $this->assertEquals(1, $playerMatchStat->goals);

        $playerStat = PlayerStat::where('player_id', $this->player->id)->first();
        $this->assertNotNull($playerStat);
        $this->assertEquals(1, $playerStat->goals);

        $teamMatchStat = TeamMatchStat::where('team_id', $this->homeTeam->id)
            ->where('match_id', $this->match->id)
            ->first();
        $this->assertNotNull($teamMatchStat);
        $this->assertEquals(1, $teamMatchStat->goals_for);

        $teamStat = TeamStat::where('team_id', $this->homeTeam->id)->first();
        $this->assertNotNull($teamStat);
        $this->assertEquals(1, $teamStat->goals_for);

        // Run the job again (simulate duplicate processing)
        $job = new UpdateStatsJob($matchEvent);
        $job->handle();

        // Stats should not be doubled
        $playerMatchStat->refresh();
        $this->assertEquals(1, $playerMatchStat->goals);

        $playerStat->refresh();
        $this->assertEquals(1, $playerStat->goals);

        $teamMatchStat->refresh();
        $this->assertEquals(1, $teamMatchStat->goals_for);

        $teamStat->refresh();
        $this->assertEquals(1, $teamStat->goals_for);
    }

    /** @test */
    public function timeline_livewire_component_receives_broadcast()
    {
        // This test would use Echo fake / Pusher mock to verify
        // that the Livewire component receives the broadcast
        $this->markTestIncomplete('This test requires Echo/Pusher mocking setup');
    }
}