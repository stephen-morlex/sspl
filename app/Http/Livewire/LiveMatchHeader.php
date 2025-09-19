<?php

namespace App\Http\Livewire;

use App\Models\Fixture;
use App\Models\MatchEvent;
use Livewire\Component;

class LiveMatchHeader extends Component
{
    public Fixture $match;
    public int $currentMinute = 0;
    public string $status = 'Scheduled';

    protected $listeners = ['echo:match.{match.id},match.event.created' => 'eventCreated'];

    public function mount(Fixture $match)
    {
        $this->match = $match;
        $this->updateMatchStatus();
    }

    public function updateMatchStatus()
    {
        // Refresh the match data to get latest scores
        $this->match->refresh();
        
        // Get the latest event to determine current minute and status
        $latestEvent = MatchEvent::where('match_id', $this->match->id)
            ->orderBy('minute', 'desc')
            ->first();

        if ($latestEvent) {
            $this->currentMinute = $latestEvent->minute;
            $this->status = $latestEvent->period;
        }
    }

    public function eventCreated($eventData)
    {
        // Update the match status and scores when a new event is created
        $this->updateMatchStatus();
    }

    public function render()
    {
        return view('livewire.live-match-header');
    }
}