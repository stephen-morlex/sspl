<div>
    <div class="max-w-4xl mx-auto px-4 py-8">
        @livewire('live-match-header', ['match' => $match])
        @livewire('live-match-tabs', ['match' => $match])
    </div>
    
    @push('scripts')
    <script>
        // Echo setup for real-time updates
        // This would typically be in your main layout
        /*
        Echo.channel('match.{{ $match->id }}')
            .listen('MatchEventCreated', (e) => {
                // Handle real-time event updates
                console.log('New event:', e);
                // Trigger Livewire component refresh
                Livewire.dispatch('eventCreated', { eventId: e.event.id });
            });
        */
    </script>
    @endpush
</div>