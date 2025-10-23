    <div>

        <x-seo>
            <x-slot:title>
                News
            </x-slot>
            <x-slot:description>
                Ultime notizie e aggiornamenti
            </x-slot>
        </x-seo>
        <article class="px-4">

            {{-- Header --}}
            <x-typo.page-title class="mt-24 mb-24 prose lg:prose-xl">
                <h1 class="mb-4">News</h1>
                {{-- <div>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque, ipsa!
            </div> --}}
            </x-typo.page-title>

            {{-- articles --}}
            <div class="max-w-7xl mx-auto relative mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:col-span-2 xl:col-span-3">
                    @foreach ($articles as $article)
                        <x-cms.article-card :$article />
                    @endforeach
                </div>
            </div>

            {{-- Paginazione --}}
            <div class="max-w-7xl mx-auto my-12">
                {{ $articles->links('pagination::simple-tailwind') }}
            </div>

        </article>
    </div>
