<?php

namespace App\Livewire;

use Livewire\Component;

class StoreFront extends Component
{
    public function getProductsProperty()
    {
        return \App\Models\Product::query()->get();
    }

    public function render()
    {
        return view('livewire.store-front');
    }
}
