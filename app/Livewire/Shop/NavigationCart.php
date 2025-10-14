<?php

namespace App\Livewire\Shop;

use Database\Factories\CartFactory;
use Livewire\Attributes\On;
use Livewire\Component;

class NavigationCart extends Component
{
    public string $class = '';

    #[On('cartUpdated')]
    public function getCountProperty()
    {
        return CartFactory::make()->items()->sum('quantity');
    }

    public function render()
    {
        return view('livewire.shop.navigation-cart');
    }
}
