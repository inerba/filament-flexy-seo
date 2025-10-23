<?php

namespace App\Livewire\Cms;

use App\Models\Cms\Category as CategoryModel;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    public $category;

    private $article_per_page;

    public function mount(CategoryModel $category)
    {
        if (! $category) {
            return abort(404);
        }

        $this->category = $category;

        $this->article_per_page = $category->extras['article_per_page'] ?? 12;

    }

    public function render()
    {
        $articles = $this->category->articles()
            ->where('published_at', '<=', now())
            ->with(['category', 'media', 'user', 'tags'])
            ->orderBy('published_at', 'desc')
            ->simplePaginate($this->article_per_page);

        return view('cms.categories.index', [
            'articles' => $articles,
        ]);
    }
}
