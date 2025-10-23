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
                $avatar = $author->getFirstMedia('avatars')?->getUrl('medium') ?? null;
                $name = $author->name;
                $permalink = $author->permalink;
            @endphp
            <div class="flex items-center space-x-4 flex-col relative">
                <a wire:navigate.hover href="{{ $permalink }}"
                    class="hover:scale-3d rounded shadow-2xl overflow-hidden hover:scale-105 hover:z-10 transition-all duration-300 relative group text-center aspect-[3/4] w-full">
                    <div
                        class="group-hover:backdrop-blur-xs group-hover:h-full group-hover:to-transparent bg-gradient-to-b from-0% to-primary-500/40 absolute inset-x-0 bottom-0 h-1/3">
                    </div>
                    @if ($avatar)
                        <img src="{{ $avatar }}" alt="{{ $name }}"
                            class="object-center object-cover w-full h-full">
                    @else
                        <div
                            class="select-none object-center object-cover w-full h-full bg-gray-200 flex items-center justify-center text-gray-300">
                            <span class="text-[10rem] leading-0 font-bold">{{ strtoupper(substr($name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div class="absolute inset-x-0 bottom-0 p-6">
                        <h2
                            class="font-semibold leading-tight md:text-xl text-white text-balance group-hover:tracking-wider transition-all">
                            {{ $name }}</h2>
                        <div class="text-sm text-white hidden md:group-hover:block uppercase font-display">Apri la
                            biografia</div>
                    </div>
                    <div
                        class="absolute inset-0 text-white h-full w-full p-6 hidden group-hover:items-center group-hover:flex group-hover:justify-center">
                        @svg('phosphor-arrow-bend-up-right-fill', 'size-20 text-white animate-pulse')
                    </div>
                </a>
            </div>
        @empty
            <div>Nessun autore trovato.</div>
        @endforelse
    </div>

