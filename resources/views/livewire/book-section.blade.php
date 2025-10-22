<div class="grid grid-cols-1 gap-8 my-6 md:grid-cols-2 lg:grid-cols-3">
    @foreach ($books as $book)
        <a wire:navigate class="flex items-start gap-4 transition-all group" href="{{ $book->link }}">
            <div class="w-1/3 xl:w-2/5">
                <img class="transition-all group-hover:-translate-x-2 group-hover:scale-110"
                    src="{{ $book->getFirstMedia('mockups')->getUrl('medium') }}" alt="">
            </div>
            <div class="w-2/3 xl:w-3/5">
                <div class="font-semibold font-display text-stone-500 md:text-lg">{{ $book->author->name }}</div>
                <div class="text-lg font-bold leading-none uppercase font-display md:text-xl xl:text-2xl">
                    {{ $book->title }}</div>
                <div class="w-10 my-2 border-b border-black"></div>
                <div class="mb-2 text-xs leading-tight sm:text-sm xl:text-base">{{ $book->short_description }}</div>
                <div class="hidden text-stone-500 md:flex">{{ $book->year }} - {{ $book->pages }} pagg.</div>
            </div>
        </a>
    @endforeach
</div>

