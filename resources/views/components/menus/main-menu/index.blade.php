@props([
    'name' => null,
    'items' => [],
])

<div class="flex items-center justify-center gap-4 pb-2 pt-4 uppercase">
    @foreach ($items as $item)
        <x-menus.main-menu.item :item="$item" />
    @endforeach
</div>
