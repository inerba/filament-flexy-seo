<?php

namespace App\Observers\Cms;

use App\Models\Cms\Menu;
use Illuminate\Support\Facades\Cache;

class MenuObserver
{
    /**
     * Handle the Menu "updated" event.
     */
    public function updated(Menu $menu): void
    {
        Cache::forget('menu_'.$menu->slug);
    }
}
