<?php

namespace App\Livewire;

use App\Models\Player;
use App\Models\Team;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PlayersIndex extends Component
{
    public $selectedTeam = '';
    public $selectedPosition = '';
    public $selectedNationality = '';
    
    public $players;
    public $teams;
    public $positions;
    public $nationalities;
    
    public function mount()
    {
        $this->loadData();
    }
    
    public function loadData()
    {
        $this->players = Player::where('is_active', true)
            ->with('team')
            ->when($this->selectedTeam, function ($query) {
                return $query->where('team_id', $this->selectedTeam);
            })
            ->when($this->selectedPosition, function ($query) {
                return $query->where('position', $this->selectedPosition);
            })
            ->when($this->selectedNationality, function ($query) {
                return $query->where('nationality', $this->selectedNationality);
            })
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
            
        // Get filter options
        $this->teams = Team::orderBy('name')->get();
        $this->positions = Player::select('position')->where('position', '!=', '')->distinct()->orderBy('position')->get();
        $this->nationalities = Player::select('nationality')->where('nationality', '!=', '')->distinct()->orderBy('nationality')->get();
    }

    public function render()
    {
        return view('livewire.players-index', [
            'players' => $this->players ?? collect(),
            'teams' => $this->teams ?? collect(),
            'positions' => $this->positions ?? collect(),
            'nationalities' => $this->nationalities ?? collect(),
        ]);
    }
    
    public function placeholder()
    {
        return <<<'HTML'
        <div class="max-w-[1000px] mx-auto px-4 py-6">
            <div class="h-8 bg-base-300 rounded w-1/3 mb-6 animate-pulse"></div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="h-10 bg-base-300 rounded animate-pulse"></div>
                <div class="h-10 bg-base-300 rounded animate-pulse"></div>
                <div class="h-10 bg-base-300 rounded animate-pulse"></div>
            </div>
            <div class="overflow-x-auto">
                <div class="min-h-[400px] bg-base-200 rounded-lg animate-pulse">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="card card-bordered bg-base-100 shadow-md animate-pulse">
                                <div class="card-body p-6">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-16 h-16 rounded-full bg-base-300"></div>
                                        <div>
                                            <div class="h-6 bg-base-300 rounded w-32 mb-2"></div>
                                            <div class="h-4 bg-base-300 rounded w-24"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <div class="h-4 bg-base-300 rounded w-full"></div>
                                        <div class="h-4 bg-base-300 rounded w-3/4"></div>
                                        <div class="h-4 bg-base-300 rounded w-2/3"></div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }

    
    public function resetFilters()
    {
        $this->selectedTeam = '';
        $this->selectedPosition = '';
        $this->selectedNationality = '';
        $this->loadData();
    }
    
    public function updatedSelectedTeam()
    {
        $this->loadData();
    }
    
    public function updatedSelectedPosition()
    {
        $this->loadData();
    }
    
    public function updatedSelectedNationality()
    {
        $this->loadData();
    }
}