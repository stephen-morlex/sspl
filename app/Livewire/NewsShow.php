<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\News;
use App\Models\Category;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class NewsShow extends Component
{
    public News $news;

    public function mount($news)
    {
        // If $news is a string (slug), find the news item
        if (is_string($news)) {
            $news = News::where('slug', $news)->firstOrFail();
        }
        
        if (!$news->is_published) {
            abort(404);
        }

        $this->news = $news->load(['category', 'tags']);
    }

    public function filterByCategory($categoryId)
    {
        return redirect()->route('news.index', ['category' => $categoryId]);
    }

    public function render()
    {
        return view('livewire.news-show');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="max-w-[800px] mx-auto px-4 py-6">
            <div class="h-8 bg-base-300 rounded w-3/4 mb-4 animate-pulse"></div>
            <div class="h-4 bg-base-300 rounded w-1/2 mb-6 animate-pulse"></div>
            <div class="h-96 bg-base-300 rounded-lg mb-6 animate-pulse"></div>
            <div class="space-y-4">
                <div class="h-4 bg-base-300 rounded animate-pulse"></div>
                <div class="h-4 bg-base-300 rounded animate-pulse"></div>
                <div class="h-4 bg-base-300 rounded w-5/6 animate-pulse"></div>
            </div>
        </div>
        HTML;
    }
}