<x-layouts.fullpage>
    <x-seo title="Accedi al tuo account - CLUSTER-A" />
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
                    <form method="POST" action="{{ route('password.confirm') }}" class="font-display">
                        @csrf

                        <div class="mb-7">
                            {{-- <div class="flex mb-1.5 items-center justify-between"> --}}
                            <label class="block text-sm text-gray-900 font-semibold" for="">Password</label>
                            {{-- <a class="inline-block text-xs font-semibold text-primary-700 hover:text-gray-900"
                                    href="{{ route('password.request') }}">Password dimenticata?</a>
                            </div> --}}
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

                        <button
                            class="relative cursor-pointer group block w-full mb-6 py-3 px-5 text-center text-sm font-semibold text-orange-50 bg-primary-700 rounded-full overflow-hidden"
                            type="submit">
                            <div
                                class="absolute top-0 right-full w-full h-full bg-primary-900 transform group-hover:translate-x-full group-hover:scale-102 transition duration-500">
                            </div>
                            <span class="relative text-xl">Conferma password</span>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </section>

</x-layouts.fullpage>

