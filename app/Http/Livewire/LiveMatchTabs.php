<?php

namespace App\Http\Livewire;

use App\Models\Fixture;
use Livewire\Component;

class LiveMatchTabs extends Component
{
    public Fixture $match;
    public string $activeTab = 'timeline';

    public function mount(Fixture $match)
    {
        $this->match = $match;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.live-match-tabs');
    }
}