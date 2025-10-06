<div @class([
    'hidden' => !$menu,
])>
    @if ($menu)
        <x-dynamic-component :component="'menus.' . $slug . $variant" :name="$menu->name" :items="$menu->menuitems" />
    @else
        <!-- Menu not found -->
        <div class="p-4 text-center text-gray-500">
            {{ __('Menu not found') }}
        </div>
    @endif
</div>
