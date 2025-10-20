<x-typo.page-title>
    @if ($category)
        {{-- <a href="{{ $category->permalink }}" class="uppercase hover:underline"> --}}
        <div class="font-bold uppercase text-stone-500 font-display!">
            {{ $category->name }}
        </div>
        {{-- </a> --}}
    @endif
    <h1>{{ $title }}</h1>
    {{-- <div class="font-bold uppercase">By {{ $author }}</div> --}}
    <div class="capitalize">{{ $date }}</div>
</x-typo.page-title>

