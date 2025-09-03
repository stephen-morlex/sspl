<div>
    <h2 class="text-2xl font-bold mb-4">Upcoming Fixtures</h2>
    
    @if($upcomingFixtures->isEmpty())
        <p class="text-gray-500">No upcoming fixtures scheduled.</p>
    @else
        <div class="space-y-4">
            @foreach($upcomingFixtures as $fixture)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-500">{{ $fixture->league->name }}</span>
                        <span class="text-sm text-gray-500">{{ $fixture->kickoff_time->format('M j, Y g:i A') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center">
                            <span class="font-medium">{{ $fixture->homeTeam->name }}</span>
                        </div>
                        <div class="text-center">
                            <span class="text-lg font-bold">vs</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium">{{ $fixture->awayTeam->name }}</span>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-500 text-center mt-2">
                        {{ $fixture->venue }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
