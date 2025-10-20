@php
    use Carbon\Carbon;
    $image = $page->getFirstMedia('featured_images');
    $latlng = [data_get($page, 'extras.lat', 0) ?: 0, data_get($page, 'extras.lng', 0) ?: 0];
    $popup_content = $page->title;
    $og_image = $page->getFirstMedia('og_image'); // Immagine per Open Graph
@endphp

<x-layouts.main>
    <x-seo>
        <x-slot:title>
            {{ $page->meta['tag_title'] ?? $page->title }}
        </x-slot>
        <x-slot:description>
            {{ $page->meta['meta_description'] ?? null }}
        </x-slot>
        <x-slot:image>
            {{ $og_image ? $og_image->getUrl() : ($image ? $image->getUrl() : null) }}
        </x-slot>
        <x-slot:url>{{ request()->url() }}</x-slot>
        <x-slot:type>article</x-slot>
        <x-slot:published_time>{{ $page->published_at }}</x-slot>
        <x-slot:modified_time>{{ $page->updated_at }}</x-slot>
    </x-seo>
    <div class="post-content md:mb-24 border-b-2 border-gray-200 md:border-none" data-aos="fade-up">
        <!-- ======= Single Post Content ======= -->
        <div class="prose max-w-none lg:prose-xl">
            <div class="mx-auto pt-12 md:py-24 max-w-5xl text-balance text-center">
                @if (data_get($page, 'extras.content_settings.show_created_at', false))
                    <div class="text-muted text-sm mb-2 capitalize">
                        <span>{{ Carbon::parse($page->updated_at)->translatedFormat('D, d M Y') }}</span>
                    </div>
                @endif
                <h1 class="mb-5 text-center leading-normal">{{ $page->title }}</h1>
            </div>
            @if ($image && data_get($page, 'extras.show_featured_image', false))
                <x-cms.featured-image-cover :image_url="$image->getUrl()" :alt="$page->title . ' cover'" />
            @endif

            <div class="flex flex-col md:flex-row max-w-7xl mx-auto">

                <x-rich-content :model="$page" @class([
                    'md:w-1/3',
                    'prose lg:prose-xl prose-p:mx-auto prose-p:max-w-5xl max-w-none px-4 vertical-margin',
                    'prose-headings:max-w-5xl prose-headings:mx-auto',
                    'has-dropcap' => data_get($page, 'extras.content_settings.dropcap', false),
                ]) />

                <div id="map" class="aspect-video max-h-[600px] md:w-2/3"></div>

            </div>
        </div>
    </div>
    @pushOnce('styles', 'leaflet-css')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endPushOnce

    @pushOnce('scripts', 'leaflet-js')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            var map = L.map('map', {
                scrollWheelZoom: false
            }).setView(@json($latlng), @json(data_get($page, 'extras.map_zoom', 13) ?: 13));
            var marker = L.marker(@json($latlng)).addTo(map);
            // marker.bindPopup(@json($popup_content));
            // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //     maxZoom: 19,
            //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            // }).addTo(map);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);
        </script>
    @endPushOnce
</x-layouts.main>
