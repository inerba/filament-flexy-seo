<div class="bg-black p-8 text-white lg:p-12">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
            <div class="col-span-2">
                <x-logo />

                <div class="mt-4 flex flex-wrap gap-4">
                    @foreach (db_config('website.social_profiles', []) as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                            class="flex size-6 items-center gap-2 text-neutral-500 transition-colors duration-300 hover:text-white lg:size-8">
                            {!! $social['svg'] !!}
                            <span class="sr-only">{{ $social['title'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            <div>
                <h3 class="mb-2 text-xl uppercase">Categorie</h3>
                <ul>
                    <li><a href="#" class="hover:underline">Link 1</a></li>
                    <li><a href="#" class="hover:underline">Link 2</a></li>
                    <li><a href="#" class="hover:underline">Link 3</a></li>
                    <li><a href="#" class="hover:underline">Link 4</a></li>
                    <li><a href="#" class="hover:underline">Link 5</a></li>
                    <li><a href="#" class="hover:underline">Link 6</a></li>
                    <li><a href="#" class="hover:underline">Link 7</a></li>
                    <li><a href="#" class="hover:underline">Tutte le categorie...</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-2 text-xl uppercase">{{ __('Informazioni') }}</h3>
                {{-- <ul>
                    <li><a href="#" class="hover:underline">Detective Salute</a></li>
                    <li><a href="#" class="hover:underline">Termini e Condizioni</a></li>
                    <li><a href="#" class="hover:underline">Privacy Policy</a></li>
                    <li><a href="#" class="hover:underline">Cookies</a></li>
                </ul> --}}
                <livewire:cms.menu slug="footer-menu" />
            </div>
        </div>
        <div class="mt-12 border-t-2 border-dashed pt-4 text-center text-xs uppercase text-neutral-500 lg:text-sm">
            <p>
                &copy; {{ date('Y') }} @db_config('website.footer_copyright.' . app()->getLocale())
            </p>
        </div>
    </div>
</div>

