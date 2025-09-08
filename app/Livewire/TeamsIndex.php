<?php

namespace App\Livewire;

use App\Models\Team;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class TeamsIndex extends Component
{
    public function render()
    {
        $teams = Team::orderBy('name')
            ->get();

        return view('livewire.teams-index', [
            'teams' => $teams,
        ]);
    }
}