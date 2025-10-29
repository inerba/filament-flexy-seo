<?php

namespace App\Actions\Cms;

use App\Models;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Sitemap as SitemapTag;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap
{
    public static function execute(): void
    {
        // genera la sitemap delle pagine statiche
        Sitemap::create()
            // homepage
            ->add(Url::create('/')->setPriority(1)->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS))
            ->writeToFile(public_path('static_pages.xml'));

        // genera l'index delle sitemap
        SitemapIndex::create()
            // Pagine statiche, per ora solo home
            ->add('/static_pages.xml')

            // pagine cms
            ->add(self::build_index(Models\Cms\Page::sitemapIncluded()->get(), 'sitemap_pages.xml'))

            // articoli cms
            ->add(self::build_index(Models\Cms\Article::published()->sitemapIncluded()->get(), 'sitemap_articles.xml'))

            // eventi
            ->add(self::build_index(Models\Event::published()->get(), 'sitemap_events.xml'))

            // libri
            ->add(self::build_index(Models\Book::all(), 'sitemap_books.xml'))

            // autori
            ->add(self::build_index(Models\BookAuthor::all(), 'sitemap_book_authors.xml'))

            ->writeToFile(public_path('sitemap.xml'));
    }

    protected static function build_index(Model|Collection $model, $filename): SitemapTag|string
    {
        // se è vuoto ritorna null
        if ($model->isEmpty()) {
            return '';
        }

        // genera il file sitemap per il modello passato
        Sitemap::create()->add($model)->writeToFile(public_path($filename));

        // ritorna il tag per l'index
        return SitemapTag::create('/'.$filename)->setLastModificationDate(now());

    }
}
