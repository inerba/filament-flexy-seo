@props(['book'])

@php
    $cover = $book->getFirstMedia('covers')?->getUrl('medium');
@endphp
<x-layouts.base>

    <div class="mx-auto my-16 flex max-w-7xl gap-12">

        @if ($cover)
            <div class="shrink-0">
                <img class="min-h-80 w-80 bg-red-100 shadow-2xl" src="{{ $cover }}" alt="Copertina del libro: {{ $book->title }}">
            </div>
        @endif

        <div @class(['mx-auto' => !$cover, 'flex flex-col gap-12'])>

            <div>
                <div class="font-display mb-1 text-2xl text-stone-500">
                    {{ $book->author->name }}
                </div>
                <div class="font-display text-5xl uppercase">
                    {{ $book->title }}
                </div>
            </div>

            <div class="font-display flex flex-col gap-2 border-l-2 bg-gradient-to-r from-stone-50 to-transparent py-4 pl-8 text-sm uppercase text-stone-700">
                <div><strong>{{ __('Genres') }}</strong>: {{ $book->genres->pluck('name')->implode(', ') }}</div>
                <div><strong>{{ __('Year') }}</strong>: {{ $book->year }}</div>
                <div><strong>{{ __('Pages') }}</strong>: {{ $book->pages }}</div>
                <div><strong>{{ __('Cover Price') }}</strong>: {{ $book->formatted_price }}</div>
            </div>

            <div class="prose lg:prose-xl dark:prose-invert prose-orange max-w-3xl">
                {!! str($book->description)->sanitizeHtml() !!}
            </div>

        </div>
    </div>

</x-layouts.base>
