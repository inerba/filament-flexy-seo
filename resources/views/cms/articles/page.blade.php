@php
    $image = $article->getFirstMedia('featured_image'); // Immagine in evidenza
    $og_image = $article->getFirstMedia('og_image'); // Immagine per Open Graph
@endphp

<x-layouts.main>
    <x-seo>
        <x-slot:title>
            {{ $article->meta['tag_title'] ?? $article->title }}
        </x-slot>
        <x-slot:description>
            {{ $article->meta['meta_description'] ?? null }}
        </x-slot>
        <x-slot:image>
            {{ $og_image ? $og_image->getUrl() : ($image ? $image->getUrl() : null) }}
        </x-slot>
        <x-slot:url>{{ request()->url() }}</x-slot>
        <x-slot:type>article</x-slot>
        <x-slot:published_time>{{ $article->published_at }}</x-slot>
        <x-slot:modified_time>{{ $article->updated_at }}</x-slot>
    </x-seo>
    <article class="mb-16">
        {{-- Header --}}
        <x-cms.posts.header :category="$article->category">
            <x-slot:title>
                {{ $article->title }}
            </x-slot>
            <x-slot:date>{{ $article->created_at->translatedFormat('d M Y') }}</x-slot>
            {{-- <x-slot:author>{{ $article->author->name }}</x-slot> --}}
        </x-cms.posts.header>

        {{-- Copertina --}}
        @if ($image && data_get($article, 'extras.show_featured_image', false))
            <x-cms.featured-image-cover :image_url="$image->getUrl()" :alt="$article->title . ' cover'" />
        @endif

        {{-- Contenuto --}}
        {{-- <x-cms.article :$article /> --}}

        <x-rich-content :model="$article" @class([
            'prose lg:prose-xl prose-p:mx-auto prose-p:max-w-5xl max-w-none px-4',
            'has-dropcap' => data_get(
                $article,
                'extras.content_settings.dropcap',
                false),
        ]) />

    </article>
</x-layouts.main>

