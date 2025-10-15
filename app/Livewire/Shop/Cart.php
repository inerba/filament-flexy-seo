<?php

namespace App\Livewire\Shop;

use App\Actions\Shop\CreateStripeCheckoutSession;
use Database\Factories\CartFactory;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Cart extends Component
{
    public function checkout(CreateStripeCheckoutSession $checkoutSession)
    {
        $checkout = $checkoutSession->createFromCart($this->cart);

        return redirect()->to($checkout->url);

    }

    #[Computed]
    public function cart()
    {
        return CartFactory::make()->loadMissing(['items', 'items.product', 'items.product.book', 'items.product.book.media']);
    }

    #[Computed]
    public function items()
    {
        return $this->cart->items;
    }

    public function delete($itemId)
    {
        $cart = $this->cart;
        $cart->items()->where('id', $itemId)->delete();
        $this->dispatch('cartUpdated', [
            'type' => 'success',
            'message' => 'Elemento eliminato dal carrello',
            'confirm' => true,
        ]);
    }

    public function confirmDelete($itemId)
    {
        $this->dispatch('confirmAction', [
            'type' => 'warning',
            'message' => 'Sei sicuro di voler rimuovere questo elemento dal carrello?',
            'confirmText' => 'Sì, rimuovilo',
            'onConfirmed' => 'delete',
            'params' => [$itemId],
        ]);
    }

    public function incrementQuantity($itemId)
    {
        CartFactory::make()->items()->find($itemId)?->increment('quantity');

        $this->dispatch('cartUpdated');
    }

    public function decrementQuantity($itemId)
    {
        $item = CartFactory::make()->items()->find($itemId);

        if ($item->quantity > 1) {
            $item->decrement('quantity');
            $this->dispatch('cartUpdated');
        } else {
            $this->confirmDelete($itemId);
        }

    }

    public function render()
    {
        return view('livewire.shop.cart');
    }
}
