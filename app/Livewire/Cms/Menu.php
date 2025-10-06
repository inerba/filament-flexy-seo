<?php

namespace App\Livewire\Cms;

use App\Models\Cms\Menu as MenuModel;
use App\Models\Cms\Menuitem;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Menu extends Component
{
    public ?MenuModel $menu = null;

    public ?string $slug = null;

    public ?string $variant = null;

    public function mount(): void
    {

        $this->menu = Cache::remember("menu_{$this->slug}", 60 * 60, function () {
            $menu = MenuModel::query()
                ->with('menuitems')
                ->where('slug', $this->slug)
                ->first();

            if ($menu) {
                $menu->menuitems = app(Menuitem::class)->toTree($menu->menuitems);
            }

            return $menu;
        });

    }

    public function render()
    {
        return view('livewire.menu');
    }
}
