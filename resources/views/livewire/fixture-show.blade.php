<div class="max-w-4xl mx-auto px-4 py-6">

    <!-- Notification -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-[-20px]"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-[-20px]"
         @notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
         class="fixed top-4 right-4 z-50">
        <div :class="{
            'bg-green-100 border-green-400 text-green-700': type === 'success',
            'bg-red-100 border-red-400 text-red-700': type === 'error',
            'bg-blue-100 border-blue-400 text-blue-700': type === 'info'
        }" class="px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline" x-text="message"></span>
        </div>
    </div>

    <!-- Match Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $fixture->league->name }}
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $fixture->kickoff_time->format('M d, Y H:i') }}
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mr-4">
                    @if($fixture->homeTeam->logo_path)
                        <img src="{{ asset('storage/'.$fixture->homeTeam->logo_path) }}" alt="{{ $fixture->homeTeam->name }}" class="w-12 h-12">
                    @else
                        <span class="text-xl font-bold">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold">{{ $fixture->homeTeam->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $fixture->homeTeam->city }}</p>
                </div>
            </div>

            <div class="text-center">
                <div class="text-3xl font-bold">
                    {{ $fixture->home_score }} - {{ $fixture->away_score }}
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    @if($fixture->status === 'live')
                        <span class="text-red-500 font-bold">LIVE</span>
                    @else
                        {{ strtoupper($fixture->status->value ?? (string) $fixture->status) }}
                    @endif
                </div>
            </div>

            <div class="flex items-center">
                <div class="text-right mr-4">
                    <h3 class="text-lg font-bold">{{ $fixture->awayTeam->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $fixture->awayTeam->city }}</p>
                </div>
                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                    @if($fixture->awayTeam->logo_path)
                        <img src="{{ asset('storage/'.$fixture->awayTeam->logo_path) }}" alt="{{ $fixture->awayTeam->name }}" class="w-12 h-12">
                    @else
                        <span class="text-xl font-bold">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs tabs-lifted tabs-lg mb-6">
        <label class="tab">
            <input type="radio" name="match_tabs" class="tab-input" checked />
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Timeline
        </label>
        <!-- Timeline/Events -->
        <div class="tab-content bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h3 class="text-xl font-bold mb-4">Match Events</h3>
            
            @if($events['home']->isEmpty() && $events['away']->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    No events recorded yet.
                </div>
            @else
                <div class="grid grid-cols-2 gap-8">
                    <!-- Home Team Events -->
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mr-2">
                                @if($fixture->homeTeam->logo_path)
                                    <img src="{{ asset('storage/'.$fixture->homeTeam->logo_path) }}" alt="{{ $fixture->homeTeam->name }}" class="w-6 h-6">
                                @else
                                    <span class="text-xs font-bold">{{ substr($fixture->homeTeam->name, 0, 3) }}</span>
                                @endif
                            </div>
                            <h4 class="font-bold">{{ $fixture->homeTeam->name }}</h4>
                        </div>
                        
                        @if($events['home']->isEmpty())
                            <div class="text-center py-4 text-gray-500 text-sm">
                                No events
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($events['home'] as $event)
                                    <div class="flex items-start hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded transition-colors duration-150">
                                        <div class="w-8 text-center mr-3">
                                            <div class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ $event->minute }}'</div>
                                        </div>
                                        <div class="flex-1 flex items-start">
                                            @if($event->event_type === 'goal')
                                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'yellow_card')
                                                <div class="w-5 h-5 rounded bg-yellow-500 mr-2 mt-0.5 flex-shrink-0"></div>
                                            @elseif($event->event_type === 'red_card')
                                                <div class="w-5 h-5 rounded bg-red-500 mr-2 mt-0.5 flex-shrink-0"></div>
                                            @elseif($event->event_type === 'second_yellow')
                                                <div class="w-5 h-5 rounded bg-yellow-500 mr-2 mt-0.5 flex-shrink-0"></div>
                                            @elseif($event->event_type === 'penalty_goal')
                                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'own_goal')
                                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'substitution')
                                                <div class="w-5 h-5 rounded-full bg-blue-500 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'corner')
                                                <div class="w-5 h-5 rounded-full bg-purple-500 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'offside')
                                                <div class="w-5 h-5 rounded-full bg-gray-500 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'foul')
                                                <div class="w-5 h-5 rounded-full bg-gray-500 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'penalty_missed')
                                                <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'injury')
                                                <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'VAR_review')
                                                <div class="w-5 h-5 rounded-full bg-blue-500 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-5 h-5 rounded-full bg-gray-300 flex items-center justify-center mr-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="font-medium text-sm">
                                                    @if($event->player)
                                                        {{ $event->player->first_name }} {{ $event->player->last_name }}
                                                    @else
                                                        {{ $event->team->name }}
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-500 capitalize">
                                                    {{ str_replace('_', ' ', $event->event_type) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <!-- Away Team Events -->
                    <div>
                        <div class="flex items-center mb-4 justify-end">
                            <h4 class="font-bold mr-2">{{ $fixture->awayTeam->name }}</h4>
                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                @if($fixture->awayTeam->logo_path)
                                    <img src="{{ asset('storage/'.$fixture->awayTeam->logo_path) }}" alt="{{ $fixture->awayTeam->name }}" class="w-6 h-6">
                                @else
                                    <span class="text-xs font-bold">{{ substr($fixture->awayTeam->name, 0, 3) }}</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($events['away']->isEmpty())
                            <div class="text-center py-4 text-gray-500 text-sm">
                                No events
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($events['away'] as $event)
                                    <div class="flex items-start hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded transition-colors duration-150">
                                        <div class="flex-1 flex items-start justify-end">
                                            <div class="text-right">
                                                <div class="font-medium text-sm">
                                                    @if($event->player)
                                                        {{ $event->player->first_name }} {{ $event->player->last_name }}
                                                    @else
                                                        {{ $event->team->name }}
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-500 capitalize">
                                                    {{ str_replace('_', ' ', $event->event_type) }}
                                                </div>
                                            </div>
                                            
                                            @if($event->event_type === 'goal')
                                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'yellow_card')
                                                <div class="w-5 h-5 rounded bg-yellow-500 ml-2 mt-0.5 flex-shrink-0"></div>
                                            @elseif($event->event_type === 'red_card')
                                                <div class="w-5 h-5 rounded bg-red-500 ml-2 mt-0.5 flex-shrink-0"></div>
                                            @elseif($event->event_type === 'second_yellow')
                                                <div class="w-5 h-5 rounded bg-yellow-500 ml-2 mt-0.5 flex-shrink-0"></div>
                                            @elseif($event->event_type === 'penalty_goal')
                                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'own_goal')
                                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'substitution')
                                                <div class="w-5 h-5 rounded-full bg-blue-500 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'corner')
                                                <div class="w-5 h-5 rounded-full bg-purple-500 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'offside')
                                                <div class="w-5 h-5 rounded-full bg-gray-500 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'foul')
                                                <div class="w-5 h-5 rounded-full bg-gray-500 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'penalty_missed')
                                                <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'injury')
                                                <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                </div>
                                            @elseif($event->event_type === 'VAR_review')
                                                <div class="w-5 h-5 rounded-full bg-blue-500 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-5 h-5 rounded-full bg-gray-300 flex items-center justify-center ml-2 mt-0.5 flex-shrink-0">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="w-8 text-center ml-3">
                                            <div class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ $event->minute }}'</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <label class="tab">
            <input type="radio" name="match_tabs" class="tab-input" />
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Stats
        </label>
        <!-- Team Stats -->
        <div class="tab-content grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Home Team Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-xl font-bold mb-4">{{ $fixture->homeTeam->name }} Stats</h3>

                @if($homeTeamStats)
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->goals_for ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Goals</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->shots ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Shots</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->possession ?? 0 }}%</div>
                            <div class="text-sm text-gray-500">Possession</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->corners ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Corners</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->fouls_committed ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Fouls</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $homeTeamStats->yellow_cards ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Yellow Cards</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500">
                        No stats available yet.
                    </div>
                @endif
            </div>

            <!-- Away Team Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-xl font-bold mb-4">{{ $fixture->awayTeam->name }} Stats</h3>

                @if($awayTeamStats)
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->goals_for ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Goals</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->shots ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Shots</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->possession ?? 0 }}%</div>
                            <div class="text-sm text-gray-500">Possession</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->corners ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Corners</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->fouls_committed ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Fouls</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $awayTeamStats->yellow_cards ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Yellow Cards</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500">
                        No stats available yet.
                    </div>
                @endif
            </div>
        </div>

        <label class="tab">
            <input type="radio" name="match_tabs" class="tab-input" />
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Lineups
        </label>
        <!-- Player Stats -->
        <div class="tab-content bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-xl font-bold mb-4">Player Statistics</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Home Team Players -->
                <div>
                    <h4 class="font-bold mb-3">{{ $fixture->homeTeam->name }}</h4>

                    @if($homePlayerStats->isEmpty())
                        <div class="text-center py-4 text-gray-500">
                            No player stats available yet.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table table-zebra w-full">
                                <thead>
                                    <tr>
                                        <th>Player</th>
                                        <th>G</th>
                                        <th>A</th>
                                        <th>S</th>
                                        <th>YC</th>
                                        <th>RC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($homePlayerStats as $stat)
                                        <tr>
                                            <td>
                                                <div class="flex items-center">
                                                    <div class="avatar placeholder mr-2">
                                                        <div class="bg-neutral-focus text-neutral-content rounded-full w-8">
                                                            <span class="text-xs">{{ substr($stat->player->first_name, 0, 1) }}{{ substr($stat->player->last_name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <span>{{ $stat->player->first_name }} {{ $stat->player->last_name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $stat->goals ?? 0 }}</td>
                                            <td>{{ $stat->assists ?? 0 }}</td>
                                            <td>{{ $stat->shots ?? 0 }}</td>
                                            <td>{{ $stat->yellow_cards ?? 0 }}</td>
                                            <td>{{ $stat->red_cards ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Away Team Players -->
                <div>
                    <h4 class="font-bold mb-3">{{ $fixture->awayTeam->name }}</h4>

                    @if($awayPlayerStats->isEmpty())
                        <div class="text-center py-4 text-gray-500">
                            No player stats available yet.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table table-zebra w-full">
                                <thead>
                                    <tr>
                                        <th>Player</th>
                                        <th>G</th>
                                        <th>A</th>
                                        <th>S</th>
                                        <th>YC</th>
                                        <th>RC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($awayPlayerStats as $stat)
                                        <tr>
                                            <td>
                                                <div class="flex items-center">
                                                    <div class="avatar placeholder mr-2">
                                                        <div class="bg-neutral-focus text-neutral-content rounded-full w-8">
                                                            <span class="text-xs">{{ substr($stat->player->first_name, 0, 1) }}{{ substr($stat->player->last_name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <span>{{ $stat->player->first_name }} {{ $stat->player->last_name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $stat->goals ?? 0 }}</td>
                                            <td>{{ $stat->assists ?? 0 }}</td>
                                            <td>{{ $stat->shots ?? 0 }}</td>
                                            <td>{{ $stat->yellow_cards ?? 0 }}</td>
                                            <td>{{ $stat->red_cards ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
