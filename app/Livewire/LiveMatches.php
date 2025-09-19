<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class LiveMatches extends Component
{
    protected $listeners = ['echo:match.*,MatchEventCreated' => 'refreshMatches'];

    public function render()
    {
        $liveMatches = Fixture::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'live')
            ->orderBy('kickoff_time')
            ->get();

        return view('livewire.live-matches', compact('liveMatches'));
    }

    public function refreshMatches($eventData)
    {
        // This method will be called when a match event is created
        // The component will automatically re-render with updated data
    }
}
