<div class="bg-base-200 border-t border-base-200">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="flex items-center gap-3 h-10 overflow-x-auto no-scrollbar text-sm">
            <span class="inline-flex items-center gap-2 shrink-0 text-base-content/70">
                <span class="status status-error"></span>
                <span class="text-base-content">Latest</span>
            </span>
            <ul class="flex items-center gap-6 min-w-max">
                @if($latestNews->count() > 0)
                    @foreach($latestNews as $news)
                        <li class="whitespace-nowrap">
                            <a href="{{ route('news.show', $news) }}" class="link link-hover text-base-content">
                                {{ Str::limit($news->title, 50) }}
                            </a>
                        </li>
                    @endforeach
                @else
                    <li><a class="link link-hover text-base-content" href="#">No news available at the moment</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>