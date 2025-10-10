@props([
    'item' => null,
    'active' => false,
])

@php
    $locale = app()->getLocale();
    $itemClasses = 'text-xl w-full px-4 py-2 text-sm text-gray-600 hover:text-black focus:text-black';
    $title = $item['title'][$locale] ?? $item['title'];
    $rel = $item['extras']['rel'][0] ?? null;
    $localizedUrl = localize_url($item['url']);
@endphp

<li>
    @if (filled($item['children']))
        <x-dropdown>
            <x-slot:trigger>
                <button type="button"
                    {{ $attributes->class([$itemClasses, '' => $active, 'flex items-center gap-2']) }}>
                    <span>{{ $title }}</span>
                    @svg('heroicon-s-chevron-down', '-me-2 h-3 w-3')
                </button>
            </x-slot>

            <ul class="">
                @foreach ($item['children'] as $child)
                    <x-menus.main-menu.item :item="$child" />
                @endforeach
            </ul>
        </x-dropdown>
    @else
        <a href="{{ $localizedUrl }}" @if ($item['target']) target="{{ $item['target'] }}" @endif
            @if ($rel) rel="{{ $rel }}" @endif
            {{ $attributes->class([$itemClasses, 'font-semibold text-black' => active_route($localizedUrl)]) }}>
            {{ $title }}
        </a>
    @endif
</li>

