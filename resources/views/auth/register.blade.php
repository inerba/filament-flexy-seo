<x-layouts.fullpage>
    <x-seo title="Registrati - CLUSTER-A" />
    <section class="relative pt-6 px-4 lg:px-6 pb-20 md:pb-32 overflow-hidden min-h-screen bg-gray-50">
        <div class="relative container px-4 mx-auto">
            <div class="max-w-3xl py-14 px-6 xs:px-12 lg:px-16 mx-auto bg-white rounded-4xl shadow-lg">
                <h3 class="font-heading text-4xl text-gray-900 font-semibold mb-4">Registrati</h3>
                <p class="text-lg text-gray-500 mb-10">Crea il tuo account inserendo i tuoi dati.
                </p>
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('register') }}" class="font-display flex flex-col gap-2">
                    @csrf

                    <x-dui.field label="Nome e Cognome" name="name" type="text"
                        placeholder="Inserisci il tuo nome" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                        <x-dui.field label="Email" name="email" type="email"
                            placeholder="Inserisci la tua email" />
                        <x-dui.field label="Telefono" name="phone" type="text"
                            placeholder="Inserisci il tuo telefono" />
                    </div>

                    <x-dui.field label="Indirizzo" name="address[street]" type="text"
                        placeholder="Inserisci il tuo indirizzo" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                        <x-dui.field label="Città" name="address[city]" type="text"
                            placeholder="Inserisci la tua città" />

                        <x-dui.field label="CAP" name="address[postal_code]" type="text"
                            placeholder="Inserisci il CAP" />

                        <x-dui.field label="Provincia" name="address[province]" type="text"
                            placeholder="Inserisci la tua provincia" />

                        <x-dui.field label="Nazione" name="address[country]" type="text"
                            placeholder="Inserisci la tua nazione" />
                    </div>

                    {{-- Password --}}
                    <x-dui.password-field label="Password" name="password" placeholder="Inserisci la tua password" />

                    {{-- Conferma Password --}}
                    <x-dui.password-field label="Conferma Password" name="password_confirmation"
                        placeholder="Conferma la tua password" />

                    {{-- <div class="flex mb-6 items-center">
                            <input type="checkbox" value="" id="">
                            <label class="ml-2 text-gray-800" for="">Ricordami per 30 giorni</label>
                        </div> --}}
                    <button class="btn btn-primary btn-lg mt-4 mb-6 relative overflow-hidden group" type="submit">
                        <div
                            class="absolute top-0 right-full w-full h-full bg-primary-700 transform group-hover:translate-x-full group-hover:scale-102 transition duration-500">
                        </div>
                        <span class="relative text-xl">Registrati</span>
                    </button>
                    {{-- <a class="inline-flex w-full mb-20 py-3 px-4 items-center justify-center rounded-full border border-gray-200 hover:border-gray-400 transition duration-100"
                            href="#">
                            <img src="saturn-assets/images/sign-up/icon-apple.svg" alt="">
                            <span class="ml-4 text-sm font-semibold text-gray-900">Accedi con Apple</span>
                        </a> --}}
                    <div class="text-center">
                        <span class="font-semibold text-gray-900">
                            <span>Sei già registrato?</span>
                            <a class="inline-block ml-1 text-primary-700 hover:text-primary-500"
                                href="{{ route('login') }}">Accedi</a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </section>

</x-layouts.fullpage>

