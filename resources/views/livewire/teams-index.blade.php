<div class="py-6">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-8 font-bold text-left divider"> TEAMS</h1>

        @if (isset($teams) && $teams->isEmpty())
            <div class="shadow-sm card bg-neutral">
                <div class="text-center card-body">
                    <p class="text-base-content/70">No teams found.</p>
                </div>
            </div>
        @elseif(isset($teams))
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($teams as $team)
                    <a href="{{ route('teams.show', $team->id) }}"
                        class="flex transition-all duration-300 transform card card-bordered bg-neutral hover:shadow-sm hover:-translate-y-1">
                        <div class="p-6 card-body">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="avatar">
                                    <div class="w-16 rounded-xl">
                                        <img src="{{ $team->logo_path ? asset('storage/' . $team->logo_path) : 'https://ssfa-services.com/images/teams/salam_fc.png' }}"
                                            alt="{{ $team->name }}" />
                                    </div>
                                </div>
                                <h2 class="text-xl card-title">{{ $team->name }}</h2>
                            </div>

                            <div class="flex items-center justify-between gap-2 text-sm">
                                <div class="flex items-center flex-grow gap-2 badge badge-soft">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-[1em]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $team->stadium ?? 'Stadium not set' }}</span>
                                </div>

                                <div class="flex items-center gap-2 badge badge-soft badge-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-[1em]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Founded: {{ $team->founded_year ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
