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

    public function mount(Fixture $match)
    {
        $this->match = $match;
        $this->updateMatchStatus();
    }

    public function updateMatchStatus()
    {
        // Get the latest event to determine current minute and status
        $latestEvent = MatchEvent::where('match_id', $this->match->id)
            ->orderBy('minute', 'desc')
            ->first();

        if ($latestEvent) {
            $this->currentMinute = $latestEvent->minute;
            $this->status = $latestEvent->period;
        }
    }

    public function render()
    {
        return view('livewire.live-match-header');
    }
}