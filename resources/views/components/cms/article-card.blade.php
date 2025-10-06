<div>
    <a href="{{ $article->permalink }}" class="block">
        <div class="aspect-square bg-red-200 mb-4">
            @php
                $media = $article->getFirstMedia('featured_image');
            @endphp
            @if ($media)
                <img src="{{ $media->getUrl('square') }}" alt="{{ $article->title }}" class="object-cover w-full h-full">
            @endif
        </div>
    </a>
    <div class="flex flex-col gap-2">
        {{-- Titolo --}}
        <a href="{{ $article->permalink }}" class="block hover:underline">
            <h2 class="uppercase font-bold">{{ $article->title }}</h2>
        </a>

        {{-- Estratto, autore e data --}}
        <div class="line-clamp-2">
            {{ $article->excerpt }}
        </div>
        {{-- <div class="text-gray-500 uppercase">
            di {{ $article->author->name }}
        </div> --}}
        <div class="text-gray-400 text-sm">
            {{ $article->published_at->format('d F Y') }}
        </div>
    </div>
</div>
