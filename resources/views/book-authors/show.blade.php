@php
    $avatar = $author->getFirstMedia('avatars')?->getUrl('medium') ?? null;
@endphp

<x-layouts.main>
    <div class="post-content" data-aos="fade-up">
        <!-- ======= Single Post Content ======= -->
        <div class="prose max-w-none lg:prose-xl my-12 prose-h1:mb-2">
            {{-- <div class="mx-auto pt-24 max-w-5xl text-balance text-center">
                <h1 class="mb-5 text-center leading-normal">{{ $author->name }}</h1>
            </div> --}}

            <div class="flex flex-col md:flex-row max-w-5xl mx-auto gap-12 items-start px-4">
                <div class="shrink-0 w-64 flex mx-auto">
                    @if ($avatar)
                        <img class="not-prose rounded-lg w-full" src="{{ $avatar }}" alt="{{ $author->name }}">
                    @else
                        <div
                            class="select-none w-full aspect-square rounded-lg bg-gray-200 flex items-center justify-center text-gray-300">
                            <span
                                class="text-[10rem] leading-0 font-bold">{{ strtoupper(substr($author->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                <div>
                    <h1 class="mb-5 leading-normal">{{ $author->name }}</h1>
                    <div>
                        {!! $author->bio !!}
                    </div>
                    <div>
                        <h3>Titoli pubblicati:</h3>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($author->books as $book)
                                <li>
                                    <a href="{{ $book->permalink }}" class="text-primary-600 hover:underline">
                                        {{ $book->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Single Post Content -->

        <div class="divide"></div>

        <div class="max-w-7xl mx-auto py-12">
            <livewire:book-authors :exclude="$author->id" lazy />
        </div>

    </div>
</x-layouts.main>
