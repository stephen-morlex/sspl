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
    public $fixtureId;

    public function mount($id)
    {
        $this->fixtureId = $id;
        $this->fixture = Fixture::with(['homeTeam', 'awayTeam', 'league'])->findOrFail($id);
        $this->loadData();
    }

    protected function getListeners(): array
    {
        return [
            "echo:match.{$this->fixtureId},match.event.created" => 'eventCreated',
            "echo:match.{$this->fixtureId},match.event.deleted" => 'eventDeleted',
        ];
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
    }

    public function eventCreated($eventData)
    {
        // Refresh all data when a new event is created
        $this->fixture->refresh();
        $this->loadData();
        
        // Dispatch browser event to show notification
        $this->dispatch('notify', [
            'message' => 'Match updated with new event!',
            'type' => 'success'
        ]);
    }

    public function eventDeleted($eventData)
    {
        // Refresh all data when an event is deleted
        $this->fixture->refresh();
        $this->loadData();
        
        // Dispatch browser event to show notification
        $this->dispatch('notify', [
            'message' => 'Match event removed!',
            'type' => 'info'
        ]);
    }

    // Add polling to ensure updates are visible
    public function refreshFixture()
    {
        $this->fixture->refresh();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="max-w-4xl mx-auto px-4 py-6">
            <div class="h-8 bg-base-300 rounded w-1/3 mb-6 animate-pulse"></div>
            <div class="h-64 bg-base-200 rounded-lg animate-pulse"></div>
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.fixture-show');
    }
}
