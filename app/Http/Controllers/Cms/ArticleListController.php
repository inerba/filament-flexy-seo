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
        $article_per_page = config('cms.articles_blog_settings.articles_per_page', 6);

        $articles = Article::query()
            ->with([
                'category',
                'media',
            ])
            ->published()
            ->orderByDesc('published_at')
            ->simplePaginate($article_per_page);

        return view('cms.articles.index', [
            'articles' => $articles,
        ]);
    }
}
