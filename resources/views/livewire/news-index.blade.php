<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-base-content">Latest News</h1>
            <p class="mt-2 text-base-content/70">Stay up to date with the latest football news and updates.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-3">
                <div class="mb-6 flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search news..."
                            class="w-full input input-bordered">
                    </div>
                    <div>
                        <select wire:model.live="selectedCategory" class="w-full select select-bordered">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($selectedCategory || $search)
                        <div>
                            <button wire:click="clearFilters" class="btn btn-outline">
                                Clear
                            </button>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($news as $article)
                        <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow duration-300 border-1">
                            @if ($article->featured_image)
                                <figure>
                                    <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                                        class="w-full h-48 object-cover">
                                </figure>
                            @endif
                            <div class="card-body p-4">
                                <div class="flex items-center text-sm text-base-content/70 mb-2">
                                    <span class="badge badge-ghost">{{ $article->category->name }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $article->published_at->format('M d, Y') }}</span>
                                </div>
                                <h2 class="card-title text-lg">
                                    <a href="{{ route('news.show', $article) }}" class="hover:text-primary">
                                        {{ $article->title }}
                                    </a>
                                </h2>
                                @if ($article->excerpt)
                                    <p class="text-base-content/80">{{ $article->excerpt }}</p>
                                @endif
                                <div class="card-actions justify-start mt-3">
                                    @foreach ($article->tags->take(3) as $tag)
                                        <div class="badge badge-outline badge-sm">{{ $tag->name }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="bg-base-100 rounded-lg shadow-md p-8 text-center">
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
                <div class="bg-base-100 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-base-content mb-4">Categories</h3>
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
