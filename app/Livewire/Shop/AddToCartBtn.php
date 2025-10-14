<?php

namespace App\Livewire\Shop;

use App\Actions\Shop\AddProductToCart;
use Livewire\Component;

class AddToCartBtn extends Component
{
    public $product;

    public function addToCart(AddProductToCart $cart)
    {
        $cart->add($this->product->id);

        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.shop.add-to-cart-btn');
    }
}
