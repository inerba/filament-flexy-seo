<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Category;

class CategoryController extends Controller
{
    /**
     * Mostra gli articoli della categoria specificata.
     *
     * @param  Category  $category  La categoria di cui mostrare gli articoli.
     * @return \Illuminate\View\View La vista con gli articoli della categoria.
     */
    public function __invoke(Category $category): \Illuminate\View\View
    {
        $category = Category::find($category->id);

        if (! $category) {
            return abort(404);
        }

        $article_per_page = $category->extras['article_per_page'] ?? 12;

        $articles = $category->articles()
            ->where('published_at', '<=', now())
            ->with(['category', 'media', 'user'])
            ->orderBy('published_at', 'desc')
            ->simplePaginate($article_per_page);

        return view('cms.categories.index', [
            'category' => $category,
            'articles' => $articles,
        ]);
    }
}
