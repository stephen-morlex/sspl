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
        <div class="max-w-[1000px] mx-auto px-4 py-6">
            <div class="h-8 bg-base-300 rounded w-1/3 mb-6 animate-pulse"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="h-10 bg-base-300 rounded animate-pulse"></div>
                <div class="h-10 bg-base-300 rounded animate-pulse"></div>
            </div>
            <div class="overflow-x-auto">
                <div class="min-h-[400px] bg-base-200 rounded-lg animate-pulse"></div>
            </div>
        </div>
        HTML;
    }

    public function render(): View
    {
        return view('livewire.home-page');
    }
}