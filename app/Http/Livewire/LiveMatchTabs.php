<?php

namespace App\Http\Livewire;

use App\Models\Fixture;
use Livewire\Component;

class LiveMatchTabs extends Component
{
    public Fixture $match;
    public string $activeTab = 'timeline';

    protected $listeners = ['echo:match.{match.id},match.event.created' => 'eventCreated'];

    public function mount(Fixture $match)
    {
        $this->match = $match;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function eventCreated($eventData)
    {
        // This method will be called when a match event is created
        // The component will automatically re-render with updated data
    }

    public function render()
    {
        return view('livewire.live-match-tabs');
    }
}