<div>
    <form wire:submit.prevent="addToCart">
        <button class="btn btn-primary font-display">
            @svg('phosphor-basket-duotone', 'size-6')
            Aggiungi al carrello</button>
    </form>
</div>

@script
    <script type="text/javascript">
        $wire.on('cartUpdated', () => {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Prodotto aggiunto al carrello',
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
@endscript

