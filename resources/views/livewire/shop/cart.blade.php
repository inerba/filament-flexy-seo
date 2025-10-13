<div class="overflow-x-auto">
    <table class="table">
        <!-- head -->
        <thead>
            <tr>
                <th>Prodotto</th>
                <th class="">Prezzo</th>
                <th class="">Quantità</th>
                <th class="text-right">Totale</th>
            </tr>
        </thead>
        <tbody>
            <!-- row 1 -->
            @forelse ($this->items as $item)
                <tr>
                    <td class="">
                        <a href="{{ $item->product->book->permalink }}"
                            class="hover:underline flex items-center gap-4 text-xl">
                            <div class="h-16 flex-shrink-0 hidden md:block">
                                <img src="{{ $item->product->book->getFirstMedia('covers')->getUrl('icon') }}"
                                    alt="{{ $item->product->name }}" class="h-16 object-cover rounded">
                            </div>
                            {{ $item->product->name }}
                        </a>
                    </td>
                    <td class="text-xl">
                        {{ number_format($item->product->price, 2, ',', '.') }} €
                    </td>
                    <td class="text-xl">
                        <div class="flex items-center">
                            <button wire:click="decrementQuantity({{ $item->id }})" class="btn btn-sm btn-link">
                                @svg('phosphor-minus-bold', 'size-5')
                            </button>
                            {{ $item->quantity }}
                            <button wire:click="incrementQuantity({{ $item->id }})" class="btn btn-sm btn-link">
                                @svg('phosphor-plus-bold', 'size-5')
                            </button>
                        </div>
                    </td>
                    <td class="text-xl text-right">
                        {{ number_format($item->subtotal, 2, ',', '.') }} €
                    </td>
                    <td>
                        <button wire:click="confirmDelete({{ $item->id }})" class="btn btn-sm btn-error btn-link">
                            @svg('phosphor-trash-duotone', 'size-5')
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-2xl">
                        Il carrello è vuoto
                    </td>
                </tr>
            @endforelse
        </tbody>
        <!-- foot -->
        <tfoot>
            <tr>
                <th colspan="3" class="text-xl text-right">Totale</th>
                <th class="text-xl text-right">{{ number_format($this->cart->total, 2, ',', '.') }} €</th>
            </tr>
        </tfoot>
    </table>
</div>
@script
    <script type="text/javascript">
        $wire.on('cartUpdated', (data) => {

            // only if data is defined
            if (data && data.length > 0) {

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: data[0].message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
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

