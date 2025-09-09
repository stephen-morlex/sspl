<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Standing;
use App\Models\League;
use App\Models\Fixture;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class LeagueStandings extends Component
{
    public $leagueId; // for route or external set
    public $leagues;

    public string|int|null $selectedLeague = null;
    public ?int $selectedSeason = null;
    public string $viewMode = 'full';

    public $standings;
    public $previousStandings = [];

    public function mount($leagueId = null)
    {
        $this->leagues = League::orderBy('name')->where('is_active', true)->get();
        $this->selectedLeague = $leagueId ?? $this->leagueId ?? $this->leagues->first()?->id;
        $this->selectedSeason = $this->selectedSeason ?? now()->year;
        $this->loadStandings();
    }

    public function loadStandings(): void
    {
        // Store current standings as previous before updating
        if ($this->standings && $this->standings->count() > 0) {
            $this->previousStandings = $this->standings->keyBy('team_id')->toArray();
        }

        if ($this->selectedLeague) {
            // Use efficient database queries to calculate statistics
            $teamStats = $this->calculateTeamStatistics($this->selectedLeague);
            
            $this->standings = Standing::with(['team', 'league'])
                ->where('league_id', $this->selectedLeague)
                ->get()
                ->each(function ($standing) use ($teamStats) {
                    $teamId = $standing->team_id;
                    $stats = $teamStats->get($teamId, [
                        'played' => 0,
                        'won' => 0,
                        'drawn' => 0,
                        'lost' => 0,
                        'goals_for' => 0,
                        'goals_against' => 0,
                    ]);
                    
                    // Set calculated values
                    $standing->played = $stats['played'];
                    $standing->won = $stats['won'];
                    $standing->drawn = $stats['drawn'];
                    $standing->lost = $stats['lost'];
                    $standing->goals_for = $stats['goals_for'];
                    $standing->goals_against = $stats['goals_against'];
                    $standing->goal_difference = $stats['goals_for'] - $stats['goals_against'];
                    $standing->points = ($stats['won'] * 3) + $stats['drawn'];
                })
                ->sortByDesc(fn ($s) => [$s->points, $s->goal_difference, $s->goals_for])
                ->values()
                ->each(function ($s, $index) { 
                    $s->computed_position = $index + 1;
                    // Set previous position if available
                    if (isset($this->previousStandings[$s->team_id])) {
                        $s->previous_position = $this->previousStandings[$s->team_id]['computed_position'] ?? 
                                              $this->previousStandings[$s->team_id]['position'] ?? 
                                              null;
                    } else {
                        $s->previous_position = null;
                    }
                });
        } else {
            $this->standings = collect();
        }
    }

    private function calculateTeamStatistics($leagueId)
    {
        // Calculate home team statistics
        $homeStats = DB::table('fixtures')
            ->select(
                'home_team_id as team_id',
                DB::raw('COUNT(*) as played'),
                DB::raw('SUM(CASE WHEN home_score > away_score THEN 1 ELSE 0 END) as won'),
                DB::raw('SUM(CASE WHEN home_score = away_score THEN 1 ELSE 0 END) as drawn'),
                DB::raw('SUM(CASE WHEN home_score < away_score THEN 1 ELSE 0 END) as lost'),
                DB::raw('SUM(home_score) as goals_for'),
                DB::raw('SUM(away_score) as goals_against')
            )
            ->where('league_id', $leagueId)
            ->whereIn('status', ['live', 'finished'])
            ->whereNotNull('home_score')
            ->whereNotNull('away_score')
            ->groupBy('home_team_id')
            ->get();

        // Calculate away team statistics
        $awayStats = DB::table('fixtures')
            ->select(
                'away_team_id as team_id',
                DB::raw('COUNT(*) as played'),
                DB::raw('SUM(CASE WHEN away_score > home_score THEN 1 ELSE 0 END) as won'),
                DB::raw('SUM(CASE WHEN away_score = home_score THEN 1 ELSE 0 END) as drawn'),
                DB::raw('SUM(CASE WHEN away_score < home_score THEN 1 ELSE 0 END) as lost'),
                DB::raw('SUM(away_score) as goals_for'),
                DB::raw('SUM(home_score) as goals_against')
            )
            ->where('league_id', $leagueId)
            ->whereIn('status', ['live', 'finished'])
            ->whereNotNull('home_score')
            ->whereNotNull('away_score')
            ->groupBy('away_team_id')
            ->get();

        // Combine home and away statistics
        $combinedStats = collect();
        
        // Process home stats
        foreach ($homeStats as $stat) {
            $combinedStats->put($stat->team_id, [
                'played' => $stat->played,
                'won' => $stat->won,
                'drawn' => $stat->drawn,
                'lost' => $stat->lost,
                'goals_for' => $stat->goals_for,
                'goals_against' => $stat->goals_against,
            ]);
        }
        
        // Process away stats and combine with home stats
        foreach ($awayStats as $stat) {
            if ($combinedStats->has($stat->team_id)) {
                $existing = $combinedStats->get($stat->team_id);
                $combinedStats->put($stat->team_id, [
                    'played' => $existing['played'] + $stat->played,
                    'won' => $existing['won'] + $stat->won,
                    'drawn' => $existing['drawn'] + $stat->drawn,
                    'lost' => $existing['lost'] + $stat->lost,
                    'goals_for' => $existing['goals_for'] + $stat->goals_for,
                    'goals_against' => $existing['goals_against'] + $stat->goals_against,
                ]);
            } else {
                $combinedStats->put($stat->team_id, [
                    'played' => $stat->played,
                    'won' => $stat->won,
                    'drawn' => $stat->drawn,
                    'lost' => $stat->lost,
                    'goals_for' => $stat->goals_for,
                    'goals_against' => $stat->goals_against,
                ]);
            }
        }
        
        return $combinedStats;
    }

    public function updatedSelectedLeague(): void
    {
        $this->loadStandings();
    }

    public function render()
    {
        return view('livewire.league-standings', [
            'standings' => $this->standings ?? collect(),
        ]);
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
}
