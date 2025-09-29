<div class="min-h-screen p-4 bg-base-200">
    <h2 class="text-2xl font-bold mb-4 text-base-content">Live Matches</h2>

    @if($liveMatches->isEmpty())
        <div class="alert alert-info">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>No matches are currently live.</span>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($liveMatches as $match)
                <div class="card bg-base-100 shadow">
                    <div class="card-body p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-primary">{{ $match->league->name }}</span>
                            <span class="badge badge-error badge-sm">LIVE</span>
                        </div>

                        <div class="flex justify-between items-center py-2">
                            <div class="flex flex-col items-center w-1/3">
                                <div class="avatar mb-2">
                                    <div class="w-12 rounded-full">
                                        @if($match->homeTeam->logo_path)
                                            <img src="{{ asset('storage/'.$match->homeTeam->logo_path) }}" alt="{{ $match->homeTeam->name }}" />
                                        @else
                                            <div class="bg-base-300 w-full h-full flex items-center justify-center">
                                                <span class="text-xs text-base-content">{{ substr($match->homeTeam->name, 0, 3) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <span class="font-medium text-center text-sm text-base-content">{{ $match->homeTeam->name }}</span>
                            </div>
                            <div class="text-center w-1/3">
                                <span class="text-3xl font-bold text-error">{{ $match->home_score ?? 0 }} - {{ $match->away_score ?? 0 }}</span>
                                <div class="text-xs text-base-content/70 mt-1">LIVE</div>
                            </div>
                            <div class="flex flex-col items-center w-1/3">
                                <div class="avatar mb-2">
                                    <div class="w-12 rounded-full">
                                        @if($match->awayTeam->logo_path)
                                            <img src="{{ asset('storage/'.$match->awayTeam->logo_path) }}" alt="{{ $match->awayTeam->name }}" />
                                        @else
                                            <div class="bg-base-300 w-full h-full flex items-center justify-center">
                                                <span class="text-xs text-base-content">{{ substr($match->awayTeam->name, 0, 3) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <span class="font-medium text-center text-sm text-base-content">{{ $match->awayTeam->name }}</span>
                            </div>
                        </div>

                        <div class="text-sm text-base-content text-center mt-2">
                            {{ $match->venue }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
