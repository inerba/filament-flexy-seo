<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-12 lg:gap-x-24">
        @foreach ($books as $book)
            <a href="{{ $book->permalink }}" class="flex gap-6 group md:hover:scale-110 transition-transform">
                <div class="shrink-0">
                    @if ($book->getFirstMediaUrl('covers', 'medium'))
                        <img src="{{ $book->getFirstMediaUrl('covers', 'medium') }}" alt="{{ $book->title }}"
                            class="shadow-xl group-hover:scale-125 group-hover:shadow-black/30 transition-all w-32">
                    @else
                        <div class="w-32 h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">No Cover</span>
                        </div>
                    @endif
                </div>
                <div class="leading-tight">
                    <div class="text-balance text-sm line-clamp-1">{{ $book->authors->pluck('name')->implode(', ') }}
                    </div>
                    <h2 class="text-2xl text-balance font-semibold font-display!">
                        {{ $book->title }}
                        {{ localized($book->meta['subtitle']) ?? '' }}
                    </h2>
                    <div class="border-b-2 w-12 my-4"></div>
                    <p class="text-balance line-clamp-5">{{ $book->short_description }}</p>
                </div>
            </a>
        @endforeach
    </div>
    @if ($books->links()->paginator->hasPages())
        <div class="my-12">

            {{ $books->links() }}

        </div>
    @endif
</div>

