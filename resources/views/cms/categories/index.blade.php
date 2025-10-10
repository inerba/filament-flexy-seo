{{-- @php
    $image = $post->getFirstMedia('featured_image'); // Copertina
    $og_image = $post->getFirstMedia('og_image'); // Immagine per Open Graph
@endphp

@section('title', $post->meta['tag_title'] ?? $post->title)
@section('description', $post->meta['meta_description'] ?? null)
@section('og')
    <x-og>
        <x-slot:title>
            {{ $post->meta['og']['title'] ?? ($post->meta['tag_title'] ?? $post->title) }}
        </x-slot>
        <x-slot:description>
            {{ $post->meta['og']['description'] ?? ($post->meta['meta_description'] ?? null) }}
        </x-slot>
        <x-slot:image>
            {{ $og_image ? $og_image->getUrl() : ($image ? $image->getUrl() : null) }}
        </x-slot>
        <x-slot:url>{{ request()->url() }}</x-slot>
        <x-slot:type>article</x-slot>
    </x-og>
@endsection --}}

@php
    $chunks = $articles->chunk(6); // Raggruppa i post in array di 6
@endphp

<x-layouts.main>
    <article class="px-4">

        {{-- Header --}}
        <x-typo.page-title class="mt-24 mb-24">
            <h1 class="mb-4">{{ $category->name }}</h1>
            @if (localized($category->extras['description']) ?? false)
                <div>
                    {!! localized($category->extras['description']) !!}
                </div>
            @endif
        </x-typo.page-title>

        {{-- articles --}}
        <div class="max-w-7xl mx-auto relative mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-12 lg:col-span-2 xl:col-span-3">
                @foreach ($articles as $article)
                    <x-cms.article-card :$article />
                @endforeach
            </div>
        </div>

        {{-- Paginazione --}}
        <div class="max-w-7xl mx-auto my-12">
            {{ $articles->links('pagination::simple-tailwind') }}
        </div>

    </article>
</x-layouts.main>

