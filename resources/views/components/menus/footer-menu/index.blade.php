@props([
    'name' => null,
    'items' => [],
])
@php
    $locale = app()->getLocale();
@endphp
<div>

    <ul>
        @foreach ($items as $item)
            @php
                $title = $item['title'][$locale] ?? $item['title'];
                $localizedUrl = LaravelLocalization::localizeURL($item['url']);
            @endphp
            <li><a href="{{ $localizedUrl }}" @if ($item['target']) target="{{ $item['target'] }}" @endif
                    class="hover:underline">{{ $title }}</a>
            </li>
        @endforeach
    </ul>
</div>

