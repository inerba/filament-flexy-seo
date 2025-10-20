@php
    $image = $event->getFirstMedia('featured_image'); // Immagine in evidenza
    $og_image = $event->getFirstMedia('og_image'); // Immagine per Open Graph
@endphp

<x-layouts.main>
    <x-seo>
        <x-slot:title>
            {{ $event->meta['tag_title'] ?? $event->title }}
        </x-slot>
        <x-slot:description>
            {{ $event->meta['meta_description'] ?? null }}
        </x-slot>
        <x-slot:image>
            {{ $og_image ? $og_image->getUrl() : ($image ? $image->getUrl() : null) }}
        </x-slot>
        <x-slot:url>{{ request()->url() }}</x-slot>
        <x-slot:type>article</x-slot>
        <x-slot:published_time>{{ $event->published_at }}</x-slot>
        <x-slot:modified_time>{{ $event->updated_at }}</x-slot>
    </x-seo>
    <article class="mb-16">
        {{-- Header --}}
        <x-cms.posts.header :category="$event->category">
            <x-slot:title>
                {{ $event->title }}
            </x-slot>
            <x-slot:date>{{ $event->created_at->translatedFormat('d M y') }}</x-slot>
            {{-- <x-slot:author>{{ $event->author->name }}</x-slot> --}}
        </x-cms.posts.header>

        {{-- Copertina --}}
        @if ($image && data_get($event, 'extras.show_featured_image', false))
            <x-cms.featured-image-cover :image_url="$image->getUrl()" :alt="$event->title . ' cover'" />
        @endif

        {{-- Contenuto --}}
        {{-- <x-cms.article :$event /> --}}

        <x-rich-content :model="$event" @class([
            'prose lg:prose-xl prose-p:mx-auto prose-p:max-w-5xl max-w-none px-4',
            'has-dropcap' => data_get($event, 'extras.content_settings.dropcap', false),
        ]) />

    </article>
</x-layouts.main>
