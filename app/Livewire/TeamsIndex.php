<?php

namespace App\Livewire;

use App\Models\Team;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class TeamsIndex extends Component
{
    public $teams;

    public function mount()
    {
        $this->loadTeams();
    }

    public function loadTeams()
    {
        $this->teams = Team::orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.teams-index', [
            'teams' => $this->teams ?? collect(),
        ]);
    }
    
    public function placeholder()
    {
        return <<<'HTML'
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="h-8 bg-base-300 rounded w-1/3 mb-8 animate-pulse"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="card card-bordered bg-base-100 shadow-md animate-pulse">
                            <div class="card-body p-6">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-16 h-16 rounded-xl bg-base-300"></div>
                                    <div class="h-6 bg-base-300 rounded w-3/4"></div>
                                </div>
                                
                                <div class="space-y-3">
                                    <div class="h-4 bg-base-300 rounded w-full"></div>
                                    <div class="h-4 bg-base-300 rounded w-2/3"></div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        HTML;
    }
}