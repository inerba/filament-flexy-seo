@props(['slides', 'title' => 'Cluster-A', 'aspect_class' => 'aspect-square md:aspect-16/9'])

<section x-data="{
    init() {
        new Splide(this.$el, {
            perPage: 1,
            type: 'loop', // 'loop', 'slide', 'fade'
            gap: '0.5rem',
            pagination: true,
            breakpoints: {
                640: {
                    perPage: 1,
                },
            },
        }).mount()
    },
}" class="splide" aria-label="Slider Home Page">
    <div class="splide__track">
        <ul class="splide__list">

            @foreach ($slides as $slide)
                @php
                    $image_desktop = $slide['image_desktop'] ?? null;
                    $image_mobile = $slide['image_mobile'] ?? null;
                @endphp
                <li
                    class="splide__slide {{ $aspect_class }} flex flex-col items-center justify-center overflow-hidden relative">
                    @if (optional($slide['url']))
                        <a href="{{ $slide['url'] }}">
                    @endif
                    <picture>
                        <source media="(min-width: 768px)" srcset="/storage/{{ $image_desktop }}">
                        <img loading="lazy" class="w-full" src="/storage/{{ $image_mobile }}" alt="{{ $title }}">
                    </picture>

                    @if ($slide['title'])
                        <div @class([
                            'absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-8 h-full w-full flex items-end',
                            'md:py-24 md:px-4 md:items-start',
                        ])
                            style="color: {{ $slide['text_color'] ?? '#fff' }}; background-color: color-mix(in oklab, {{ $slide['background_color'] ?? '#000' }} {{ $slide['opacity'] ?? 30 }}%, transparent);">
                            <div class="slide-prose max-w-7xl mx-auto w-full">{!! $slide['title'] ?? '' !!}</div>
                        </div>
                    @endif

                    @if (optional($slide['url']))
                        </a>
                    @endif
                </li>
            @endforeach

        </ul>
    </div>
</section>

