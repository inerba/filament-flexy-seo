@props(['slides', 'title' => 'Cluster-A', 'aspect_class' => 'aspect-square md:aspect-16/9'])
@php
    $image_desktop = $slides[0]['image_desktop'] ?? null;
    $image_mobile = $slides[0]['image_mobile'] ?? null;
@endphp
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
                <li class="splide__slide {{ $aspect_class }} flex flex-col items-center justify-center overflow-hidden">
                    @if (optional($slide['url']))
                        <a href="{{ $slide['url'] }}">
                    @endif
                    <picture>
                        <source media="(min-width: 768px)" srcset="/storage/{{ $image_desktop }}">
                        <img loading="lazy" class="w-full" src="/storage/{{ $image_mobile }}" alt="{{ $title }}">
                    </picture>
                    @if (optional($slide['url']))
                        </a>
                    @endif
                </li>
            @endforeach

        </ul>
    </div>
</section>

