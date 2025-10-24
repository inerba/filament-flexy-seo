@props(['book'])

@php
    $cover = $book->getFirstMedia('covers');
@endphp
<x-layouts.base>

    <div class="mx-auto lg:my-12 flex flex-col md:flex-row max-w-7xl gap-6 lg:gap-12">

        @if ($cover)
            <div class="shrink-0 max-w-96 md:max-w-48 lg:max-w-80 xl:max-w-96 flex flex-col items-center mx-auto">
                <a href="{{ $cover->getUrl('large') }}" class="glightbox cursor-zoom-in flex items-center mx-auto ">
                    <img class="mx-auto" src="{{ $cover->getUrl('medium') }}"
                        alt="Copertina del libro: {{ $book->title }}">
                </a>

                @if ($book->product && db_config('shop.enable_cart', false))
                    <div class="mt-12">
                        @livewire('shop.add-to-cart-btn', ['product' => $book->product])
                    </div>
                @endif
            </div>
        @endif

        <div @class(['mx-auto' => !$cover, 'flex flex-col gap-6 lg:gap-12'])>

            <div>
                <div class="font-display mb-1 lg:text-xl text-stone-500">
                    {{ $book->authors->pluck('name')->implode(', ') }}
                </div>
                <div class="font-display text-3xl lg:text-5xl font-bold">
                    {{ $book->title }}
                </div>
                @if ($book->meta['subtitle'])
                    <div class="font-display text-xl lg:text-3xl lg:mt-2">
                        {{ localized($book->meta['subtitle']) }}
                    </div>
                @endif
            </div>

            <div
                class="font-display flex flex-col gap-1 lg:gap-2 border-l-2 bg-gradient-to-r from-stone-50 to-transparent py-4 pl-4 lg:pl-8 text-xs lg:text-sm uppercase text-stone-700">
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

