<x-typo.page-title>
    @if ($category)
        <a href="{{ $category->permalink }}" class="uppercase hover:underline">
            {{ $category->name }}
        </a>
    @endif
    <h1>{{ $title }}</h1>
    {{-- <div class="font-bold uppercase">By {{ $author }}</div> --}}
    <div class="text-sm capitalize">{{ $date }}</div>
</x-typo.page-title>

