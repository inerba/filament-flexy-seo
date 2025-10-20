<x-layouts.main>
    <article class="px-4">

        {{-- Header --}}
        <x-typo.page-title class="my-12 md:my-24">
            <h1 class="mb-4">Prossimi Eventi</h1>
            <div class="max-w-5xl mx-auto text-lg">
                Accanto all’attività editoriale, Cluster-A dà vita a eventi, mostre e incontri che ampliano il suo
                universo culturale. Spazi di dialogo tra libri, arte e pensiero, dove la parola scritta incontra
                l’immagine, l’oggetto e l’esperienza diretta. Occasioni per condividere la passione per la conoscenza,
                la memoria e la forma.
            </div>
        </x-typo.page-title>

        {{-- articles --}}
        <div class="max-w-5xl mx-auto relative mb-6">
            <div class="flex flex-col gap-12">
                @foreach ($events as $event)
                    <a href="{{ $event->permalink }}"
                        class="hover:shadow-black/30 hover:shadow-2xl transition-all lg:hover:scale-105 flex flex-col md:flex-row w-full rounded-2xl overflow-hidden shadow-xl">
                        <div class="lg:w-64 flex-shrink-0 bg-primary-400 p-6 text-white">
                            <div class="text-xl font-bold font-display! text-balance">
                                {{ $event->date }}
                            </div>
                            <div class="text-sm italic text-gray-100">
                                {{ $event->location }}
                            </div>
                        </div>
                        <div class="bg-gray-50 p-6 flex-1">
                            <h2 class="text-xl md:text-3xl font-semibold font-display! mb-4">{{ $event->title }}</h2>
                            <p class="text-gray-600 text-sm md:text-base">{{ $event->content }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Paginazione --}}
        <div class="max-w-7xl mx-auto my-12">
            {{ $events->links('pagination::simple-tailwind') }}
        </div>

    </article>
</x-layouts.main>
