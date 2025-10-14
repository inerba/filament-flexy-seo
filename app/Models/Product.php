<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $price
 */
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: function (int $value) {
                return $value / 100;
            },
            set: function ($value) {
                return (int) ($value * 100);
            },
        );
    }

    public function variants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function book(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Book::class);
    }
}
