    @php
        $related = $exclude != null;
    @endphp

    <div @class([
        'grid grid-cols-2',
        'md:grid-cols-3 lg:grid-cols-3 gap-6 p-6' => !$related,
        'md:grid-cols-2 lg:grid-cols-5 gap-4 p-4' => $related,
    ])>
        @forelse ($authors as $author)
            @php
                $name = $author->name;
                $permalink = $author->permalink;
            @endphp
            <div class="flex items-center space-x-4 flex-col relative">
                <a wire:navigate.hover href="{{ $permalink }}"
                    class="hover:scale-3d rounded shadow-2xl overflow-hidden hover:scale-105 hover:z-10 transition-all duration-300 relative group text-center aspect-video w-full">

                    <div
                        class="absolute inset-x-0 h-full flex items-center justify-center bg-stone-50 group-hover:bg-primary group-hover:text-white transition-all">
                        <div class="p-4">
                            <h2 class="font-semibold leading-tight md:text-xl text-balance transition-all">
                                {{ $name }}</h2>
                            <div class="text-xs hidden md:group-hover:block uppercase font-display">Apri la
                                biografia</div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div>Nessun autore trovato.</div>
        @endforelse
    </div>

