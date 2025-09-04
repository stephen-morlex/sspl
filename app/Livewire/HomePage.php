<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;
use App\Models\Standing;
use Illuminate\View\View;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class HomePage extends Component
{
    public $upcomingFixtures;
    public $liveFixtures;
    public $topStandings;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Load upcoming fixtures
        $this->upcomingFixtures = Fixture::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'scheduled')
            ->orderBy('kickoff_time')
            ->limit(5)
            ->get();

        // Load live fixtures
        $this->liveFixtures = Fixture::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'live')
            ->orderBy('kickoff_time')
            ->limit(3)
            ->get();

        // Load top standings
        $this->topStandings = Standing::with(['team', 'league'])
            ->whereHas('league', function ($query) {
                $query->where('name', 'Premier League');
            })
            ->orderBy('points', 'desc')
            ->orderBy('goal_difference', 'desc')
            ->limit(5)
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

    public function render(): View
    {
        return view('livewire.home-page');
    }
}