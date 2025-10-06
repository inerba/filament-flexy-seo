@php
    use Carbon\Carbon;
@endphp

@php
    $image = $page->getFirstMedia('featured_images');
@endphp

<x-layouts.main>
    <div class="post-content" data-aos="fade-up">
        <!-- ======= Single Post Content ======= -->
        <div class="prose max-w-none">
            <div class="mx-auto my-24 max-w-5xl text-balance text-center">
                <div class="text-muted text-sm">
                    <span>{{ Carbon::parse($page->updated_at)->format('D, d M Y') }}</span>
                </div>
                <h1 class="mb-5 text-center leading-normal">{{ $page->title }}</h1>
            </div>
            @if ($image && data_get($page, 'extras.show_featured_image', false))
                <x-cms.featured-image-cover :image_url="$image->getUrl()" :alt="$page->title . ' cover'" />
            @endif

            <x-rich-content :model="$page" @class([
                'prose lg:prose-xl prose-p:mx-auto prose-p:max-w-5xl max-w-none px-4 vertical-margin',
                'has-dropcap' => data_get($page, 'extras.content_settings.dropcap', false),
            ]) />
        </div>
        <!-- End Single Post Content -->

        <hr />
    </div>
</x-layouts.main>
