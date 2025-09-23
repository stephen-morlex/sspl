<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;
use App\Models\MatchEvent;
use App\Models\PlayerMatchStat;
use App\Models\TeamMatchStat;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class FixtureShow extends Component
{
    public Fixture $fixture;
    public $events;
    public $homeTeamStats;
    public $awayTeamStats;
    public $homePlayerStats;
    public $awayPlayerStats;
    public $homeLineup;
    public $awayLineup;
    public $fixtureId;

    public function mount($id)
    {
        $this->fixtureId = $id;
        $this->fixture = Fixture::with(['homeTeam', 'awayTeam', 'league'])->findOrFail($id);
        $this->loadData();
    }

    public function loadData()
    {
        // Load match events
        $allEvents = MatchEvent::where('match_id', $this->fixture->id)
            ->with(['team', 'player'])
            ->orderBy('minute')
            ->orderBy('created_at')
            ->get();

        // Group events by team using a more explicit approach
        $homeEvents = collect();
        $awayEvents = collect();
        $unassignedEvents = collect();

        foreach ($allEvents as $event) {
            if ($event->team_id == $this->fixture->home_team_id) {
                $homeEvents->push($event);
            } elseif ($event->team_id == $this->fixture->away_team_id) {
                $awayEvents->push($event);
            } else {
                $unassignedEvents->push($event);
            }
        }

        // If we have unassigned events, let's add them to the home team for now
        // This might indicate an issue with data, but we want to display all events
        if ($unassignedEvents->count() > 0) {
            foreach ($unassignedEvents as $event) {
                $homeEvents->push($event);
            }
        }

        $this->events = [
            'home' => $homeEvents,
            'away' => $awayEvents,
        ];

        // Load team stats
        $this->homeTeamStats = TeamMatchStat::where('match_id', $this->fixture->id)
            ->where('team_id', $this->fixture->home_team_id)
            ->first();

        $this->awayTeamStats = TeamMatchStat::where('match_id', $this->fixture->id)
            ->where('team_id', $this->fixture->away_team_id)
            ->first();

        // Load player stats
        $this->homePlayerStats = PlayerMatchStat::where('match_id', $this->fixture->id)
            ->where('team_id', $this->fixture->home_team_id)
            ->with('player')
            ->orderBy('goals', 'desc')
            ->orderBy('assists', 'desc')
            ->get();

        $this->awayPlayerStats = PlayerMatchStat::where('match_id', $this->fixture->id)
            ->where('team_id', $this->fixture->away_team_id)
            ->with('player')
            ->orderBy('goals', 'desc')
            ->orderBy('assists', 'desc')
            ->get();

        // Load lineups
        $this->homeLineup = $this->fixture->lineups()
            ->where('team_id', $this->fixture->home_team_id)
            ->with([
                'startingPlayerDetails.player',
                'benchPlayerDetails.player'
            ])
            ->first();

        $this->awayLineup = $this->fixture->lineups()
            ->where('team_id', $this->fixture->away_team_id)
            ->with([
                'startingPlayerDetails.player',
                'benchPlayerDetails.player'
            ])
            ->first();
    }

    // Add polling to ensure updates are visible
    public function refreshFixture()
    {
        $this->fixture->refresh();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="max-w-4xl px-4 py-6 mx-auto">
            <div class="w-1/3 h-8 mb-6 rounded bg-base-300 animate-pulse"></div>
            <div class="h-64 rounded-lg bg-base-200 animate-pulse"></div>
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.fixture-show');
    }
}
