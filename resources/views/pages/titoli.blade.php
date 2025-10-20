@php
    use Carbon\Carbon;
@endphp

@php
    $image = $page->getFirstMedia('featured_images');
    $og_image = $page->getFirstMedia('og_image'); // Immagine per Open Graph
    $show_image = data_get($page, 'extras.show_featured_image', false);
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
    <div class="post-content mb-12 lg:mb-24" data-aos="fade-up">
        <!-- ======= Single Post Content ======= -->
        <div class="prose max-w-none lg:prose-xl">
            <div @class([
                'mx-auto max-w-5xl text-balance text-center',
                'pt-6 lg:pt-24' => $image && $show_image,
                'pt-6 lg:pt-24 lg:pb-12' => !($image && $show_image),
            ])>
                {{-- Titolo --}}
                @if (data_get($page, 'extras.content_settings.show_created_at', false))
                    <div class="text-muted text-sm mb-2 capitalize">
                        <span>{{ Carbon::parse($page->updated_at)->translatedFormat('D, d M Y') }}</span>
                    </div>
                @endif
                <h1 class="mb-5 text-center leading-normal">{{ $page->title }}</h1>
            </div>
            @if ($image && $show_image)
                <x-cms.featured-image-cover :image_url="$image->getUrl()" :alt="$page->title . ' cover'" />
            @endif

            <x-rich-content :model="$page" @class([
                'prose lg:prose-xl prose-p:mx-auto prose-p:max-w-5xl max-w-none px-4',
                'prose-headings:max-w-5xl prose-headings:mx-auto',
                'has-dropcap' => data_get($page, 'extras.content_settings.dropcap', false),
            ]) />
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
            <livewire:book-list lazy />
        </div>
    </div>
</x-layouts.main>

