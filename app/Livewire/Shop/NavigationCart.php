<?php

namespace App\Livewire\Shop;

use Database\Factories\CartFactory;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class NavigationCart extends Component
{
    public string $class = '';

    #[On('cartUpdated'), Computed]
    public function count()
    {
        return CartFactory::make()->items()->sum('quantity');
    }

    public function render()
    {
        return view('livewire.shop.navigation-cart');
    }
}
