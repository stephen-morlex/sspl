<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;

class LiveMatches extends Component
{
    public function render()
    {
        $liveMatches = Fixture::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'live')
            ->orderBy('kickoff_time')
            ->get();

        return view('livewire.live-matches', compact('liveMatches'));
    }
}
