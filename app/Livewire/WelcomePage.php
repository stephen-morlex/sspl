<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class WelcomePage extends Component
{
    public function render(): View
    {
        return view('livewire.welcome-page');
    }
}
