{{-- @aware(['model']) --}}
@php

    $rand = $config['rand'] ?? null;
    $layout = $config['layout'] ?? 'grid';
    $columns = $config['columns'] ?? 3;

    $images = $model->getMedia('rich-content-gallery' . $rand) ?? [];

@endphp
<x-rich-editor.layout :$config>

    @if ($layout === 'carousel')
        <div x-data="{
            init() {
                new Splide(this.$refs.splide, {
                    perPage: @json($columns),
                    pagination: true,
                    arrows: true,
                    rewind: true,
                    // autoHeight: true,
                    gap: '0.5rem',
                    breakpoints: {
                        640: {
                            perPage: 1,
                        },
                    },
                }).mount()
            },
        }">
            <div x-ref="splide" class="not-prose splide" role="group" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($images as $image)
                            <li class="splide__slide">
                                <a href="{{ $image->getUrl('lg') }}" data-gallery="gallery-{{ $rand }}"
                                    @class([
                                        'overflow-hidden not-prose bg-cover rounded-3xl glightbox bg-red-50',
                                    ])>
                                    <img src="{{ $image->getUrl('thumbnail') }}" alt="{{ $image->name }}"
                                        class="object-cover" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        @pushOnce('styles', 'splide-style')
            <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
        @endPushOnce

        @pushOnce('scripts', 'splide-script')
            <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
        @endPushOnce
    @else
        <div @class([
            'gallery grid gap-4',
            match ($columns) {
                1 => 'lg:grid-cols-1',
                2 => 'lg:grid-cols-2',
                3 => 'lg:grid-cols-3',
                4 => 'lg:grid-cols-4',
                5 => 'lg:grid-cols-5',
                6 => 'lg:grid-cols-6',
                default => 'lg:grid-cols-3',
            },
        ])>
            @foreach ($images as $image)
                <a href="{{ $image->getUrl('lg') }}" data-gallery="gallery-{{ $rand }}"
                    @class([
                        'overflow-hidden not-prose bg-cover rounded-3xl glightbox bg-red-50',
                    ])>
                    <img src="{{ $image->getUrl('thumbnail') }}" alt="{{ $image->name }}" class="object-cover" />
                </a>
            @endforeach
        </div>
    @endif
    @pushOnce('styles', 'glightbox-style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    @endPushOnce

    @pushOnce('scripts', 'glightbox-script')
        <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
        <script>
            const lightbox = GLightbox({
                selector: '.glightbox',
            });
        </script>
    @endPushOnce
</x-rich-editor.layout>

