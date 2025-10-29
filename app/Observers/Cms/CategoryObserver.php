<?php

namespace App\Observers\Cms;

use App\Models\Cms\Category;
use App\Models\Cms\Menuitem;

class CategoryObserver
{
    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        // Cicla tra i menuitems associati a questa pagina e aggiorna gli URL, ma solo se è cambiato lo slug
        if ($category->wasChanged('slug')) {
            Menuitem::where('type', 'article_category')
                ->where('model_id', $category->id)
                ->get()
                ->each(fn (Menuitem $menuitem) => $menuitem->update([
                    'url' => $category->relativePermalink,
                ]));
        }

    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        // Cicla tra i menuitems associati a questa categoria e rimuovili
        Menuitem::where('type', 'article_category')
            ->where('model_id', $category->id)
            ->get()
            ->each(fn (Menuitem $menuitem) => $menuitem->delete());
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        // Cicla tra i menuitems associati a questa categoria e ripristinali
        Menuitem::withTrashed()
            ->where('type', 'article_category')
            ->where('model_id', $category->id)
            ->get()
            ->each(fn (Menuitem $menuitem) => $menuitem->restore());
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        // Cicla tra i menuitems associati a questa categoria e rimuovili definitivamente
        Menuitem::withTrashed()
            ->where('type', 'article_category')
            ->where('model_id', $category->id)
            ->get()
            ->each(fn (Menuitem $menuitem) => $menuitem->delete());
    }
}
