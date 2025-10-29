<?php

namespace App\Actions\Cms;

use App\Models;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap
{
    public static function execute(): void
    {
        Sitemap::create()
            // homepage
            ->add(Url::create('/')->setPriority(1)->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS))

            // pagine cms
            ->add(self::build_index(Models\Cms\Page::all(), 'sitemap_pages.xml'))

            // articoli cms
            ->add(self::build_index(Models\Cms\Article::published()->get(), 'sitemap_articles.xml'))

            // eventi
            ->add(self::build_index(Models\Event::published()->get(), 'sitemap_events.xml'))

            // libri
            ->add(self::build_index(Models\Book::all(), 'sitemap_books.xml'))

            // autori
            ->add(self::build_index(Models\BookAuthor::all(), 'sitemap_book_authors.xml'))

            ->writeToFile(public_path('sitemap.xml'));
    }

    protected static function build_index(Model|Collection $model, $filename): Url
    {
        // genera il file sitemap per il modello passato
        Sitemap::create()->add($model)->writeToFile(public_path($filename));

        // ritorna il tag per l'index
        return Url::create('/'.$filename)
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
            ->setPriority(0.5);
    }
}
