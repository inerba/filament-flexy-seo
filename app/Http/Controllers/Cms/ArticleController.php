<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Article;

class ArticleController extends Controller
{
    /**
     * Mostra l'articolo specificato.
     *
     * @param  Article  $article  L'articolo da visualizzare.
     * @return \Illuminate\View\View La vista dell'articolo.
     */
    public function __invoke(string $category, Article $article): \Illuminate\View\View
    {
        // Verifica se l'articolo è pubblicato
        if ($article->published_at < now() && $article->published_at !== null) {

            // Registra la visita all'articolo https://github.com/awssat/laravel-visits/blob/master/docs/6_retrieve-visits-and-stats.md
            $article->vzt()->increment();

            // // Per debug: mostra il conteggio delle visite di tutti gli articoli
            // dump(visits('App\Models\Cms\Article')->top(10)->toArray());

            // // Per debug: mostra il conteggio delle visite per questo articolo
            // dump($article->vzt()->count());

            return view('cms.articles.page', [
                'article' => $article,
            ]);
        }

        // Se l'articolo non è pubblicato, mostra una pagina di errore 404
        return abort(404);
    }
}
