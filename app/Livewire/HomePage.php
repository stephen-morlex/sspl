<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;
use App\Models\Standing;
use App\Models\League;
use App\Models\News; // Add this at the top with other imports
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class HomePage extends Component
{
    public $upcomingFixtures;
    public $liveFixtures;
    public $topStandings;
    public $featureNews; // Add this property

    protected $listeners = ['echo:match.*,MatchEventCreated' => 'refreshFixtures'];

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
            ->limit(8)
            ->get();

        // Load live fixtures
        $this->liveFixtures = Fixture::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'live')
            ->orderBy('kickoff_time')
            ->limit(4)
            ->get();

        // Load top standings with efficient statistics calculation
        $this->topStandings = $this->getTopStandings();

        // Load feature news (latest 5)
        $this->featureNews = News::latest()->take(5)->get();
    }

    private function getTopStandings()
    {
        // Get the Premier League
        $premierLeague = League::where('name', 'South Sudan Premier League')->first();

        if (!$premierLeague) {
            return collect();
        }

        // Get standings for Premier League
        $standings = Standing::with(['team', 'league'])
            ->where('league_id', $premierLeague->id)
            ->get();

        if ($standings->isEmpty()) {
            return collect();
        }

        // Calculate team statistics efficiently using database queries
        $teamStats = $this->calculateTeamStatistics($premierLeague->id);

        // Add calculated statistics to standings
        $standingsWithStats = $standings->map(function ($standing) use ($teamStats) {
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

            return $standing;
        })
        ->sortByDesc(function ($s) {
            return [$s->points, $s->goal_difference, $s->goals_for];
        })
        ->take(5)
        ->values();

        return $standingsWithStats;
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

    public function placeholder()
    {
        return <<<'HTML'
        <div class="max-w-[1000px] mx-auto px-4 py-6">
            <div class="w-1/3 h-8 mb-6 rounded bg-base-300 animate-pulse"></div>
            <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
                <div class="h-10 rounded bg-base-300 animate-pulse"></div>
                <div class="h-10 rounded bg-base-300 animate-pulse"></div>
            </div>
            <div class="overflow-x-auto">
                <div class="min-h-[400px] bg-base-200 rounded-lg animate-pulse"></div>
            </div>
        </div>
        HTML;
    }

    public function refreshFixtures($eventData)
    {
        // Reload data when a match event is created
        $this->loadData();
    }

    public function render(): View
    {
        return view('livewire.home-page', [
            'featureNews' => $this->featureNews, // Pass to view
        ]);
    }
}
