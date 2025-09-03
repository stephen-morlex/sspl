<div>
    <h2 class="text-2xl font-bold mb-4">Live Matches</h2>
    
    @if($liveMatches->isEmpty())
        <p class="text-gray-500">No matches are currently live.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($liveMatches as $match)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-500">{{ $match->league->name }}</span>
                        <span class="text-sm font-semibold">LIVE</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center">
                            <span class="font-medium">{{ $match->homeTeam->name }}</span>
                        </div>
                        <div class="text-center">
                            <span class="text-xl font-bold">{{ $match->home_score ?? 0 }} - {{ $match->away_score ?? 0 }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium">{{ $match->awayTeam->name }}</span>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-500 text-center mt-2">
                        {{ $match->venue }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
