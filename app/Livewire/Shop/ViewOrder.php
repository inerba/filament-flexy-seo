<?php

namespace App\Livewire\Shop;

use Livewire\Attributes\Computed;
use Livewire\Component;

class ViewOrder extends Component
{
    public $orderId;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
    }

    #[Computed]
    public function order()
    {
        return auth('customer')->user()?->orders()->findOrFail($this->orderId);
    }

    public function render()
    {
        return view('livewire.shop.view-order');
    }
}
