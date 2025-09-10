<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\News;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class NewsIndex extends Component
{
    use WithPagination;

    public $selectedCategory = null;
    public $search = '';

    public function mount()
    {
        $this->selectedCategory = request()->query('category');
    }

    public function render()
    {
        $query = News::with(['category', 'tags'])
            ->where('is_published', true)
            ->orderBy('published_at', 'desc');

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        $news = $query->paginate(9);
        $categories = Category::orderBy('name')->get();

        return view('livewire.news-index', [
            'news' => $news,
            'categories' => $categories,
        ]);
    }

    public function updatedSelectedCategory($value)
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->selectedCategory = null;
        $this->search = '';
        $this->resetPage();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="max-w-[1200px] mx-auto px-4 py-6">
            <div class="h-8 bg-base-300 rounded w-1/4 mb-6 animate-pulse"></div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="h-64 bg-base-300 rounded-lg animate-pulse"></div>
                <div class="h-64 bg-base-300 rounded-lg animate-pulse"></div>
                <div class="h-64 bg-base-300 rounded-lg animate-pulse"></div>
                <div class="h-64 bg-base-300 rounded-lg animate-pulse"></div>
                <div class="h-64 bg-base-300 rounded-lg animate-pulse"></div>
                <div class="h-64 bg-base-300 rounded-lg animate-pulse"></div>
            </div>
        </div>
        HTML;
    }
}