@props([
    'item' => null,
    'active' => false,
    'class' =>
        'flex items-center leading-none gap-8 text-lg border-b-2 border-transparent font-medium tracking-tight transition duration-200 text-black hover:border-black',
])

@php
    $locale = app()->getLocale();
    $title = $item['title'][$locale] ?? $item['title'];
    $localizedUrl = localize_url($item['url']);
@endphp
@if (isset($item['children']) && !empty($item['children']))
    <x-menus.dropdown>
        <x-slot:label>
            {{ $title }}
        </x-slot>

        @foreach ($item['children'] as $child)
            @php
                $childLocalizedUrl = localize_url($child['url']);
                $childTitle = $child['title'][$locale] ?? $child['title'];
            @endphp

            <a href="{{ $childLocalizedUrl }}" @if (isset($child['target'])) target="{{ $child['target'] }}" @endif
                class="flex w-full items-center rounded-sm px-2 pb-1 pt-2 text-left leading-none text-white/70 transition-colors hover:text-white disabled:cursor-not-allowed disabled:opacity-50">
                {{ $childTitle }}
            </a>
        @endforeach
    </x-menus.dropdown>
@else
    @if (isset($localizedUrl))
        <a href="{{ $localizedUrl }}" @if (isset($item['target'])) target="{{ $item['target'] }}" @endif
            @class([$class, 'border-black!' => active_route($localizedUrl)])>
            {{ $title }}
        </a>
    @else
        <span @class([$class, 'text-gray-500' => $active])>
            {{ $title }}
        </span>
    @endif
@endif

