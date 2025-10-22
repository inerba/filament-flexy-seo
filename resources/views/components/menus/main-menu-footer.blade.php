<nav id="main-menu">
    <div class="flex flex-col gap-1">
        @if (is_array($items))
            @forelse ($items as $item)
                @php
                    $locale = app()->getLocale();
                    $title = $item['title'][$locale] ?? $item['title'];
                    $rel = $item['extras']['rel'][0] ?? null;
                    $localizedUrl = localize_url($item['url']);
                @endphp
                <a wire:navigate href="{{ $localizedUrl }}"
                    @if ($item['target']) target="{{ $item['target'] }}" @endif
                    @if ($rel) rel="{{ $rel }}" @endif
                    class="@if (active_route($localizedUrl)) text-black @endif underline">
                    {{ $title }}
                </a>
            @empty
                <span class="text-gray-500">No menu items found.</span>
            @endforelse
        @endif
    </div>
</nav>

