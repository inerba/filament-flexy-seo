<x-layouts.main>
    <x-slot:seo>
        <x-seo :title="db_config('home-page.meta.seo.tag_title')" :description="db_config('home-page.meta.seo.meta_description')" :og_title="db_config('home-page.social.og.title')" :og_description="db_config('home-page.social.og.description')" :image="db_config('home-page.social.og_image')" />
    </x-slot>

    <div class="prose lg:prose-2xl mx-auto max-w-5xl px-4 py-16">
        <x-rich-content :content="db_config('home-page.content')" @class([
            'lg:prose-xl prose-p:mx-auto prose-p:max-w-5xl',
            'has-dropcap' => db_config('home-page.content.has_dropcap', false),
        ]) />
    </div>
</x-layouts.main>

