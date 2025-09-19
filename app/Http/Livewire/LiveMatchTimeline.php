<?php

namespace App\Http\Livewire;

use App\Models\Fixture;
use App\Models\MatchEvent;
use Livewire\Component;

class LiveMatchTimeline extends Component
{
    public Fixture $match;
    public $events;

    protected $listeners = ['echo:match.{match.id},match.event.created' => 'eventCreated'];

    public function mount(Fixture $match)
    {
        $this->match = $match;
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $this->events = MatchEvent::where('match_id', $this->match->id)
            ->with(['team', 'player'])
            ->orderBy('minute', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function eventCreated($eventData)
    {
        // Add the new event to the timeline
        $this->loadEvents();
    }

    public function render()
    {
        return view('livewire.live-match-timeline');
    }
}