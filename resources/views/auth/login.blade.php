<x-layouts.fullpage>

    <section class="relative pt-6 px-4 lg:px-6 pb-20 md:pb-32 overflow-hidden min-h-screen bg-gray-50">
        <div class="relative max-w-7xl pt-12 sm:pt-28 mx-auto">
            <div class="relative container px-4 mx-auto">
                <div class="max-w-lg md:max-w-xl py-14 px-6 xs:px-12 lg:px-16 mx-auto bg-white rounded-4xl shadow-lg">
                    <h3 class="font-heading text-4xl text-gray-900 font-semibold mb-4">Accedi al tuo account</h3>
                    <p class="text-lg text-gray-500 mb-10">Bentornato! Ti chiediamo gentilmente di inserire i tuoi dati.
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
                    <form method="POST" action="{{ route('login') }}" class="font-display">
                        @csrf
                        <div class="mb-6">
                            <label class="block mb-1.5 text-sm text-gray-900 font-semibold" for="">Email</label>
                            <input
                                class="w-full py-3 px-4 text-sm text-gray-900 placeholder-gray-400 border border-gray-200 focus:border-purple-500 focus:outline-purple rounded-lg"
                                type="email" name="email" placeholder="Inserisci la tua email"
                                value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-7">
                            <div class="flex mb-1.5 items-center justify-between">
                                <label class="block text-sm text-gray-900 font-semibold" for="">Password</label>
                                <a class="inline-block text-xs font-semibold text-primary-700 hover:text-gray-900"
                                    href="{{ route('password.request') }}">Password dimenticata?</a>
                            </div>
                            <div class="relative" x-data="{ show: false }">
                                <input
                                    class="w-full py-3 px-4 text-sm text-gray-900 placeholder-gray-400 border border-gray-200 focus:border-purple-500 focus:outline-purple rounded-lg"
                                    :type="show ? 'text' : 'password'" name="password"
                                    placeholder="Inserisci la tua password">
                                <button type="button" @click="show = !show"
                                    class="absolute top-1/2 right-0 mr-3 transform -translate-y-1/2 inline-block hover:scale-110 transition duration-100">
                                    <template x-if="show">
                                        @svg('phosphor-eye-duotone', 'size-6')
                                    </template>
                                    <template x-if="!show">
                                        @svg('phosphor-eye-closed', 'size-6')
                                    </template>
                                </button>
                            </div>
                        </div>
                        <div class="flex mb-6 items-center">
                            <input type="checkbox" value="" id="">
                            <label class="ml-2 text-gray-800" for="">Ricordami per 30 giorni</label>
                        </div>
                        <button
                            class="relative cursor-pointer group block w-full mb-6 py-3 px-5 text-center text-sm font-semibold text-orange-50 bg-primary-700 rounded-full overflow-hidden"
                            type="submit">
                            <div
                                class="absolute top-0 right-full w-full h-full bg-primary-900 transform group-hover:translate-x-full group-hover:scale-102 transition duration-500">
                            </div>
                            <span class="relative text-xl">Accedi</span>
                        </button>
                        {{-- <a class="inline-flex w-full mb-20 py-3 px-4 items-center justify-center rounded-full border border-gray-200 hover:border-gray-400 transition duration-100"
                            href="#">
                            <img src="saturn-assets/images/sign-up/icon-apple.svg" alt="">
                            <span class="ml-4 text-sm font-semibold text-gray-900">Accedi con Apple</span>
                        </a> --}}
                        <div class="text-center">
                            <span class="font-semibold text-gray-900">
                                <span>Non hai un account?</span>
                                <a class="inline-block ml-1 text-primary-700 hover:text-primary-500"
                                    href="{{ route('register') }}">Registrati</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-layouts.fullpage>

