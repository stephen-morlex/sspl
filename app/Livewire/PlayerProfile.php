<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Player;

class PlayerProfile extends Component
{
    public $player;
    public $playerId;
    
    public function mount($playerId = null)
    {
        $this->playerId = $playerId;
        $this->loadPlayer();
    }
    
    public function loadPlayer()
    {
        if ($this->playerId) {
            $this->player = Player::with('team')->find($this->playerId);
        }
    }
    
    public function placeholder()
    {
        return <<<'HTML'
        <div class="flex justify-center items-center p-6">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
        </div>
        HTML;
    }
    
    public function render()
    {
        return view('livewire.player-profile');
    }
}
