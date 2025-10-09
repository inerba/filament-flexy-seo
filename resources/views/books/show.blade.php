@props(['book'])

@php
    $cover = $book->getFirstMedia('covers');
@endphp
<x-layouts.base>

    <div class="mx-auto my-16 flex flex-col md:flex-row max-w-7xl gap-6 lg:gap-12">

        @if ($cover)
            <div class="shrink-0 max-w-96 md:max-w-48 lg:max-w-80 xl:max-w-96 flex flex-col items-center mx-auto">
                <a href="{{ $cover->getUrl('large') }}" class="glightbox cursor-zoom-in flex items-center mx-auto ">
                    <img class="mx-auto bg-red-100 shadow-2xl" src="{{ $cover->getUrl('medium') }}"
                        alt="Copertina del libro: {{ $book->title }}">
                </a>
            </div>
        @endif

        <div @class(['mx-auto' => !$cover, 'flex flex-col gap-12'])>

            <div>
                <div class="font-display mb-1 text-xl text-stone-500">
                    @foreach ($book->authors as $author)
                        @if (!$loop->first)
                            ,
                        @endif
                        {{ $author->name }}
                    @endforeach
                </div>
                <div class="font-display text-5xl font-bold">
                    {{ $book->title }}
                </div>
                @if ($book->meta['subtitle'])
                    <div class="font-display text-3xl mt-2">
                        {{ localized($book->meta['subtitle']) }}
                    </div>
                @endif
            </div>

            <div
                class="font-display flex flex-col gap-2 border-l-2 bg-gradient-to-r from-stone-50 to-transparent py-4 pl-8 text-sm uppercase text-stone-700">
                <div><strong>{{ __('Genres') }}</strong>: {{ $book->genres->pluck('name')->implode(', ') }}</div>
                @if ($book->year)
                    <div><strong>{{ __('Year') }}</strong>: {{ $book->year }}</div>
                @endif
                @if ($book->isbn)
                    <div><strong>ISBN</strong>: {{ $book->isbn }}</div>
                @endif
                @if ($book->publisher)
                    <div><strong>{{ __('Publisher') }}</strong>: {{ $book->publisher }}</div>
                @endif
                @if ($book->pages)
                    <div><strong>{{ __('Pages') }}</strong>: {{ $book->pages }}</div>
                @endif
                @if ($book->product)
                    <div><strong>{{ __('Cover Price') }}</strong>: {{ format_money($book->product->price) }}</div>
                @endif
            </div>

            <div class="prose lg:prose-xl dark:prose-invert prose-orange max-w-3xl">
                {!! str($book->description)->sanitizeHtml() !!}
            </div>

        </div>
    </div>

    @pushOnce('scripts', 'glightbox-script')
        @vite(['resources/js/glightbox.js'])
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const lightbox = GLightbox({
                    touchNavigation: true,
                    loop: true,
                    autoplayVideos: true
                });
            });
        </script>
    @endpushOnce

</x-layouts.base>

