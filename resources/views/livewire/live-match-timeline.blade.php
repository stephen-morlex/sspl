<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <h3 class="text-lg font-bold mb-4">Match Timeline</h3>
        
        <div class="space-y-4">
            @forelse($events as $event)
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-3">
                        @if($event->event_type === 'goal')
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($event->event_type === 'yellow_card')
                            <div class="w-4 h-6 bg-yellow-500 rounded-sm"></div>
                        @elseif($event->event_type === 'red_card')
                            <div class="w-4 h-6 bg-red-500 rounded-sm"></div>
                        @elseif($event->event_type === 'substitution')
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $event->minute }}' 
                                @if($event->team)
                                    - {{ $event->team->name }}
                                @endif
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $event->period }}
                            </p>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            @if($event->player)
                                {{ $event->player->first_name }} {{ $event->player->last_name }}
                            @endif
                        </p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                            {{ ucfirst(str_replace('_', ' ', $event->event_type)) }}
                            @if($event->details)
                                - {{ json_encode($event->details) }}
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">
                    No events yet. Check back later for updates.
                </p>
            @endforelse
        </div>
    </div>
</div>