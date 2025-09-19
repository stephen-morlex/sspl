<?php

namespace App\Http\Livewire;

use App\Models\Fixture;
use Livewire\Component;

class LiveMatch extends Component
{
    public Fixture $match;

    protected $listeners = ['echo:match.{match.id},match.event.created' => 'eventCreated'];

    public function mount(Fixture $match)
    {
        $this->match = $match;
    }

    public function eventCreated($eventData)
    {
        // Refresh the match data when a new event is created
        $this->match->refresh();
    }

    public function render()
    {
        return view('livewire.live-match');
    }
}