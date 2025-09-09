<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\News;

class NewsTicker extends Component
{
    public $latestNews = [];

    public function mount()
    {
        $this->loadLatestNews();
    }

    public function loadLatestNews()
    {
        $this->latestNews = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.news-ticker');
    }
}