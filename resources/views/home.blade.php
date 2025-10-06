@props(['page'])

<x-layouts.base>
    {{-- @push('header')
        <x-home-slider :slides="db_config('homepage.slides')" aspect_class="aspect-square md:aspect-[5/2]" />
    @endpush --}}

    @push('mainTop')
        {{-- <section x-data="" @mouseenter="$refs.video.pause()" @mouseleave="$refs.video.play()" class="px-4 py-12 custom-cursor group xl:px-0">

            <div class="max-w-5xl mx-auto my-12">
                <h1 class="text-logo !text-primary-500 mb-12 text-center text-4xl sm:text-7xl lg:text-[6rem] 2xl:text-[8rem]">
                    @db_config('homepage.section_1.title')
                </h1>
                <div class="gap-16 prose text-justify dark:prose-invert lg:prose-xl dark:text-white md:columns-2">
                    @db_config('homepage.section_1.content')
                </div>
            </div>
        </section> --}}



        {{-- <section x-data="" @mouseenter="$refs.video.pause()" @mouseleave="$refs.video.play()"
        class="relative px-4 py-12 group custom-cursor dark bg-stone-600 xl:px-0">
        <video x-ref="video" x-init="console.log($el)" class="absolute top-0 left-0 z-0 object-cover w-full h-full"
            autoplay loop muted playsinline poster="/video/tunnel.jpg">
            <source src="/video/tunnel.mp4" type="video/mp4">
            Il tuo browser non supporta il tag video.
        </video>
        <div class="absolute inset-0 z-10 transition-all bg-stone-700/95 group-hover:backdrop-blur">
        </div>
        <div class="relative z-20 max-w-5xl mx-auto my-12">
            <h1
                class="text-logo !text-primary-500 mb-12 text-center text-4xl sm:text-7xl lg:text-[6rem] 2xl:text-[8rem]">
                @db_config('homepage.section_1.title')
            </h1>
            <div class="gap-16 prose text-justify dark:prose-invert lg:prose-xl md:columns-2 dark:text-white">
                @db_config('homepage.section_1.content')
            </div>
        </div>
    </section> --}}
    @endpush

    <section>
        <livewire:store-front />
    </section>

    <section class="my-12">
        <h2 class="mb-12 border-b-2 pb-1 text-3xl">Ultime uscite</h2>
        <livewire:book-section :genres="['Thriller']" />
        <div class="mt-12 flex items-center">
            <a class="font-display mx-auto inline-block w-auto border border-stone-500 px-4 py-4 uppercase leading-none tracking-wide transition-all hover:bg-stone-50" href="#">Tutte le ultime uscite</a>
        </div>
    </section>

    <section class="my-12">
        <h2 class="mb-12 border-b-2 pb-1 text-3xl">Gli imperdibili</h2>
        <livewire:book-section :genres="['Narrativa']" />
        <div class="mt-12 flex items-center">
            <a class="font-display mx-auto inline-block w-auto border border-stone-500 px-4 py-4 uppercase leading-none tracking-wide transition-all hover:bg-stone-50" href="#">Tutte le ultime uscite</a>
        </div>
    </section>

</x-layouts.base>
