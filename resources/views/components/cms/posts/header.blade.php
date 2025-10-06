<x-typo.page-title>
    <a href="{{ $category->permalink }}" class="uppercase hover:underline">
        {{ $category->name }}
    </a>
    <h1>{{ $title }}</h1>
    {{-- <div class="font-bold uppercase">By {{ $author }}</div> --}}
    <div class="text-sm capitalize">{{ $date }}</div>
</x-typo.page-title>
