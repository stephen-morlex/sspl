<div>
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-base-content">Latest News</h1>
            <p class="mt-2 text-base-content/70">Stay up to date with the latest football news and updates.</p>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
            <div class="lg:col-span-3">
                <div class="flex flex-col gap-4 mb-6 sm:flex-row">
                    <div class="flex-1">
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search news..."
                            class="w-full input input-bordered input-neutral">
                    </div>
                    <div>
                        <select wire:model.live="selectedCategory" class="w-full select select-bordered select-neutral">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($selectedCategory || $search)
                        <div>
                            <button wire:click="clearFilters" class="w-full btn btn-neutral">
                                Clear
                            </button>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($news as $article)
                        <div class="transition-shadow duration-300 card bg-base-100 hover:shadow-md ">
                            {{-- @if ($article->featured_image) --}}
                            <figure>
                                <img src="{{ asset('storage/' . $article->featured_image) }}"
                                    alt="{{ $article->title }}" class="object-cover w-full h-48">
                            </figure>
                            {{-- @endif --}}
                            <div class="p-4 card-body">
                                <div class="flex items-center mb-2 text-sm text-base-content/70">
                                    <span class="badge badge-ghost">{{ $article->category->name }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $article->published_at->format('M d, Y') }}</span>
                                </div>
                                <h2 class="text-lg card-title">
                                    <a href="{{ route('news.show', $article) }}" class="hover:text-primary">
                                        {{ $article->title }}
                                    </a>
                                </h2>
                                @if ($article->excerpt)
                                    <p class="text-base-content/80">{{ $article->excerpt }}</p>
                                @endif
                                <div class="justify-start mt-3 card-actions">
                                    @foreach ($article->tags->take(3) as $tag)
                                        <div class="badge badge-outline badge-sm">{{ $tag->name }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="p-8 text-center rounded-lg shadow-md bg-base-100">
                                <p class="text-base-content/70">No news articles found.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $news->links() }}
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="p-6 rounded-lg bg-base-100">
                    <h3 class="mb-4 text-lg font-bold text-base-content">Categories</h3>
                    <ul class="space-y-2">
                        @foreach ($categories as $category)
                            <li>
                                <a href="#" wire:click.prevent="filterByCategory('{{ $category->id }}')"
                                    class="flex justify-between items-center py-2 px-3 rounded hover:bg-base-200 transition-colors @if ($selectedCategory == $category->id) bg-base-200 font-medium @endif">
                                    <span>{{ $category->name }}</span>
                                    <span class="badge badge-sm badge-ghost">
                                        {{ $category->news()->where('is_published', true)->count() }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
