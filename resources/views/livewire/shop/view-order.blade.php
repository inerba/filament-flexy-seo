<div class="post-content" data-aos="fade-up">
    @php
        $statusValue =
            $this->order->status instanceof \BackedEnum ? $this->order->status->value : (string) $this->order->status;
    @endphp
    <x-seo :title="'Ordine #' . $this->order->id . ' - ' . $this->order->status->getLabel()" />
    <div class="prose max-w-7xl mx-auto">
        <div class="mx-auto pt-6 lg:pt-16 text-balance text-center flex items-center justify-between">
            <h1 class="leading-normal">Ordine #{{ $this->order->id }}</h1>
            <div @class([
                'badge badge-xl font-display uppercase',
                match ($statusValue) {
                    'pending' => 'badge-warning',
                    'on-hold' => 'badge-secondary',
                    'processing' => 'badge-info',
                    'completed' => 'badge-success',
                    'cancelled' => 'badge-error',
                    'refunded' => 'badge-accent',
                    'failed' => 'badge-neutral',
                    default => 'badge-secondary',
                },
            ])>
                {{ $this->order->status->getLabel() }}
            </div>
        </div>

        <div class="overflow-x-auto  mx-auto lg:pb-16">
            <div class="grid grid-cols-2 gap-4 lg:gap-8">
                <div class="card bg-base-200 shadow-sm lg:col-span-2">
                    <div class="card-body p-6">
                        <table class="table table-sm md:table-lg xl:table-xl not-prose">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>Prodotto</th>
                                    <th class="hidden lg:table-cell">Prezzo</th>
                                    <th class="text-right md:text-left">Quantità</th>
                                    <th class="text-right hidden md:table-cell">Totale</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->order->items as $item)
                                    <tr>
                                        <td>
                                            <a wire:navigate.hover href="{{ $item->product?->book->permalink }}"
                                                class="hover:underline flex items-center gap-4 ">
                                                <div class="size-16 flex-shrink-0 flex text-center md:block">
                                                    <img src="{{ $item->product?->book->getFirstMedia('covers')->getUrl('icon') }}"
                                                        alt="{{ $item->product?->name }}" class="h-16 inline">
                                                </div>
                                                <div>
                                                    {{ $item->product?->name }}
                                                    <span class="lg:hidden">
                                                        - {{ number_format($item->price, 2, ',', '.') }} €
                                                    </span>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="hidden lg:table-cell">
                                            {{ number_format($item->price, 2, ',', '.') }} €
                                        </td>
                                        <td class="">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="text-right hidden md:table-cell">
                                            {{ number_format($item->amount_subtotal, 2, ',', '.') }} €
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="md:text-lg xl:text-xl text-right">
                                @if ($this->order->amount_discount > 0)
                                    <tr>
                                        <th class="md:hidden">Sconto</th>
                                        <th colspan="2" class="hidden md:table-cell lg:hidden font-normal">Sconto
                                        </th>
                                        <th colspan="3" class="hidden lg:table-cell font-normal">Sconto</th>
                                        <th>-{{ number_format($this->order->amount_discount, 2, ',', '.') }} €</th>
                                    </tr>
                                @endif
                                @if ($this->order->amount_shipping > 0)
                                    <tr>
                                        <th class="md:hidden">Totale</th>
                                        <th colspan="2" class="hidden md:table-cell lg:hidden font-normal">Spese di
                                            spedizione
                                        </th>
                                        <th colspan="3" class="hidden lg:table-cell font-normal">Spese di spedizione
                                        </th>
                                        <th>{{ number_format($this->order->amount_shipping, 2, ',', '.') }} €</th>
                                    </tr>
                                @endif
                                <tr>
                                    <th class="md:hidden">Totale</th>
                                    <th colspan="2" class="hidden md:table-cell lg:hidden">Totale</th>
                                    <th colspan="3" class="hidden lg:table-cell">Totale</th>
                                    <th>{{ number_format($this->order->amount_total, 2, ',', '.') }} €</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card bg-base-200 shadow-sm">
                    <div class="card-body p-6">
                        <div class="text-lg font-semibold">Indirizzo di fatturazione</div>
                        @php $s = $this->order->billing_address ?? [] @endphp
                        <p class="mt-1">
                            @if (!empty($s['name']))
                                <span class="font-medium">{{ $s['name'] }}</span><br />
                            @endif
                            @if (!empty($s['line1']))
                                {{ $s['line1'] }}<br />
                            @endif
                            @if (!empty($s['line2']))
                                {{ $s['line2'] }}<br />
                            @endif
                            @if (!empty($s['postal_code']) || !empty($s['city']))
                                {{ $s['postal_code'] ?? '' }} {{ $s['city'] ?? '' }}<br />
                            @endif
                            @if (!empty($s['state']))
                                {{ $s['state'] }},
                            @endif
                            @if (!empty($s['country']))
                                {{ $s['country'] }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="card bg-base-200 shadow-sm">

                    <div class="card-body p-6">
                        <div class="text-lg font-semibold">Indirizzo di consegna</div>
                        @php $s = $this->order->shipping_address ?? [] @endphp
                        <p class="mt-1">
                            @if (!empty($s['name']))
                                <span class="font-medium">{{ $s['name'] }}</span><br />
                            @endif
                            @if (!empty($s['line1']))
                                {{ $s['line1'] }}<br />
                            @endif
                            @if (!empty($s['line2']))
                                {{ $s['line2'] }}<br />
                            @endif
                            @if (!empty($s['postal_code']) || !empty($s['city']))
                                {{ $s['postal_code'] ?? '' }} {{ $s['city'] ?? '' }}<br />
                            @endif
                            @if (!empty($s['state']))
                                {{ $s['state'] }},
                            @endif
                            @if (!empty($s['country']))
                                {{ $s['country'] }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

