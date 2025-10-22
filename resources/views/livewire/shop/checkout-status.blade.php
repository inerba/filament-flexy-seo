<div class="max-w-3xl mx-auto mt-12">
    <x-seo :title="'Conferma Ordine'" />
    @if ($this->order)
        <div role="alert" class="alert alert-success alert-dash alert-vertical sm:alert-horizontal text-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="stroke-success size-12 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Il tuo ordine è stato confermato!</span>
            <div>
                <a wire:navigate href="{{ route('shop.view-order', $this->order) }}"
                    class="btn btn-lg btn-primary font-display">Visualizza Ordine</a>
            </div>
        </div>
    @else
        <div wire:poll.5s role="alert"
            class="alert alert-warning alert-dash alert-vertical sm:alert-horizontal text-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="stroke-warning size-12 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                </path>
            </svg>
            <span>In attesa per la conferma di pagamento, attendi prego...</span>
        </div>
    @endif
</div>

