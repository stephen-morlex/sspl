<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;
use App\Models\Team;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use Illuminate\Support\Collection;

#[Layout('layouts.app')]
class MatchdayLive extends Component
{
    public $fixtures;
    public $liveFixtures;

    public int $pollingInterval = 60;

    public ?int $selectedSeason = null; // e.g., 2025
    public ?int $selectedWeek = null;   // ISO week number as matchday
    public ?int $selectedClub = null;   // team id

    public array $seasons = [];
    public array $weeks = [];
    public array $clubs = [];

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
        // Build grouped collection locally to avoid Livewire serialization of nested Eloquent collections
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

        $grouped = $all->groupBy(fn ($f) => $f->kickoff_time->format('l'))
            ->sortBy(fn ($c, $day) => $c->first()->kickoff_time->dayOfWeek)
            ->map(fn ($dayFixtures) => $dayFixtures->groupBy(fn ($f) => $f->kickoff_time->format('H:i')));

        return view('livewire.matchday-live', [
            'grouped' => $grouped,
        ]);
    }
}