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
}