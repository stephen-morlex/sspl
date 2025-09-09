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
}