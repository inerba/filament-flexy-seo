<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

$middleware = is_multilingual() ? ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localeCookieRedirect'] : ['web'];
$prefix = is_multilingual() ? LaravelLocalization::setLocale() : '';

// Tutte le rotte localizzate vanno qui
// Aggiungiamo i middleware di redirect/localization per permettere il redirect automatico
Route::group([
    'prefix' => $prefix,
    'middleware' => $middleware,
], function () {

    // Rotte dei libri
    Route::prefix('titolo')->group(function () {
        // Route::get('/', Controllers\BookController::class)->name('books.index');
        Route::get('/{book:slug}', [Controllers\BookController::class, 'show'])->name('books.show');
    });

    // Rotte degli autori
    Route::prefix('autore')->group(function () {
        Route::get('/{bookAuthor:slug}', [Controllers\BookAuthorController::class, 'show'])->name('book-authors.show');
    });

    // Rotte del Cms
    Route::group([
        'middleware' => ['web'],
        'as' => 'cms.',
    ], function () {

        Route::get('/', function () {
            return view('home');
        })->name('home');

        // Rotte degli articoli e delle categorie
        Route::prefix(config('cms.articles_route_prefix', 'news'))->group(function () {
            Route::get('/', Controllers\Cms\ArticleListController::class)->name('articles.list');
            Route::get('/{category:slug}', Controllers\Cms\CategoryController::class)->name('articles.category');
            Route::get('/{category:slug}/{article:slug}', Controllers\Cms\ArticleController::class)->name('articles.page');
        });

        // Rotte delle pagine Cms sempre per ultime
        Route::get('/{slug}', Controllers\Cms\PageController::class)
            ->where('slug', '(.*)')
            ->name('page');
    })->scopeBindings();
});
