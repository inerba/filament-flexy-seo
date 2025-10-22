<x-layouts.fullpage>
    <x-seo title="Verifica la tua email - CLUSTER-A" />
    <section class="relative pt-6 px-4 lg:px-6 pb-20 md:pb-32 overflow-hidden min-h-screen bg-gray-50">
        <div class="relative max-w-7xl pt-12 sm:pt-28 mx-auto">
            <div class="relative container px-4 mx-auto">
                <div class="max-w-lg md:max-w-xl py-14 px-6 xs:px-12 lg:px-16 mx-auto bg-white rounded-4xl shadow-lg">
                    <h3 class="font-heading text-4xl text-gray-900 font-semibold mb-4">Accedi al tuo account</h3>
                    <p class="text-lg text-gray-500 mb-10">Bentornato! Ti chiediamo gentilmente di inserire i tuoi dati.
                    </p>
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            Ti abbiamo inviato un nuovo link per la verifica dell'email!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}" class="font-display">
                        @csrf

                        <div class="mb-4 text-sm text-gray-600">
                            Grazie per esserti registrato! Prima di continuare, puoi verificare il tuo indirizzo email
                            cliccando sul link che ti abbiamo appena inviato? Se non hai ricevuto l'email, provvederemo
                            volentieri a inviartene un'altra.
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <button
                                class="relative cursor-pointer group block w-full mb-6 py-3 px-5 text-center text-sm font-semibold text-primary-content bg-primary rounded-full overflow-hidden"
                                type="submit">
                                <div
                                    class="absolute top-0 right-full w-full h-full bg-primary-700 transform group-hover:translate-x-full group-hover:scale-102 transition duration-500">
                                </div>
                                <span class="relative text-xl">Reinvia email di verifica</span>
                            </button>

                        </div>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            class="relative cursor-pointer group block w-full mb-6 py-3 px-5 text-center text-sm font-semibold text-primary rounded-full overflow-hidden"
                            type="submit">
                            <div
                                class="absolute top-0 right-full w-full h-full bg-gray-900 transform group-hover:translate-x-full group-hover:scale-102 transition duration-500">
                            </div>
                            <span class="relative text-xl">Esci</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </section>

</x-layouts.fullpage>

