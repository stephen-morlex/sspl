<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
        <div class="flex justify-between items-center mb-4">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $status }} - {{ $currentMinute }}'
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $match->kickoff_time->format('M d, Y H:i') }}
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mr-4">
                    @if($match->homeTeam->logo_path)
                        <img src="{{ $match->homeTeam->logo_path }}" alt="{{ $match->homeTeam->name }}" class="w-12 h-12">
                    @else
                        <span class="text-xl font-bold">{{ substr($match->homeTeam->name, 0, 3) }}</span>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold">{{ $match->homeTeam->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $match->homeTeam->city }}</p>
                </div>
            </div>

            <div class="text-center">
                <div class="text-3xl font-bold">
                    {{ $match->home_score }} - {{ $match->away_score }}
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">FT</div>
            </div>

            <div class="flex items-center">
                <div class="text-right mr-4">
                    <h3 class="text-lg font-bold">{{ $match->awayTeam->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $match->awayTeam->city }}</p>
                </div>
                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                    @if($match->awayTeam->logo_path)
                        <img src="{{ $match->awayTeam->logo_path }}" alt="{{ $match->awayTeam->name }}" class="w-12 h-12">
                    @else
                        <span class="text-xl font-bold">{{ substr($match->awayTeam->name, 0, 3) }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>