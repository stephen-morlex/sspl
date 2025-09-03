<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;

class MatchdayLive extends Component
{
    public $fixtures;
    public $liveFixtures;
    
    // Polling interval in seconds
    public $pollingInterval = 60;
    
    public function mount()
    {
        $this->loadFixtures();
    }
    
    public function loadFixtures()
    {
        // Load live fixtures
        $this->liveFixtures = Fixture::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'live')
            ->orderBy('kickoff_time')
            ->get();
            
        // Load upcoming fixtures
        $this->fixtures = Fixture::with(['homeTeam', 'awayTeam', 'league'])
            ->whereIn('status', ['scheduled', 'postponed'])
            ->orderBy('kickoff_time')
            ->limit(10)
            ->get();
    }
    
    public function placeholder()
    {
        return <<<'HTML'
        <div class="flex justify-center items-center p-6">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
        </div>
        HTML;
    }
    
    public function render()
    {
        return view('livewire.matchday-live');
    }
}
