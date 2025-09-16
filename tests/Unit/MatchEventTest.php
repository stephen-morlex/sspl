<?php

namespace Tests\Unit;

use App\Events\MatchEventCreated;
use App\Jobs\UpdateStatsJob;
use App\Models\MatchEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MatchEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function match_event_can_be_created()
    {
        // Create a match event
        $matchEvent = MatchEvent::factory()->make();
        
        // Save it
        $saved = $matchEvent->save();
        
        // Assert it was saved successfully
        $this->assertTrue($saved);
        $this->assertDatabaseHas('match_events', [
            'id' => $matchEvent->id,
        ]);
    }

    /** @test */
    public function match_event_broadcasts_when_created()
    {
        // Fake events
        Event::fake();
        
        // Create a match event
        $matchEvent = MatchEvent::factory()->create();
        
        // Assert that the MatchEventCreated event was dispatched
        Event::assertDispatched(MatchEventCreated::class, function ($event) use ($matchEvent) {
            return $event->event->id === $matchEvent->id;
        });
    }

    /** @test */
    public function update_stats_job_can_be_dispatched()
    {
        // Fake queues
        Queue::fake();
        
        // Create a match event
        $matchEvent = MatchEvent::factory()->create();
        
        // Dispatch the job
        UpdateStatsJob::dispatch($matchEvent);
        
        // Assert that the job was dispatched
        Queue::assertPushed(UpdateStatsJob::class, function ($job) use ($matchEvent) {
            return $job->event->id === $matchEvent->id;
        });
    }
}