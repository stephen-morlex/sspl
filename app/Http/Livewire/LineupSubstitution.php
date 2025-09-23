<?php

namespace App\Http\Livewire;

use App\Models\Lineup;
use App\Services\LineupService;
use Livewire\Component;

class LineupSubstitution extends Component
{
    public Lineup $lineup;

    public int $minute = 0;

    public string $startingPlayerId = '';

    public string $benchPlayerId = '';

    protected LineupService $lineupService;

    protected $rules = [
        'minute' => 'required|integer|min:0|max:120',
        'startingPlayerId' => 'required',
        'benchPlayerId' => 'required',
    ];

    public function mount(Lineup $lineup)
    {
        $this->lineup = $lineup;
        $this->lineupService = new LineupService;
    }

    public function makeSubstitution()
    {
        $this->validate();

        try {
            $this->lineupService->makeSubstitution(
                $this->lineup,
                $this->startingPlayerId,
                $this->benchPlayerId,
                $this->minute
            );

            $this->reset(['startingPlayerId', 'benchPlayerId']);

            session()->flash('message', 'Substitution made successfully.');

            // Refresh the lineup data
            $this->lineup->refresh();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function getStartingPlayersProperty()
    {
        return $this->lineupService->getCurrentStartingPlayers($this->lineup);
    }

    public function getBenchPlayersProperty()
    {
        return $this->lineupService->getCurrentBenchPlayers($this->lineup);
    }

    public function render()
    {
        return view('livewire.lineup-substitution');
    }
}
