<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Article;

class ArticleListController extends Controller
{
    /**
     * Mostra la homepage del blog con i post recenti.
     *
     * @return \Illuminate\View\View La vista con i post recenti del blog.
     */
    public function __invoke(): \Illuminate\View\View
    {
        // // Verifica se il blog è abilitato
        // if (! db_config('blogconfig.enabled', true)) {
        //     return abort(404);
        // }

        // Ottieni le impostazioni del blog
        $article_per_page = db_config('blogconfig.articles_per_page', 5);

        $articles = Article::query()
            ->where('published_at', '<=', now())
            ->with([
                'category',
                'media',
            ])
            ->orderByDesc('created_at')
            ->simplePaginate($article_per_page);

        return view('cms.articles.index', [
            'articles' => $articles,
        ]);
    }
}
