<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;
use App\Models\Team;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.app')]
class MatchdayLive extends Component
{
    public $fixtures;
    public $liveFixtures;
    public $groupedFixtures;

    public int $pollingInterval = 60;

    public ?int $selectedSeason = null; // e.g., 2025
    public ?int $selectedWeek = null;   // ISO week number as matchday
    public string|int|null $selectedClub = null;   // team id

    public array $seasons = [];
    public array $weeks = [];
    public array $clubs = [];

    protected $listeners = ['echo:match.*,MatchEventCreated' => 'refreshFixtures'];

    public function mount(): void
    {
        $this->bootstrapFilters();
        $this->loadFixtures();
    }

    public function bootstrapFilters(): void
    {
        $years = Fixture::query()
            ->selectRaw('DISTINCT strftime("%Y", kickoff_time) as y')
            ->orderBy('y', 'desc')
            ->pluck('y')
            ->map(fn ($y) => (int) $y)
            ->toArray();
        $this->seasons = $years ?: [now()->year];
        $this->selectedSeason = $this->selectedSeason ?? ($this->seasons[0] ?? now()->year);

        $this->selectedWeek = $this->selectedWeek ?? (int) now()->isoWeek();
        $this->weeks = range(1, 38); // typical league season

        $this->clubs = Team::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function updatedSelectedSeason(): void
    {
        $this->loadFixtures();
    }

    public function updatedSelectedWeek(): void
    {
        $this->loadFixtures();
    }

    public function updatedSelectedClub(): void
    {
        $this->loadFixtures();
    }

    public function previousWeek(): void
    {
        $this->selectedWeek = max(1, ($this->selectedWeek ?? 1) - 1);
        $this->loadFixtures();
    }

    public function nextWeek(): void
    {
        $this->selectedWeek = min(38, ($this->selectedWeek ?? 1) + 1);
        $this->loadFixtures();
    }

    public function loadFixtures(): void
    {
        $start = Carbon::now()->setISODate($this->selectedSeason ?? now()->year, $this->selectedWeek ?? now()->isoWeek(), 1)->startOfDay();
        $end = (clone $start)->endOfWeek(Carbon::SUNDAY)->endOfDay();

        $query = Fixture::with(['homeTeam', 'awayTeam', 'league'])
            ->whereBetween('kickoff_time', [$start, $end]);

        if ($this->selectedClub) {
            $query->where(function ($q) {
                $q->where('home_team_id', $this->selectedClub)
                  ->orWhere('away_team_id', $this->selectedClub);
            });
        }

        $all = $query->orderBy('kickoff_time')->get();

        $this->liveFixtures = $all->where('status', 'live')->values();
        $this->fixtures = $all->whereIn('status', ['scheduled', 'postponed', 'finished'])->values();
        
        // Build grouped collection once and store it
        $this->groupedFixtures = $this->groupFixtures($all);
    }

    private function groupFixtures($fixtures)
    {
        $grouped = collect();
        
        foreach ($fixtures as $fixture) {
            $day = $fixture->kickoff_time->format('l');
            $time = $fixture->kickoff_time->format('H:i');
            
            if (!$grouped->has($day)) {
                $grouped->put($day, collect());
            }
            
            if (!$grouped[$day]->has($time)) {
                $grouped[$day]->put($time, collect());
            }
            
            $grouped[$day][$time]->push($fixture);
        }
        
        // Sort by day of week
        $sortedDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $sortedGrouped = collect();
        
        foreach ($sortedDays as $day) {
            if ($grouped->has($day)) {
                $sortedGrouped->put($day, $grouped[$day]);
            }
        }
        
        return $sortedGrouped;
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

    public function refreshFixtures($eventData)
    {
        // Reload fixtures when a match event is created
        $this->loadFixtures();
    }

    public function render()
    {
        return view('livewire.matchday-live', [
            'grouped' => $this->groupedFixtures ?? collect(),
        ]);
    }
}