<?php

namespace App\Models;

use App\Traits\HasMoneyCasts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasMoneyCasts;

    protected $guarded = ['id'];

    protected function price(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return $this->moneyCast();
    }

    protected function amountTotal(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return $this->moneyCast();
    }

    protected function amountSubtotal(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return $this->moneyCast();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
