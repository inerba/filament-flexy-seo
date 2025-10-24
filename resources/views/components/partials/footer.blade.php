<div class="text-gray-600 bg-stone-100">
    <div class="grid grid-cols-4 lg:grid-cols-6 gap-4 lg:gap-24 py-6 lg:py-24 mx-auto max-w-7xl px-4">
        <div class="col-span-1 ">
            <img src="/images/logo.png" alt="Logo Cluster-A"
                class="w-full md:w-52 hover:animate-[spin_1500ms_ease-in-out_1_reverse]">
            <h3 class="mt-4 font-display!">Seguici su</h3>
            <div class="mt-2 flex flex-wrap gap-1.5 justify-between w-full">
                @foreach (db_config('website.social_profiles') as $social)
                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                        class="flex size-6 items-center text-stone-400 transition-colors duration-300 hover:text-stone-500 lg:size-8">
                        {!! $social['svg'] !!}
                        <span class="sr-only">{{ $social['title'] }}</span>
                    </a>
                @endforeach
            </div>

        </div>
        <div
            class="col-span-3 md:col-span-2 text-xs md:text-base prose prose-p:mb-1 prose-p:mt-0 prose-headings:font-display!">
            @db_config('website.footer_col_1.' . app()->getLocale())
        </div>
        <div
            class="col-span-4 md:col-span-2 text-xs md:text-base prose prose-p:mb-1 prose-p:mt-0 prose-headings:font-display!">
            @db_config('website.footer_col_2.' . app()->getLocale())
        </div>
        <div class="hidden md:block">
            <h3 class="mb-4 text-xl font-semibold text-black uppercase font-display!">Sitemap</h3>
            <livewire:cms.menu slug="main-menu" variant="-footer" />
        </div>
    </div>
    <div class="bg-stone-200 text-center text-xs md:text-sm py-4">
        @db_config('website.footer_copyright.' . app()->getLocale()) &middot; <a wire:navigate.hover href="/privacy-policy"
            class="underline hover:text-stone-600">Privacy Policy</a>
        &middot; <a wire:navigate.hover href="/cookie-policy" class="underline hover:text-stone-600">Cookie Policy</a>
    </div>
</div>

