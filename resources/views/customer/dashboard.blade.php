<x-layouts.base>

    <div class="grid grid-cols-3 gap-6 prose lg:prose-lg max-w-3xl mx-auto">
        {{-- <div class="">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum dolorum error nihil quidem vitae temporibus
            culpa, eos magni magnam alias sed incidunt vel excepturi necessitatibus tempora fuga vero voluptatum saepe!
        </div> --}}
        <div class="col-span-3 border p-6 shadow-lg rounded-lg">
            <h2 class="mt-0!">Modifica informazioni di base</h2>
            @if (session('status'))
                @php
                    $message = match (session('status')) {
                        'profile-information-updated' => 'Profilo aggiornato con successo.',
                        'password-updated' => 'Password aggiornata con successo.',
                    };
                @endphp
                <div role="alert" class="alert alert-success mb-6" x-data="{ show: true }" x-show="show"
                    x-init="setTimeout(() => show = false, 4000)" <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            @endif
            <form method="post" action="{{ route('user-profile-information.update') }}" class="font-display">
                @csrf
                @method('PUT')
                <x-dui.field label="Nome e Cognome" name="name" type="text" placeholder="Inserisci il tuo nome"
                    value="{{ auth('customer')->user()->name }}"
                    error="{{ $errors->updateProfileInformation->first('name') ?? '' }}" />
                <div class="grid grid-cols-2 mt-2 gap-6">

                    <x-dui.field label="Email" name="email" type="email" placeholder="Inserisci la tua email"
                        value="{{ auth('customer')->user()->email }}"
                        error="{{ $errors->updateProfileInformation->first('email') ?? '' }}" />
                    <x-dui.field label="Telefono" name="phone" type="text" placeholder="Inserisci il tuo telefono"
                        value="{{ auth('customer')->user()->phone }}"
                        error="{{ $errors->updateProfileInformation->first('phone') ?? '' }}" />
                </div>

                <h3 class="">Informazioni di spedizione</h3>
                <x-dui.field label="Indirizzo" name="address[street]" type="text"
                    placeholder="Inserisci il tuo indirizzo"
                    value="{{ auth('customer')->user()->address['street'] ?? '' }}"
                    error="{{ $errors->updateProfileInformation->first('address.street') ?? '' }}" />
                <div class="grid grid-cols-2 gap-6 mt-2">
                    <x-dui.field label="Città" name="address[city]" type="text" placeholder="Inserisci la tua città"
                        value="{{ auth('customer')->user()->address['city'] ?? '' }}"
                        error="{{ $errors->updateProfileInformation->first('address.city') ?? '' }}" />

                    <x-dui.field label="CAP" name="address[postal_code]" type="text"
                        placeholder="Inserisci il CAP"
                        value="{{ auth('customer')->user()->address['postal_code'] ?? '' }}"
                        error="{{ $errors->updateProfileInformation->first('address.postal_code') ?? '' }}" />

                    <x-dui.field label="Provincia" name="address[province]" type="text"
                        placeholder="Inserisci la tua provincia"
                        value="{{ auth('customer')->user()->address['province'] ?? '' }}"
                        error="{{ $errors->updateProfileInformation->first('address.province') ?? '' }}" />

                    <x-dui.field label="Nazione" name="address[country]" type="text"
                        placeholder="Inserisci la tua nazione"
                        value="{{ auth('customer')->user()->address['country'] ?? '' }}"
                        error="{{ $errors->updateProfileInformation->first('address.country') ?? '' }}" />
                </div>

                <button class="btn btn-primary mt-4 btn-lg" type="submit">
                    Aggiorna i dati
                </button>
            </form>

            <div class="divider my-10"></div>

            <form method="POST" action="{{ route('user-password.update') }}" class="font-display">
                @csrf
                @method('PUT')
                <h2 class="mt-0">Modifica password</h2>
                @if ($errors->updatePassword->any())
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->updatePassword->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <x-dui.field label="Password attuale" name="current_password" type="password"
                    placeholder="Inserisci la tua password attuale"
                    error="{{ $errors->updatePassword->first('current_password') ?? '' }}" />

                <div class="grid grid-cols-2 gap-6 mt-2">

                    <x-dui.field label="Nuova password" name="password" type="password"
                        placeholder="Inserisci la tua nuova password"
                        error="{{ $errors->updatePassword->first('password') ?? '' }}" />

                    <x-dui.field label="Conferma nuova password" name="password_confirmation" type="password"
                        placeholder="Conferma la tua nuova password"
                        error="{{ $errors->updatePassword->first('password_confirmation') ?? '' }}" />

                </div>

                <button class="btn btn-primary mt-4 btn-lg" type="submit">
                    Aggiorna password
                </button>
            </form>
        </div>
    </div>

</x-layouts.base>
