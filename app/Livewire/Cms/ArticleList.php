<?php

namespace App\Livewire\Cms;

use App\Models\Cms\Article;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleList extends Component
{
    use WithPagination;

    public function render()
    {
        $article_per_page = config('cms.articles_blog_settings.articles_per_page', 6);

        $articles = Article::query()
            ->with([
                'category',
                'media',
            ])
            ->published()
            ->orderByDesc('published_at')
            ->simplePaginate($article_per_page);

        return view('cms.articles.index', compact('articles'));

    }
}
