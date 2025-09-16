<?php

namespace App\Events;

use App\Models\MatchEvent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchEventCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public MatchEvent $event;

    /**
     * Create a new event instance.
     */
    public function __construct(MatchEvent $event)
    {
        $this->event = $event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('match.' . $this->event->match_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'match.event.created';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->event->id,
            'match_id' => $this->event->match_id,
            'team_id' => $this->event->team_id,
            'player_id' => $this->event->player_id,
            'event_type' => $this->event->event_type,
            'minute' => $this->event->minute,
            'period' => $this->event->period,
            'details' => $this->event->details,
            'updated_score' => $this->event->updated_score,
            'created_at' => $this->event->created_at->toISOString(),
        ];
    }
}