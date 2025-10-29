<?php

namespace App\Observers\Cms;

use App\Models\Cms\Menuitem;
use App\Models\Cms\Page;

class PageObserver
{
    /**
     * Handle the Page "created" event.
     */
    public function created(Page $page): void
    {
        //
    }

    /**
     * Handle the Page "updated" event.
     */
    public function updated(Page $page): void
    {
        // Cicla tra i menuitems associati a questa pagina e aggiorna gli URL
        if ($page->wasChanged('slug')) {
            Menuitem::where('type', 'page')
                ->where('model_id', $page->id)
                ->get()
                ->each(fn (Menuitem $menuitem) => $menuitem->update([
                    'url' => $page->relativePermalink,
                ]));
        }

    }

    /**
     * Handle the Page "deleted" event.
     */
    public function deleted(Page $page): void
    {
        // Cicla tra i menuitems associati a questa pagina e rimuovili
        Menuitem::where('type', 'page')
            ->where('model_id', $page->id)
            ->get()
            ->each(fn (Menuitem $menuitem) => $menuitem->delete());
    }

    /**
     * Handle the Page "restored" event.
     */
    public function restored(Page $page): void
    {
        // Cicla tra i menuitems associati a questa pagina e ripristinali
        Menuitem::withTrashed()
            ->where('type', 'page')
            ->where('model_id', $page->id)
            ->get()
            ->each(fn (Menuitem $menuitem) => $menuitem->restore());
    }

    /**
     * Handle the Page "force deleted" event.
     */
    public function forceDeleted(Page $page): void
    {
        // Cicla tra i menuitems associati a questa pagina e rimuovili definitivamente
        Menuitem::withTrashed()
            ->where('type', 'page')
            ->where('model_id', $page->id)
            ->get()
            ->each(fn (Menuitem $menuitem) => $menuitem->delete());
    }
}
