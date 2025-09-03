<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;

class UpcomingFixtures extends Component
{
    public function render()
    {
        $upcomingFixtures = Fixture::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'scheduled')
            ->where('kickoff_time', '>=', now())
            ->orderBy('kickoff_time')
            ->limit(10)
            ->get();

        return view('livewire.upcoming-fixtures', compact('upcomingFixtures'));
    }
}
