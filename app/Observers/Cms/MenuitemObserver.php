<?php

namespace App\Observers\Cms;

use App\Models\Cms\Menuitem;
use Illuminate\Support\Facades\Cache;

class MenuitemObserver
{
    public function created(Menuitem $item): void
    {
        $this->clearMenuCache($item->menu_id ?? null);
    }

    public function updated(Menuitem $item): void
    {
        $this->clearMenuCache($item->menu_id ?? null);
    }

    public function deleted(Menuitem $item): void
    {
        $this->clearMenuCache($item->menu_id ?? null);
    }

    public function restored(Menuitem $item): void
    {
        $this->clearMenuCache($item->menu_id ?? null);
    }

    protected function clearMenuCache(?int $menuId): void
    {
        if (empty($menuId)) {
            return;
        }

        // If menuId is present, try to find the slug for the menu and clear its cache
        $menu = \App\Models\Cms\Menu::find($menuId);

        if (! $menu) {
            return;
        }

        $slug = $menu->slug ?? null;

        if (empty($slug)) {
            return;
        }

        Cache::forget("menu_{$slug}");
    }
}
