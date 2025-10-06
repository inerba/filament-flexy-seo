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

        {{-- Pubblicità --}}
        <div class="container mx-auto my-12">
            <div class="aspect-[50/9] bg-blue-100 flex items-center justify-center">
                <div class="text-center">
                    <h2 class="text-2xl font-bold">Pubblicità</h2>
                    <p class="text-gray-600">Contenuto sponsorizzato</p>
                </div>
            </div>
        </div>

        {{-- Header --}}
        <x-typo.page-title class="mt-24 mb-24">
            <h1 class="mb-4">{{ $category->name }}</h1>
            @if ($category->extras['description'] ?? false)
                <div>
                    {!! $category->extras['description'] !!}
                </div>
            @endif
        </x-typo.page-title>

        {{-- articles --}}
        @foreach ($chunks as $chunk)
            <div class="container mx-auto grid lg:grid-cols-3 xl:grid-cols-4 gap-8 relative mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:col-span-2 xl:col-span-3">
                    @foreach ($chunk as $article)
                        <x-cms.article-card :$article />
                    @endforeach
                </div>
                {{-- Sidebar --}}
                <div class="hidden lg:block lg:col-span-1">

                    <div class="sticky top-14 aspect-[4/3] bg-blue-100 flex items-center justify-center">
                        <div class="text-center">
                            <h2 class="text-2xl font-bold">Pubblicità</h2>
                            <p class="text-gray-600">Contenuto sponsorizzato</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="max-w-[970px] mx-auto my-12">

                <div class="w-full h-[250px] bg-blue-100 flex items-center justify-center">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold">Pubblicità</h2>
                        <p class="text-gray-600">Contenuto sponsorizzato</p>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Paginazione --}}
        <div class="container mx-auto my-12">
            {{ $articles->links('pagination::simple-tailwind') }}
        </div>

    </article>
</x-layouts.main>
