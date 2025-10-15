<div>
    <div class="overflow-x-auto">
        <table class="table table-sm md:table-lg xl:table-xl">
            <!-- head -->
            <thead>
                <tr>
                    <th>Prodotto</th>
                    <th class="hidden lg:table-cell">Prezzo</th>
                    <th class="text-right md:text-left">Quantità</th>
                    <th class="text-right hidden md:table-cell">Totale</th>
                    <th class="hidden lg:table-cell"></th>
                </tr>
            </thead>
            <tbody>

                @if ($this->items->count() == 0)
                    <tr>
                        <td colspan="4" class="text-center text-2xl py-12">
                            Il carrello è vuoto
                        </td>
                    </tr>
                @endif

                @foreach ($this->items as $item)
                    <tr class="">
                        <td>
                            <a href="{{ $item->product?->book->permalink }}"
                                class="hover:underline flex items-center gap-4 ">
                                <div class="h-16 flex-shrink-0 hidden md:block">
                                    <img src="{{ $item->product?->book->getFirstMedia('covers')->getUrl('icon') }}"
                                        alt="{{ $item->product?->name }}" class="h-16 object-cover rounded">
                                </div>
                                <div>
                                    {{ $item->product?->name }}
                                    <span class="lg:hidden">
                                        - {{ number_format($item->product?->price, 2, ',', '.') }} €
                                    </span>
                                </div>
                            </a>
                        </td>
                        <td class="hidden lg:table-cell">
                            {{ number_format($item->product?->price, 2, ',', '.') }} €
                        </td>
                        <td class="">
                            <div class="flex items-center justify-end md:justify-start gap-2">
                                <button wire:click="decrementQuantity({{ $item->id }})" class="btn btn-xs btn-link">
                                    @svg('phosphor-minus-bold', 'size-3 md:size-5')
                                </button>
                                {{ $item->quantity }}
                                <button wire:click="incrementQuantity({{ $item->id }})" class="btn btn-xs btn-link">
                                    @svg('phosphor-plus-bold', 'size-3 md:size-5')
                                </button>
                            </div>
                        </td>
                        <td class="text-right hidden md:table-cell">
                            {{ number_format($item->subtotal, 2, ',', '.') }} €
                        </td>
                        <td class="text-right hidden md:table-cell">
                            <button wire:click="confirmDelete({{ $item->id }})"
                                class="btn btn-sm btn-danger btn-link">
                                @svg('phosphor-trash-duotone', 'size-5')
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            @if ($this->items->count() > 0)
                <tfoot class="md:text-lg xl:text-xl text-right">
                    <tr>
                        <th class="md:hidden">Totale</th>
                        <th colspan="2" class="hidden md:table-cell lg:hidden">Totale</th>
                        <th colspan="3" class="hidden lg:table-cell">Totale</th>
                        <th>{{ number_format($this->cart->total, 2, ',', '.') }} €</th>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
    @if ($this->items->count() > 0)
        <div class="text-center my-12">
            @guest('customer')
                <div class="alert alert-info text-xl mb-4 max-w-3xl alert-vertical text-white mx-auto">
                    Ti devi registrare o accedere per procedere con l'ordine
                    <div class="mt-4 flex justify-center gap-4">
                        <a href="{{ route('register') }}" class="btn btn-primary">Registrati</a>
                        <a href="{{ route('login') }}" class="btn btn-outline">Accedi</a>
                    </div>
                </div>
            @endguest
            @auth('customer')
                <button wire:click="checkout" class="btn btn-primary btn-xl">Effettua il checkout</button>
            @endauth
        </div>
    @endif
</div>
@script
    <script type="text/javascript">
        $wire.on('cartUpdated', (data) => {
            $wire.$refresh();
        });
        $wire.on('confirmAction', (data) => {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: data[0].message,
                showCancelButton: true,
                confirmButtonText: data[0].confirmText,
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.call(data[0].onConfirmed, ...data[0].params);
                }
            });
        });
    </script>
@endscript

