<div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('news.index') }}" class="btn btn-ghost btn-sm">
                ← Back to News
            </a>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <article class="bg-base-100 rounded-lg shadow-md overflow-hidden">
                    @if($news->featured_image)
                        <figure>
                            <img 
                                src="{{ Storage::url($news->featured_image) }}" 
                                alt="{{ $news->title }}"
                                class="w-full h-80 object-cover"
                            >
                        </figure>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            <div class="badge badge-ghost">{{ $news->category->name }}</div>
                            <span class="text-base-content/70">•</span>
                            <span class="text-base-content/70">{{ $news->published_at->format('F d, Y') }}</span>
                        </div>
                        
                        <h1 class="text-3xl font-bold text-base-content mb-6">{{ $news->title }}</h1>
                        
                        <div class="prose prose-base max-w-none mb-6">
                            {!! $news->content !!}
                        </div>
                        
                        @if($news->tags->count() > 0)
                            <div class="flex flex-wrap gap-2 pt-6 border-t border-base-200">
                                @foreach($news->tags as $tag)
                                    <div class="badge badge-outline">{{ $tag->name }}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </article>
            </div>
            
            <div class="lg:col-span-1">
                <!-- Related News Section -->
                <div class="bg-base-100 rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-xl font-bold text-base-content mb-4">Related News</h3>
                    
                    @php
                        $relatedNews = \App\Models\News::where('category_id', $news->category_id)
                            ->where('id', '!=', $news->id)
                            ->where('is_published', true)
                            ->orderBy('published_at', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($relatedNews->count() > 0)
                        <div class="space-y-4">
                            @foreach($relatedNews as $related)
                                <a href="{{ route('news.show', $related) }}" class="block group">
                                    <div class="flex gap-3">
                                        @if($related->featured_image)
                                            <div class="flex-shrink-0">
                                                <img 
                                                    src="{{ Storage::url($related->featured_image) }}" 
                                                    alt="{{ $related->title }}"
                                                    class="w-16 h-16 object-cover rounded"
                                                >
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-medium text-base-content group-hover:text-primary transition-colors">
                                                {{ Str::limit($related->title, 60) }}
                                            </h4>
                                            <p class="text-sm text-base-content/70 mt-1">
                                                {{ $related->published_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-base-content/70">No related news found.</p>
                    @endif
                </div>
                
                <!-- Categories Section -->
                @php
                    $categories = \App\Models\Category::orderBy('name')->get();
                @endphp
                
                <div class="bg-base-100 rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-base-content mb-4">Categories</h3>
                    <div class="space-y-2">
                        @foreach($categories as $category)
                            <a href="#" wire:click.prevent="filterByCategory('{{ $category->id }}')" class="block py-2 px-3 rounded hover:bg-base-200 transition-colors">
                                <div class="flex justify-between items-center">
                                    <span>{{ $category->name }}</span>
                                    <span class="badge badge-sm badge-ghost">
                                        {{ $category->news()->where('is_published', true)->count() }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>