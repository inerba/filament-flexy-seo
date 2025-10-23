<?php

use App\Http\Controllers;
use App\Livewire\Cms;
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

    Route::prefix('dashboard')
        ->middleware(['auth:customer', 'verified'])
        ->group(function () {
            Route::get('/', [Controllers\CustomerController::class, 'index'])->name('customer.dashboard');
        });

    Route::name('shop.')
        ->group(function () {
            Route::get('/carrello', \App\Livewire\Shop\Cart::class)->name('cart');

            Route::middleware(['auth:customer', 'verified'])->group(function () {
                Route::get('/checkout-status', \App\Livewire\Shop\CheckoutStatus::class)->name('checkout-status');
                Route::get('/order/{orderId}', \App\Livewire\Shop\ViewOrder::class)->name('view-order');
            });
        });

    Route::get('/preview', function () {
        $order = \App\Models\Order::latest()->first();

        return (new \App\Mail\OrderConfirmation($order))->render();
    })->name('preview');

    // Rotte dei libri
    Route::prefix('titolo')->group(function () {
        // Route::get('/', Controllers\BookController::class)->name('books.index');
        Route::get('/{book:slug}', [Controllers\BookController::class, 'show'])->name('books.show');
    });

    // Rotte degli autori
    Route::prefix('autore')->group(function () {
        Route::get('/{bookAuthor:slug}', [Controllers\BookAuthorController::class, 'show'])->name('book-authors.show');
    });

    // Rotte degli eventi
    Route::prefix('eventi')->group(function () {
        Route::get('/', [Controllers\EventController::class, 'index'])->name('events.index');
        Route::get('/{event:slug}', [Controllers\EventController::class, 'show'])->name('events.show');
    });

    Route::get('/', function () {
        return view('home');
    })->name('home');

    // Rotte del Cms
    Route::group([
        'middleware' => ['web'],
        'as' => 'cms.',
    ], function () {

        // Rotte degli articoli e delle categorie
        Route::prefix(config('cms.articles_route_prefix', 'news'))->group(function () {
            Route::get('/', Cms\ArticleList::class)->name('articles.list');
            Route::get('/{category:slug}', Cms\Category::class)->name('articles.category');
            Route::get('/{category:slug}/{article:slug}', Cms\Article::class)->name('articles.page');
        });

        // Rotte delle pagine Cms sempre per ultime
        Route::get('/{slug}', Cms\Page::class)->where('slug', '(.*)')->name('page');
    })->scopeBindings();
});
