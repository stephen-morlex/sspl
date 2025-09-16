<?php

namespace App\Http\Livewire;

use App\Models\Fixture;
use Livewire\Component;

class LiveMatch extends Component
{
    public Fixture $match;

    public function mount(Fixture $match)
    {
        $this->match = $match;
    }

    public function render()
    {
        return view('livewire.live-match');
    }
}