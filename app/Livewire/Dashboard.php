<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render(): View
    {
        return view('livewire.dashboard');
    }
    
    public function placeholder()
    {
        return <<<'HTML'
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="h-8 bg-gray-300 rounded w-1/4 mb-6 animate-pulse"></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="h-32 bg-gray-300 rounded animate-pulse"></div>
                            <div class="h-32 bg-gray-300 rounded animate-pulse"></div>
                            <div class="h-32 bg-gray-300 rounded animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }
}
