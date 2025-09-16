<div>
    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button 
                wire:click="setTab('timeline')" 
                class="{{ $activeTab === 'timeline' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
            >
                Timeline
            </button>
            
            <button 
                wire:click="setTab('lineups')" 
                class="{{ $activeTab === 'lineups' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
            >
                Lineups
            </button>
            
            <button 
                wire:click="setTab('stats')" 
                class="{{ $activeTab === 'stats' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
            >
                Match Stats
            </button>
            
            <button 
                wire:click="setTab('commentary')" 
                class="{{ $activeTab === 'commentary' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
            >
                Commentary
            </button>
        </nav>
    </div>

    <div>
        @if($activeTab === 'timeline')
            @livewire('live-match-timeline', ['match' => $match])
        @elseif($activeTab === 'lineups')
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h3 class="text-lg font-bold mb-4">Lineups</h3>
                <p class="text-gray-500 dark:text-gray-400">Lineup information will be displayed here.</p>
            </div>
        @elseif($activeTab === 'stats')
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h3 class="text-lg font-bold mb-4">Match Statistics</h3>
                <p class="text-gray-500 dark:text-gray-400">Match statistics will be displayed here.</p>
            </div>
        @elseif($activeTab === 'commentary')
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h3 class="text-lg font-bold mb-4">Commentary</h3>
                <p class="text-gray-500 dark:text-gray-400">Match commentary will be displayed here.</p>
            </div>
        @endif
    </div>
</div>