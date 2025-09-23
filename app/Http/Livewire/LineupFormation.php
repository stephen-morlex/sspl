<?php

namespace App\Http\Livewire;

use App\Models\Lineup;
use App\Services\LineupService;
use Livewire\Component;

class LineupFormation extends Component
{
    public Lineup $lineup;

    public int $minute = 90; // Default to full time

    protected LineupService $lineupService;

    public function mount(Lineup $lineup)
    {
        $this->lineup = $lineup;
        $this->lineupService = new LineupService;
    }

    public function getStartingPlayersProperty()
    {
        return $this->lineupService->getCurrentStartingPlayers($this->lineup, $this->minute);
    }

    public function getBenchPlayersProperty()
    {
        return $this->lineupService->getCurrentBenchPlayers($this->lineup, $this->minute);
    }

    public function getSubstitutedPlayersProperty()
    {
        return $this->lineup->lineupPlayers()
            ->whereNotNull('substituted_out_minute')
            ->with('player')
            ->get();
    }

    public function render()
    {
        return view('livewire.lineup-formation');
    }
}
